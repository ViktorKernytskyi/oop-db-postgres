<?php
include('config.php');

// Database connection - Підключення до бази даних
$database = new Database($dsn, $user, $password, $opt); // We create a database object - Створюємо об'єкт бази даних
$pdo = $database->getPDO(); // We get the PDO object - Отримуємо об'єкт PDO

$message = '';
/** Checking if the ID was passed */
// Перевірка, чи був переданий ID
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

//    $user = new User($pdo);// Створення об'єкта користувача
//    /** @var  $users
//     * Method to get user by ID
//     */
//    $users = $user->getUser();

    // Отримання даних користувача для попереднього заповнення форми
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$currentUser) {
            die("User not found.");//Користувач не знайдений
        }
    } catch (PDOException $e) {
        die("Error getting user data: " . $e->getMessage());//Помилка при отриманні даних користувача
    }
/** Update form processing */
    // Обробка форми оновлення
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $firstName = trim($_POST['users_firstName']);
        $lastName = trim($_POST['users_lastName']);
        $email = trim($_POST['users_email']);
        $phone = trim($_POST['users_phone']);
        $password = trim($_POST['users_password']);

        if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($phone) && !empty($password)) {
            try {
                $stmt = $pdo->prepare("UPDATE users SET first_name = :name, last_name = :name,email = :email, phone = :phone, password = :password WHERE id = :id");
                $stmt->execute([
                    'firstname' => $firstName,
                    'lastname' => $lastName,
                    'email' => $email,
                    'phone' => $phone,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'id' => $userId
                ]);

                $message = "User data updated successfully.";//Дані користувача успішно оновлено
            } catch (PDOException $e) {
                $message = "Error updating data: " . $e->getMessage();//Помилка при оновленні даних
            }
        } else {
            $message = "All fields are mandatory.";//Всі поля є обов'язковими для заповнення
        }
    }
} else {
    die("User ID not passed.");//ID користувача не передано
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>User update</title>
    <style>
        label {
            display: inline-block;
            width: 170px;
        }
        form > div {
            margin-bottom: 5px;
        }
        td:nth-child(5), td:nth-child(6) {
            text-align: center;
        }
        table {
            border-spacing: 0;
            border-collapse: collapse;
        }
        td, th {
            padding: 10px;
            border: 1px solid black;
        }
    </style>
</head>
<body>
<h2>Updating user data</h2>
<?php if (!empty($message)) : ?>
    <p><?php echo htmlspecialchars($message); ?></p>
<?php endif; ?>
<form method="POST">
    <div>
        <label for="users_firstName">Ім'я:</label>
        <input type="text" id="users_firstName" name="users_firstName" value="<?php echo htmlspecialchars($currentUser['first_name']); ?>" required>
    </div>
    <div>
        <label for="users_lastName">Ім'я:</label>
        <input type="text" id="users_lastName" name="users_lastName" value="<?php echo htmlspecialchars($currentUser['last_name']); ?>" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="users_email" value="<?php echo htmlspecialchars($currentUser['email']); ?>" required>
    </div>
    <div>
        <label for="phone">Телефон:</label>
        <input type="text" id="phone" name="users_phone" value="<?php echo htmlspecialchars($currentUser['phone']); ?>" required>
    </div>
<!--    <div>-->
<!--        <label for="password">Пароль:</label>-->
<!--        <input type="password" id="password" name="users_password" required>-->
<!--    </div>-->
    <input type="submit" value="Update record">//Оновити запис
</form>
<a href="edit.php">Return to the list</a><br/><br/>
</body>
</html>

