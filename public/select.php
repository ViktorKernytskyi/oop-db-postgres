<?php
/** Session initialization */
session_start(); // Ініціалізація сесії
require_once 'config.php'; // Connecting configurations - Підключення конфігурацій
require_once 'Database.php'; // Connecting the database class - Підключення класу бази даних
require_once 'User.php'; // Connecting the user class - Підключення класу користувача

// Database connection - Підключення до бази даних
$database = new Database($dsn, $user, $password, $opt); // We create a database object - Створюємо об'єкт бази даних
$pdo = $database->getPDO(); // We get the PDO object - Отримуємо об'єкт PDO

// Creating a user object - Створення об'єкту користувача
$user = new User($pdo);
$users = [];
// We get all users - Отримуємо всіх користувачів
$users = $user->getAllUsers();

// Checking if the form was submitted via POST - Перевірка, чи була надіслана форма методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['name'])) {
    $name = trim($_POST['name']); //Getting the value of the field 'name' and removing extra spaces - Отримання значення поля 'name' і видалення зайвих пробілів
    $users = $user->getUsersByName($name); // Method call to get users by name - Виклик методу для отримання користувачів за ім'ям
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User choice</title>
</head>
<body>
<h1>Selecting a user by name</h1>
<form action="select.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" name="name" required><br><br>
    <input type="submit" value="Find">
</form>
<?php if (!empty($users)): ?>
    <h2>Search results:</h2>
    <ul>
        <?php foreach ($users as $user): ?>
            <li>ID: <?= htmlspecialchars($user['id']) ?>, First_name: <?= htmlspecialchars($user['first_name']) ?>, Last_name: <?= htmlspecialchars($user['last_name']) ?>, Email: <?= htmlspecialchars($user['email']) ?></li>
        <?php endforeach; ?>
    </ul>
<?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
    <p>No users with this name were found.</p>
<?php endif; ?>
</body>
</html>
<a href="select.php">Return to search</a><br/><br/>
