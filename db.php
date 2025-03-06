<?php
class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = "localhost";
        $dbname = "flower_store";
        $username = "root";
        $password = "";

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->pdo;
    }
}


// $pdo = Database::getInstance()->getConnection();
?>
