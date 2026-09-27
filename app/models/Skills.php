<?php
class Skills {
    private $conn;
    private $table = "skills";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY skill_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getByCategory($category) {
        $query = "SELECT * FROM {$this->table} WHERE skill_category = ? ORDER BY skill_name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $category);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE skill_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data) {
        $query = "INSERT INTO {$this->table} (skill_name, skill_category, skill_description, skill_icon) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssss", $data['name'], $data['category'], $data['description'], $data['icon']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE {$this->table} SET skill_name = ?, skill_category = ?, skill_description = ?, skill_icon = ? WHERE skill_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssi", $data['name'], $data['category'], $data['description'], $data['icon'], $data['id']);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE skill_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
