<?php
// config/database.php
class Database {
    private $host = 'localhost';
    private $db_name = 'db_teste';
    private $username = 'root';
    private $password = 'L30N4rdo078%27';
    public $conn;

    public function connect() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            echo "Erro de conexão: " . $e->getMessage();
        }

        return $this->conn;
    }
}
