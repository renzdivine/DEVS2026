<?php
class ProjectImages {
    private $conn;
    private $table = "project_images";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function add($projectId, $path, $order = 0) {
        $query = "INSERT INTO {$this->table} (project_id, image_path, display_order) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("isi", $projectId, $path, $order);
        return $stmt->execute();
    }

    public function getByProjectId($projectId) {
        $query = "SELECT * FROM {$this->table} WHERE project_id = ? ORDER BY display_order ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $projectId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function deleteByProjectId($projectId) {
        $query = "DELETE FROM {$this->table} WHERE project_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $projectId);
        return $stmt->execute();
    }

    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE image_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE image_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}

class ProjectMembers {
    private $conn;
    private $table = "project_members";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function assign($projectId, $memberId) {
        $query = "INSERT INTO {$this->table} (project_id, member_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $projectId, $memberId);
        return $stmt->execute();
    }

    public function getByProjectId($projectId) {
        $query = "SELECT tm.* FROM team_members tm JOIN project_members pm ON tm.member_id = pm.member_id WHERE pm.project_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $projectId);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function removeByProjectId($projectId) {
        $query = "DELETE FROM {$this->table} WHERE project_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $projectId);
        return $stmt->execute();
    }
}

class ProjectSkills {
    private $conn;
    private $table = "project_skills";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function assign($projectId, $skillId) {
        $query = "INSERT INTO {$this->table} (project_id, skill_id) VALUES (?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $projectId, $skillId);
        return $stmt->execute();
    }

    public function removeByProjectId($projectId) {
        $query = "DELETE FROM {$this->table} WHERE project_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $projectId);
        return $stmt->execute();
    }
}
