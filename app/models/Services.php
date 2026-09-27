<?php
class Services {
    private $conn;
    private $table = "services";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM {$this->table} WHERE service_status = 1 ORDER BY display_order ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE service_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function create($data) {
        $query = "INSERT INTO {$this->table} (service_name, service_description, service_icon, service_technologies, service_status, display_order) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssii", $data['name'], $data['description'], $data['icon'], $data['technologies'], $data['status'], $data['display_order']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE {$this->table} SET service_name = ?, service_description = ?, service_icon = ?, service_technologies = ?, service_status = ?, display_order = ? WHERE service_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssiii", $data['name'], $data['description'], $data['icon'], $data['technologies'], $data['status'], $data['display_order'], $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE service_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function reorder($id, $order) {
        $query = "UPDATE {$this->table} SET display_order = ? WHERE service_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ii", $order, $id);
        return $stmt->execute();
    }
}
