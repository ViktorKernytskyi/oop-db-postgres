<?php

/** Session initialization */
session_start(); // Ініціалізація сесії
require_once 'config.php'; // Connecting configurations - Підключення конфігурацій
require_once 'Database.php'; // Connecting the database class - Підключення класу бази даних
require_once 'User.php'; // Connecting the user class - Підключення класу користувача

// Database connection - Підключення до бази даних
$database = new Database($dsn, $user, $password, $opt); // We create a database object - Створюємо об'єкт бази даних
$pdo = $database->getPDO(); // We get the PDO object - Отримуємо об'єкт PDO

// Creating a user object - Створення об'єкта користувача
$user = new User($pdo);

// Initialize a variable for a message - Ініціалізація змінної для повідомлень
$message = '';

// Checking if the form was submitted via POST - Перевірка, чи була форма надіслана методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Отримання та очищення даних з форми
    $firstName = trim($_POST['first_name']);
    $lastName = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    // Validation of entered data - Валідація введених даних
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone)) {
        $message = "All fields are mandatory."; //Всі поля є обов'язковими
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email formatНевірний формат email.";//Невірний формат email
    } elseif (!preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
        $message = "Incorrect phone format. Use international format.";//Невірний формат телефону. Використовуйте міжнародний формат
    } else {
        // Adding a user to the database - Додавання користувача до бази даних
        $message = $user->addUser($firstName, $lastName, $email, $phone);
        $_SESSION['message'] = $message; // We save messages in the session - Зберігаємо повідомлення в сесії
        header("Location: index.php"); // Redirection to the main page - Перенаправлення на головну сторінку
        exit(); // Completion of script execution - Завершення виконання скрипта
    }
}
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <style>
        /* Add styles for the header and form - Додаємо стилі для заголовка та форми */
        h1 {
            text-align: center; /* Header centering - Центрування заголовка */
        }
        form {
            display: flex; /* We use Flexbox - Використовуємо Flexbox */
            flex-direction: column; /* Location of elements vertically - Розташування елементів вертикально */
            align-items: center; /* Centering elements horizontally - Центрування елементів по горизонталі */
            max-width: 230px; /* The maximum width of the form - Максимальна ширина форми */
            margin: 0 auto; /* Form centering - Центрування форми */
        }

          input[type="text"], input[type="email"] {
            margin-bottom: 15px; /* Distance between fields - Відстань між полями */
            padding: 8px; /* Internal indentation of fields - Внутрішній відступ полів */
        }
        button {
            align-self: flex-end; /* Align the button to the right - Вирівнювання кнопки праворуч */
            padding: 10px 15px; /* Internal button indentation - Внутрішній відступ кнопки */
            margin-left: 90px; /* The distance to the left of the button - Відстань зліва від кнопки */
        }
    </style>
</head>
<body>
<h1>Add User</h1>
<form method="POST">
    <div>
        <label for="first_name">First name:</label>
        <input type="text" id="first_name" name="first_name" placeholder="First name" required>
    </div>
    <div>
        <label for="last_name">Last name:</label>
        <input type="text" id="last_name" name="last_name" placeholder="Last name" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Email" required>
    </div>
    <div>
         <label for="phone">Phone:</label>
         <input type="text" id="phone" name="phone" placeholder="Phone" required>
    </div>
    <div>
        <label for="Add"></label>
        <button type="submit">Add</button>
    </div>
</form>

<p><?php echo htmlspecialchars($message); ?></p> <!-- We display messages protecting against XSS - Виводимо повідомлення, захищаючись від XSS -->
</body>
</html>
