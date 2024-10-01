<?php


// Клас для підключення до бази даних
class Database {
    private $host = '127.0.0.1';
    private $db = 'user_data';
    private $user = 'postgres';
    private $pass = 'your_password';
    private $port = '5432';
    private $charset = 'utf8';
    private $pdo;

    public function __construct() {
        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db};user={$this->user};password={$this->pass}";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getPDO() {
        return $this->pdo;
    }
}
