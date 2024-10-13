<?php
session_start(); // Починаємо сесію
require_once 'Database.php'; // Підключаємо клас бази даних
require_once 'User.php'; // Підключаємо клас користувача

$db = new Database(); // Створюємо об'єкт бази даних
$pdo = $db->getPDO(); // Отримуємо об'єкт PDO
$user = new User($pdo); // Створюємо об'єкт користувача

$message = ""; // Змінна для повідомлень
$id = $_GET['id']; // Отримуємо ID користувача з URL

// Видаляємо користувача
if ($user->deleteUser($id)) {
    $message = "Користувача успішно видалено."; // Повідомлення про успіх
} else {
    $message = "Помилка при видаленні користувача."; // Повідомлення про помилку
}

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Видалити Користувача</title>
</head>
<body>
    <h1><?php echo $message; ?></h1>
    <a href="select.php">Повернутися до списку користувачів</a>  <!-- Посилання на список користувачів -->
</body>
</html>
