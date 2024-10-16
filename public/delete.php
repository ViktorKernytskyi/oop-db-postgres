<?php

/** Session initialization */
session_start(); // Ініціалізація сесії
require_once 'Database.php'; // Connecting the database class - Підключення класу бази даних
require_once 'User.php'; // Connecting the user class - Підключення класу користувача
require_once 'config.php'; // Connecting configurations - Підключення конфігурацій

/** @var  $message */
$message = ""; // Ініціалізація змінної $message

    /** Checking if the request was POSTed and if the 'id' parameter was passed */
    //Перевірка, чи був надісланий запит методом POST і чи передано параметр 'id'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {

    // Database connection - Підключення до бази даних
    /** @var  $database */
    $database = new Database($dsn, $user, $password, $opt); // We create a database object - Створюємо об'єкт бази даних
    /** @var  $pdo */
    $pdo = $database->getPDO(); // We get the PDO object - Отримуємо об'єкт PDO
    /** @var  $user */
    $user = new User($pdo); // We create a user object - Створюємо об'єкт користувача

    /** @var  $id  We get the user ID from the URL to delete */
    $id = $_POST['id']; // Отримуємо ID користувача з URL для видалення

    /** Add a debug message before executing the query */
    // Додати налагоджувальне повідомлення перед виконанням запиту
    echo "ID для видалення: " . htmlspecialchars($id) . "<br>";

    //Call the method to delete the user
    /** @var  $result */
    $result = $user->deleteUser($id); // Виклик методу для видалення користувача

    // Перевірка результату і встановлення повідомлення
    /**Checking the result and setting the message  */
    if ($result === true) {

        $_SESSION['message'] = "User deleted successfully!"; // Користувача успішно видалено
    } else {
        $_SESSION['message'] = "Error deleting user!"; // Помилка при видаленні користувача
    }

    /** Redirect to the same page */
    header("Location: delete.php"); // Перенаправлення на ту ж саму сторінку
    exit();
}

/** Receiving a message from the session */
/** @var  $message */
$message = isset($_SESSION['message']) ? $_SESSION['message'] : ''; // Отримання повідомлення з сесії
unset($_SESSION['message']); //Deleting a message from a session after it has been displayed - Видалення повідомлення з сесії після його відображення
?>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete User</title>
</head>
<body>
<h1>Delete User</h1>

<!-- A form for entering the ID of the user to be deleted -->
<!-- Форма для введення ID користувача, якого потрібно видалити -->
<form action="delete.php" method="POST">
    <label for="id">User ID:</label>
    <input type="number" id="id" name="id" required>
    <button type="submit">Remove</button>
</form>
<!-- Displaying a message about the result -->
<!-- Відображення повідомлення про результат -->
<?php if (!empty($message)): ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>
<a href="select.php">Return to the list of users</a>  <!-- Link to the list of users - Посилання на список користувачів -->
</body>
</html>

