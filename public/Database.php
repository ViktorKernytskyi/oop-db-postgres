<?php

// Включення відображення помилок
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "hi world" . '<br>';
require_once 'config.php'; // Підключення конфігурацій
class Database {

    private $pdo; // Об'єкт PDO для роботи з базою даних
    private $table; // Назва таблиці для роботи
    private $select = '*'; // Поля, які вибираємо
    private $params = []; // Параметри для запитів

    public function __construct($dsn, $user, $password, $opt)
    {

        $this->connect($dsn, $user, $password, $opt); // Підключаємось до бази при створенні об'єкта класу
    }

    /**
     * Метод підключення до бази даних через PDO
     */
    protected function connect($dsn, $user, $password, $opt)
    {
        echo "Файл конфігурації підключено успішно!<br>";
        var_dump($dsn, $user, $password); // Виводимо змінні з конфігурації
        try {
            echo "Спроба підключення...<br>";
            // Підключення до бази даних через PDO
            $this->pdo = new PDO($dsn, $user, $password, $opt);
            echo "З'єднання з базою даних успішне!<br>";
        } catch (PDOException $e) {
            // Виводимо помилку, якщо щось пішло не так
            echo "Помилка підключення: " . $e->getMessage() . "<br>";
        }

    }


}

// Створення об'єкта класу Database
$db = new Database($dsn, $user, $password, $opt);
