    <?php
    class Inquiries {
        private $conn;
        private $table = "project_inquiries";

        public function __construct($db) {
            $this->conn = $db;
        }

        public function getAll() {
            $query = "SELECT * FROM {$this->table} ORDER BY inquiry_created_at DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        public function getById($id) {
            $query = "SELECT * FROM {$this->table} WHERE inquiry_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        public function create($data) {
            $query = "INSERT INTO {$this->table} (inquiry_name, inquiry_email, inquiry_phone, inquiry_company, inquiry_project_type, inquiry_budget_range, inquiry_description, inquiry_preferred_contact, inquiry_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("sssssssss", $data['name'], $data['email'], $data['phone'], $data['company'], $data['project_type'], $data['budget'], $data['description'], $data['preferred_contact'], $data['status']);
            return $stmt->execute();
        }

        public function updateStatus($id, $status) {
            $query = "UPDATE {$this->table} SET inquiry_status = ? WHERE inquiry_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("si", $status, $id);
            return $stmt->execute();
        }

        public function getStats() {
            $query = "SELECT COUNT(*) as total, SUM(CASE WHEN inquiry_status = 'New' THEN 1 ELSE 0 END) as new, SUM(CASE WHEN inquiry_status = 'Contacted' THEN 1 ELSE 0 END) as contacted, SUM(CASE WHEN inquiry_status = 'In Discussion' THEN 1 ELSE 0 END) as discussion FROM {$this->table}";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        /**
         * Returns one row per unique email - the latest inquiry from that contact.
         * Includes unread count (status = 'New') and total message count.
         */
        public function getGroupedByEmail() {
            $query = "
                SELECT
                    i.*,
                    COUNT(i2.inquiry_id) AS total_inquiries,
                    SUM(CASE WHEN i2.inquiry_status = 'New' THEN 1 ELSE 0 END) AS unread_count
                FROM {$this->table} i
                INNER JOIN (
                    SELECT inquiry_email, MAX(inquiry_created_at) AS latest
                    FROM {$this->table}
                    GROUP BY inquiry_email
                ) latest ON i.inquiry_email = latest.inquiry_email
                        AND i.inquiry_created_at = latest.latest
                INNER JOIN {$this->table} i2 ON i2.inquiry_email = i.inquiry_email
                GROUP BY i.inquiry_email
                ORDER BY i.inquiry_created_at DESC
            ";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * Get all inquiries from a specific email address.
         */
        public function getByEmail(string $email) {
            $query = "SELECT * FROM {$this->table} WHERE inquiry_email = ? ORDER BY inquiry_created_at ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        /**
         * Get the latest inquiry row for a given email.
         */
        public function getLatestByEmail(string $email) {
            $query = "SELECT * FROM {$this->table} WHERE inquiry_email = ? ORDER BY inquiry_created_at DESC LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }
    }

    class InquiryReplies {
        private $conn;
        private $table = "inquiry_replies";

        public function __construct($db) {
            $this->conn = $db;
        }

        public function add(int $inquiryId, string $direction, string $subject, string $message): bool {
            $query = "INSERT INTO {$this->table} (inquiry_id, direction, reply_subject, reply_message) VALUES (?, ?, ?, ?)";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("isss", $inquiryId, $direction, $subject, $message);
            return $stmt->execute();
        }

        /**
         * Get all replies for every inquiry belonging to a given email, in chronological order.
         */
        public function getByEmail(string $email): array {
            $query = "
                SELECT r.*
                FROM {$this->table} r
                INNER JOIN project_inquiries i ON r.inquiry_id = i.inquiry_id
                WHERE i.inquiry_email = ?
                ORDER BY r.replied_at ASC
            ";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }

        public function getByInquiryId(int $inquiryId): array {
            $query = "SELECT * FROM {$this->table} WHERE inquiry_id = ? ORDER BY replied_at ASC";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("i", $inquiryId);
            $stmt->execute();
            return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        }
    }

    class Availability {
        private $conn;
        private $table = "availability";

        public function __construct($db) {
            $this->conn = $db;
        }

        public function get() {
            $query = "SELECT * FROM {$this->table} ORDER BY availability_id DESC LIMIT 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        public function update($id, $status) {
            $query = "UPDATE {$this->table} SET availability_status = ? WHERE availability_id = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("si", $status, $id);
            return $stmt->execute();
        }
    }

    class AdminUser {
        private $conn;
        private $table = "admins";

        public function __construct($db) {
            $this->conn = $db;
        }

        public function getByUsername($username) {
            $query = "SELECT * FROM {$this->table} WHERE admin_username = ?";
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param("s", $username);
            $stmt->execute();
            return $stmt->get_result()->fetch_assoc();
        }

        public function verifyPassword($password, $hash) {
            return password_verify($password, $hash);
        }
    }
