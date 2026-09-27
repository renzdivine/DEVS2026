<?php
class TeamMembers {
    private $conn;
    private $table = "team_members";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll($status = null) {
        $query = "SELECT * FROM {$this->table}";
        if ($status !== null) {
            $query .= " WHERE member_status = ? ORDER BY display_order ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $status);
        } else {
            $query .= " ORDER BY display_order ASC";
            $stmt = $this->conn->prepare($query);
        }
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getBySlug($slug) {
        $query = "SELECT * FROM {$this->table} WHERE member_slug = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $slug);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE member_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data) {
        $query = "INSERT INTO {$this->table} (member_name, member_slug, member_role, member_photo, member_short_bio, member_full_bio, member_github, member_linkedin, member_facebook, member_instagram, member_email, member_skills, member_status, display_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssssssssssii", $data['name'], $data['slug'], $data['role'], $data['photo'], $data['short_bio'], $data['full_bio'], $data['github'], $data['linkedin'], $data['facebook'], $data['instagram'], $data['email'], $data['skills'], $data['status'], $data['display_order']);
        $stmt->execute();
        return $this->conn->insert_id;
    }

    public function update($id, $data) {
        $query = "UPDATE {$this->table} SET member_name = ?, member_slug = ?, member_role = ?, member_photo = ?, member_short_bio = ?, member_full_bio = ?, member_github = ?, member_linkedin = ?, member_facebook = ?, member_instagram = ?, member_email = ?, member_skills = ?, member_status = ?, display_order = ? WHERE member_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssssssssssiii", $data['name'], $data['slug'], $data['role'], $data['photo'], $data['short_bio'], $data['full_bio'], $data['github'], $data['linkedin'], $data['facebook'], $data['instagram'], $data['email'], $data['skills'], $data['status'], $data['display_order'], $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE member_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function getSkills($memberId) {
        $query = "SELECT s.* FROM skills s JOIN team_member_skills tms ON s.skill_id = tms.skill_id WHERE tms.member_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $memberId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getConn() {
        return $this->conn;
    }
}
