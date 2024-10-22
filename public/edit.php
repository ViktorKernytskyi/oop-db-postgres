<?php

/** Session initialization */
session_start(); // Ініціалізація сесії
require_once 'Database.php'; // Connecting the database class - Підключення класу бази даних
require_once 'User.php'; // Connecting the user class - Підключення класу користувача
require_once 'config.php'; // Connecting configurations - Підключення конфігурацій

// Database connection - Підключення до бази даних
$database = new Database($dsn, $user, $password, $opt); // We create a database object - Створюємо об'єкт бази даних
var_dump($database);
$pdo = $database->getPDO(); // We get the PDO object - Отримуємо об'єкт PDO

// Creating a user object - Створення об'єкта користувача
$user = new User($pdo);

echo "DEBUG: Значення id: " . htmlspecialchars($_GET['id']);
echo "DEBUG: Вміст \$_GET: " . print_r($_GET, true);

/**
 *Checking if the 'id' parameter exists in the $_GET array
 */
// Перевірка, чи існує параметр 'id' у масиві $_GET
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['message'] = "ID користувача не передано. Поточний ID: " . print_r($_GET, true);
  //  header("Location: select.php");
    exit();
}

/** @var  $id */
$id = $_GET['id']; // We get the user ID from the URL - Отримуємо ID користувача з URL

/**
 * @var  $currentUser
 *Get current user data
 */
// Отримання поточних даних користувача
$currentUser = $user->getUserById($id);
// Let's add a check to see if a value is returned - Додамо перевірку, щоб побачити, чи повернулося значення
if (!$currentUser) {
    $_SESSION['message'] = "No user found with this ID - Користувача з таким ID не знайдено. ID: " . htmlspecialchars($id);
    echo "DEBUG: No user found with this ID. ID: " . htmlspecialchars($id);
    header("Location: select.php");
    exit();
}

// Initialize a variable for a message - Ініціалізація змінної для повідомлень
$message = '';

// Form processing - Обробка форми
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = $_POST['first_name'];
    $lastName = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Data validation - Валідація даних
    if (empty($firstName) || empty($lastName) || empty($email) || empty($phone)) {
        $message = "All fields are mandatory.";//Всі поля є обов'язковими
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";//Невірний формат email
    } elseif (!preg_match('/^\+?[0-9]{10,15}$/', $phone)) {
        $message = "Incorrect phone format. Use international format.";//Невірний формат телефону. Використовуйте міжнародний формат
    } else {
        // Updating user data
        $result = $user->updateUser($id, $firstName, $lastName, $email, $phone);//Оновлення  даних користувача
        if ($result) {
            $_SESSION['message'] = "User data updated successfully.";
            header("Location: select.php");
            exit();
        } else {
            $message = "Error updating user data.";
        }
    }
} else {
    /**
     * @var  $firstName
     * We fill in the variables for the form from the current user data
     */
    // Заповнюємо змінні для форми з поточних даних користувача
    $firstName = $currentUser['first_name'];
    $lastName = $currentUser['last_name'];
    $email = $currentUser['email'];
    $phone = $currentUser['phone'];
}

/** We output the message from the session, if there is one */
// Виводимо повідомлення з сесії, якщо воно є
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']); //We delete the message from the session after displaying it
}

?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
</head>
<body>
<h1>Edit User</h1>
<form method="POST">
    <label for="first_name">Ім'я:</label>
    <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($firstName); ?>" required><br><br>
    <label for="last_name">Прізвище:</label>
    <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($lastName); ?>" required><br><br>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>
    <label for="phone">Телефон:</label>
    <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($phone); ?>" required><br><br>
    <button type="submit">Оновити</button>
</form>
<!-- Message output -->
<!-- Виведення повідомлення -->
<?php if (!empty($message)): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>
<!-- Повернутися до списку користувачів -->
<a href="select.php">Return to the list of users</a>
</body>
</html>
