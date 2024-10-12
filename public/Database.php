<?php

// Включення відображення помилок
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//echo "hi world" . '<br>';
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
       // var_dump($dsn, $user, $password); // Виводимо змінні з конфігурації
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


    /**
     * Вказуємо таблицю для операцій
     */
    public function table($name)
    {
        $this->table = $name;
        return $this;
    }

    /**
     * Вибираємо поля для запиту
     */
    public function select(...$names)
    {
        $this->select = implode(',', $names);
        return $this;
    }

    /**
     * Додаємо умови WHERE до запиту
     */
    public function where($column, $value)
    {
        $this->params[$column] = $value;
        return $this;
    }

    /**
     * Виконуємо SELECT-запит і повертаємо результат
     */
    public function get()
    {
        $response = [];
        $whereClause = '';

// Формуємо WHERE частину запиту
        if (!empty($this->params)) {
            $conditions = [];
            foreach ($this->params as $column => $value) {
                $conditions[] = "$column = :$column";
            }
            $whereClause = ' WHERE ' . implode(' AND ', $conditions);
        }

// Підготовлений SQL-запит
        $sql = "SELECT {$this->select} FROM {$this->table}" . $whereClause;
        $stmt = $this->pdo->prepare($sql);

// Виконуємо запит з параметрами
        foreach ($this->params as $column => $value) {
            $stmt->bindValue(":$column", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(); // Повертаємо всі результати
    }

    /**
     * Метод для вставки нових даних (INSERT)
     */
    public function insert($data)
    {
        $columns = implode(',', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$values})";
        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        return $stmt->execute(); // Виконуємо запит і повертаємо результат
    }

    /**
     * Метод для оновлення даних (UPDATE)
     */
    public function update($data)
    {
        $setClause = '';
        $conditions = [];

        foreach ($data as $column => $value) {
            $conditions[] = "$column = :$column";
        }
        $setClause = implode(',', $conditions);

        $whereClause = '';
        if (!empty($this->params)) {
            $whereConditions = [];
            foreach ($this->params as $column => $value) {
                $whereConditions[] = "$column = :where_$column";
            }
            $whereClause = ' WHERE ' . implode(' AND ', $whereConditions);
        }

        $sql = "UPDATE {$this->table} SET {$setClause}" . $whereClause;
        $stmt = $this->pdo->prepare($sql);

        foreach ($data as $column => $value) {
            $stmt->bindValue(":$column", $value);
        }

        foreach ($this->params as $column => $value) {
            $stmt->bindValue(":where_$column", $value);
        }

        return $stmt->execute(); // Виконуємо запит
    }

    /**
     * Метод для видалення даних (DELETE)
     */
    public function delete()
    {
        $whereClause = '';
        if (!empty($this->params)) {
            $conditions = [];
            foreach ($this->params as $column => $value) {
                $conditions[] = "$column = :$column";
            }
            $whereClause = ' WHERE ' . implode(' AND ', $conditions);
        }

        $sql = "DELETE FROM {$this->table}" . $whereClause;
        $stmt = $this->pdo->prepare($sql);

        foreach ($this->params as $column => $value) {
            $stmt->bindValue(":$column", $value);
        }

        return $stmt->execute(); // Виконуємо запит
    }



}

// Створення об'єкта класу Database
$db = new Database($dsn, $user, $password, $opt);
