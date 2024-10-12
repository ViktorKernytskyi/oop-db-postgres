<?php

class User {
    private $pdo;

    // Конструктор класу
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Метод для додавання нового користувача
    public function addUser($firstName, $lastName, $email, $phone) {
        $stmt = $this->pdo->prepare("INSERT INTO users (first_name, last_name, email, phone) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$firstName, $lastName, $email, $phone])) {
            return "Користувача успішно додано.";
        } else {
            return "Помилка при додаванні користувача.";
        }
    }

    // Метод для отримання користувача за ID
    public function getUser($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    // Метод для оновлення користувача
    public function updateUser($id, $firstName, $lastName, $email, $phone) {
        $stmt = $this->pdo->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, phone = ? WHERE id = ?");
        if ($stmt->execute([$firstName, $lastName, $email, $phone, $id])) {
            return "Дані користувача успішно оновлено.";
        } else {
            return "Помилка при оновленні даних користувача.";
        }
    }

    // Метод для видалення користувача
    public function deleteUser($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = ?");
        if ($stmt->execute([$id])) {
            return "Користувача успішно видалено.";
        } else {
            return "Помилка при видаленні користувача.";
        }
    }

    // Метод для отримання всіх користувачів
    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }
}

