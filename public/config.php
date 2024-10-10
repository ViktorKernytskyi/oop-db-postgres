<?php


$dbname = 'user_data';
/** @var string ім'я користувача */
$user = 'postgres';// Ім'я користувача
/** @var string пароль користувача */
$password = 'root'; // Пароль користувача
/** @var string адреса сервера бази даних */
$host = '127.0.0.1'; // Адреса сервера бази даних
/** @var int порт доступу до бази даних */
$port = 5432;// Порт PostgreSQL

/** @var string формування DSN для підключення */
$dsn = "pgsql:host=".$host.";port=".$port.";dbname=".$dbname;

/** @var PDO підключення до бази даних з використанням PDO */

$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
/** @var TYPE_NAME $db */
try {
    // Підключення до бази даних з використанням PDO
    $pdo = new PDO($dsn, $user, $password);
    echo "З'єднання успішне!";
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Включення режиму обробки помилок
} catch (PDOException $e) {
    echo "Помилка підключення: " . $e->getMessage(); // Виведення помилки при підключенні
}







