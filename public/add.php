<?php
session_start(); // Ініціалізація сесії

// Ініціалізація повідомлення
$message = '';

// Перевірка, чи форма надіслана
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Отримання даних з форми з валідацією
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Валідація даних
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone)) {
        $message = "Всі поля є обов'язковими.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Невірний формат email.";
    } elseif (!preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
        $message = "Невірний формат телефону. Використовуйте міжнародний формат.";
    } else {
        // Додавання користувача
        $message = $user->addUser($firstName, $lastName, $email, $phone);
        $_SESSION['message'] = $message; // Зберігаємо повідомлення в сесії
        header("Location: index.php"); // Перенаправлення на index.php
        exit(); // Завершуємо скрипт
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Додати Користувача</title>
</head>
<body>
<h1>Додати Користувача</h1>
<form method="POST">
    <input type="text" name="first_name" placeholder="Ім'я" required>
    <input type="text" name="last_name" placeholder="Прізвище" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="text" name="phone" placeholder="Телефон" required>
    <button type="submit">Додати</button>
</form>
<p><?php echo $message; ?></p> <!-- Виводимо повідомлення -->
</body>
</html>