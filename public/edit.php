<?php
session_start(); // Починаємо сесію
require_once 'Database.php'; // Підключаємо клас бази даних
require_once 'User.php'; // Підключаємо клас користувача

$db = new Database(); // Створюємо об'єкт бази даних
$pdo = $db->getPDO(); // Отримуємо об'єкт PDO
$user = new User($pdo); // Створюємо об'єкт користувача

$message = ""; // Змінна для повідомлень
$id = $_GET['id']; // Отримуємо ID користувача з URL

// Отримуємо дані користувача для редагування
$userData = $user->getUser($id);

// Обробка форми
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Валідація даних
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone)) {
        $message = "Всі поля є обов'язковими.";
    } else {
        $message = $user->updateUser($id, $firstName, $lastName, $email, $phone); // Оновлюємо користувача
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редагувати Користувача</title>
</head>
<body>
<h1>Редагувати Користувача</h1>
<form method="POST">
    <input type="text" name="first_name" value="<?php echo $userData['first_name']; ?>" required>
    <input type="text" name="last_name" value="<?php echo $userData['last_name']; ?>" required>
    <input type="email" name="email" value="<?php echo $userData['email']; ?>" required>
    <input type="text" name="phone" value="<?php echo $userData['phone']; ?>" required>
    <button type="submit">Оновити</button>
</form>
<p><?php echo $message; ?></p> <!-- Виводимо повідомлення -->
</body>
</html>
