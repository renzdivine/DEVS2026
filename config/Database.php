<?php
require_once __DIR__ . '/../app/helpers.php';

class Database {
    private $host;
    private $user;
    private $pass;
    private $dbname;

    public $conn;

    public function __construct() {
        $env = self::loadEnv();
        $this->host = getenv('DB_HOST') ?: ($env['DB_HOST'] ?? 'localhost');
        $this->user = getenv('DB_USER') ?: ($env['DB_USER'] ?? 'root');
        $this->pass = getenv('DB_PASS') !== false ? getenv('DB_PASS') : ($env['DB_PASS'] ?? '');
        $this->dbname = getenv('DB_NAME') ?: ($env['DB_NAME'] ?? 'db_devs');
    }

    private static function loadEnv() {
        static $env = null;
        if ($env !== null) {
            return $env;
        }
        $env = [];
        $path = __DIR__ . '/.env';
        if (is_readable($path)) {
            $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                $line = trim($line);
                if ($line === '' || $line[0] === '#') continue;
                $pos = strpos($line, '=');
                if ($pos === false) continue;
                $key = trim(substr($line, 0, $pos));
                $value = trim(substr($line, $pos + 1));
                if (strlen($value) >= 2 && ($value[0] === '"' || $value[0] === "'") && $value[0] === substr($value, -1)) {
                    $value = substr($value, 1, -1);
                }
                $env[$key] = $value;
            }
        }
        return $env;
    }

    public function connect() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        try {
            $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
            $this->conn->set_charset('utf8mb4');
        } catch (mysqli_sql_exception $e) {
            http_response_code(500);
            die('Database connection failed. Check config/.env and that MySQL is running.');
        }
        return $this->conn;
    }
}
