<?php


class User {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function createUser($name, $email) {
        if (!empty($name) && !empty($email)) {
            $stmt = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
            $stmt->execute(['name' => $name, 'email' => $email]);
            return "Користувача успішно додано!";
        } else {
            return "Будь ласка, заповніть всі поля!";
        }
    }
}
