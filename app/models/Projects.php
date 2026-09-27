<?php
class Projects {
    private $conn;
    private $table = "projects";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll($status = null) {
        $query = "SELECT p.*, GROUP_CONCAT(DISTINCT s.skill_name SEPARATOR ', ') as technologies FROM {$this->table} p LEFT JOIN project_skills ps ON p.project_id = ps.project_id LEFT JOIN skills s ON ps.skill_id = s.skill_id";
        $params = [];
        $types = "";
        if ($status !== null) {
            $query .= " WHERE p.project_status = ?";
            $params[] = $status;
            $types = "i";
        }
        $query .= " GROUP BY p.project_id ORDER BY p.project_created_at DESC";
        $stmt = $this->conn->prepare($query);
        if ($params) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getBySlug($slug) {
        $query = "SELECT p.*, GROUP_CONCAT(DISTINCT s.skill_name SEPARATOR ', ') as technologies FROM {$this->table} p LEFT JOIN project_skills ps ON p.project_id = ps.project_id LEFT JOIN skills s ON ps.skill_id = s.skill_id WHERE p.project_slug = ? GROUP BY p.project_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE project_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getByMemberId($memberId) {
        $query = "SELECT p.*, GROUP_CONCAT(DISTINCT s.skill_name SEPARATOR ', ') as technologies
                  FROM {$this->table} p
                  JOIN project_members pm ON p.project_id = pm.project_id
                  LEFT JOIN project_skills ps ON p.project_id = ps.project_id
                  LEFT JOIN skills s ON ps.skill_id = s.skill_id
                  WHERE pm.member_id = ? AND p.project_status = 1
                  GROUP BY p.project_id ORDER BY p.project_created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $memberId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO {$this->table} (project_name, project_slug, project_description, project_long_description, project_dev_story, project_category, project_featured_image, project_gallery, project_features, project_github_url, project_live_url, project_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "sssssssssssi",
            $data['name'],
            $data['slug'],
            $data['description'],
            $data['long_description'],
            $data['dev_story'],
            $data['category'],
            $data['featured_image'],
            $data['gallery'],
            $data['features'],
            $data['github_url'],
            $data['live_url'],
            $data['status']
        );
        $stmt->execute();
        return $this->conn->insert_id;
    }

    public function update($id, $data) {
        $existing = $this->getById($id);
        if (!$existing) {
            return false;
        }
        $query = "UPDATE {$this->table} SET project_name = ?, project_slug = ?, project_description = ?, project_long_description = ?, project_dev_story = ?, project_category = ?, project_featured_image = ?, project_gallery = ?, project_features = ?, project_github_url = ?, project_live_url = ?, project_status = ? WHERE project_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param(
            "sssssssssssii",
            $data['name'],
            $data['slug'],
            $data['description'],
            $data['long_description'],
            $data['dev_story'],
            $data['category'],
            $data['featured_image'],
            $data['gallery'],
            $data['features'],
            $data['github_url'],
            $data['live_url'],
            $data['status'],
            $id
        );
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE project_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getSkills($projectId) {
        $query = "SELECT s.* FROM skills s JOIN project_skills ps ON s.skill_id = ps.skill_id WHERE ps.project_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $projectId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getMembers($projectId) {
        $query = "SELECT tm.* FROM team_members tm JOIN project_members pm ON tm.member_id = pm.member_id WHERE pm.project_id = ? ORDER BY tm.display_order ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $projectId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getConn() {
        return $this->conn;
    }

    public function getImages($projectId) {
        $query = "SELECT * FROM project_images WHERE project_id = ? ORDER BY display_order ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $projectId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
