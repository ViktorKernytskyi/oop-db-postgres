<?php

class User {
    private $pdo;
    /** Class constructor */
    // Конструктор класу
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    /** Method for adding a new user */
    // Метод для додавання нового користувача
    public function addUser($firstName, $lastName, $email, $phone) {
        $stmt = $this->pdo->prepare("INSERT INTO users (first_name, last_name, email, phone) VALUES (:first_name, :last_name, :email, :phone)");
        $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);

        if ($stmt->execute()) {
            return "User successfully added - Користувача успішно додано.";
        } else {
            return "Error adding user - Помилка при додаванні користувача.";
        }
    }
    /** Method to get user by ID */
    // Метод для отримання користувача за ID
    public function getUser($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    /** A method to update a user */
    // Метод для оновлення користувача
    public function updateUser($id, $firstName, $lastName, $email, $phone) {
        $stmt = $this->pdo->prepare("UPDATE users SET first_name = :first_name, last_name = :last_name, email = :email, phone = :phone WHERE id = :id");
        $stmt->bindParam(':first_name', $firstName, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $lastName, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "User data updated successfully - Дані користувача успішно оновлено.";
        } else {
            return "Error updating user data - Помилка при оновленні даних користувача.";
        }
    }
    /** A method to delete a user */
    // Метод для видалення користувача
    public function deleteUser($id) {
        $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return "User deleted successfully - Користувача успішно видалено.";
        } else {
            return "Error deleting user - Помилка при видаленні користувача.";
        }
    }
    /** Method to get all users */
    // Метод для отримання всіх користувачів
    public function getAllUsers() {
        $stmt = $this->pdo->query("SELECT * FROM users");
        return $stmt->fetchAll();
    }
    /** Method to get users by name */
    // Метод для отримання користувачів за ім'ям
    public function getUsersByName($name) {
        $stmt = $this->pdo->prepare("SELECT id, first_name, last_name, email FROM users WHERE first_name = :name");
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // We return the results in the form of an associative array - Повертаємо результати у вигляді асоціативного масиву
    }
}

