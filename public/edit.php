<?php
/** Session initialization */
session_start(); // Ініціалізація сесії
require_once 'Database.php'; // Connecting the database class - Підключення класу бази даних
require_once 'User.php'; // Connecting the user class - Підключення класу користувача
require_once 'config.php'; // Connecting configurations - Підключення конфігурацій

// Database connection - Підключення до бази даних
$database = new Database($dsn, $user, $password, $opt); // We create a database object - Створюємо об'єкт бази даних
$pdo = $database->getPDO(); // We get the PDO object - Отримуємо об'єкт PDO
/** @var
 * Creating a user object
 */
$user = new User($pdo);// Створення об'єкта користувача
/** @var  $users
 * We get all users
 */
$users = $user->getAllUsers();//  Отримуємо всіх користувачів
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
<table border="1" align="center" cellspacing="0">
    <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    <?php
    if (!empty($users)) {
        foreach ($users as $user) {
            echo '<tr>
                <td>' . htmlspecialchars($user['id']) . '</td>
                <td>' . htmlspecialchars($user['first_name']) . '</td>
                <td>' . htmlspecialchars($user['last_name']) . '</td>
                <td>' . htmlspecialchars($user['email']) . '</td>
                <td>' . htmlspecialchars($user['phone']) . '</td>
                <td><a href="update.php?id=' . htmlspecialchars($user['id']) . '">editing</a></td>
                <td>
                    <form method="post" action="delete.php">
                        <input type="hidden" name="item" value="' . htmlspecialchars($user['id']) . '">
                        <button type="submit">Remove</button>
                    </form>
                </td>
            </tr>';
        }
    } else {
        echo "<tr><td colspan='7'>No data available</td></tr>";
    }
    ?>
</table>
<a href="update.php">Return to the list</a><br/><br/>
</body>
</html>


