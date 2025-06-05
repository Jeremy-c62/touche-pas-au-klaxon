<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;
    public $conn;

  public function __construct() {
    $envPath = dirname(__DIR__, 2) . '/.env';

    if (file_exists($envPath)) {
        $env = parse_ini_file($envPath);
        $this->host = $env['DB_HOST'] ?? 'localhost';
        $this->db_name = $env['DB_NAME'] ?? 'covoiturage';
        $this->username = $env['DB_USER'] ?? 'root';
        $this->password = $env['DB_PASS'] ?? '';
    } else {
        die('Fichier .env introuvable');
    }
}



    public function connect() {
        $this->conn = null;
        try {
            $this->conn = new PDO(
                'mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username, $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
        return $this->conn;
    }
}
