<?php
require_once 'config.php';
require_once 'Database.php'; // Connecting the database class - Підключення класу бази даних
require_once 'User.php'; // Connecting the user class - Підключення класу користувача
// Database connection - Підключення до бази даних
$database = new Database($dsn, $user, $password, $opt); // We create a database object - Створюємо об'єкт бази даних
$pdo = $database->getPDO(); // We get the PDO object - Отримуємо об'єкт PDO

$message = '';

/** @var
 * Creating a user object
 */
$user = new User($pdo);// Створення об'єкта користувача


/** @var  $userId
 * Check if the user ID was passed via POST
 */
// Перевірка, чи передано ID користувача через POST-запит
$userId = $_SERVER['REQUEST_METHOD'] === 'POST'
    ? filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT)
    : filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$userId) {
    die("User ID not passed in form.");
}
/** Update form processing */
// First, we check whether the POST request for the update has arrived
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $firstName = trim($_POST['users_firstName']);
    $lastName = trim($_POST['users_lastName']);
    $email = trim($_POST['users_email']);
    $phone = trim($_POST['users_phone']);
   // $password = trim($_POST['users_password']);

    if (!empty($firstName) && !empty($lastName) && !empty($email) && !empty($phone) ) {
        try {
            //  Request to update the user - Запит на оновлення користувача
            $stmt = $pdo->prepare("UPDATE users SET first_name = :firstname, last_name = :lastname, email = :email, phone = :phone WHERE id = :id");
            $stmt->execute([
                'firstname' => $firstName,
                'lastname' => $lastName,
                'email' => $email,
                'phone' => $phone,
               // 'password' => password_hash($password, PASSWORD_DEFAULT),
                'id' => $userId
            ]);

            $message = "User data updated successfully.";
        } catch (PDOException $e) {
            $message = "Error updating data: " . $e->getMessage();
        }
    } else {
        $message = "All fields are mandatory.";
    }
} else {
    /** @var  $userId
     *If it is not a POST request, then we load data for the form
     */
       $userId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // Якщо не POST-запит, тоді завантажуємо дані для форми
    if (!$userId) {
        die("The user ID was not passed or is incorrect.");
    }
    /** Obtaining user data for pre-filling the form */
    // Отримання даних користувача для попереднього заповнення форми
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $userId]);
        $currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$currentUser) {
            die("User not found.");//Користувач не знайдений
        }
    } catch (PDOException $e) {
        die("Error getting user data: " . $e->getMessage());
    }
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
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($userId); ?>">
    <div>
        <label for="users_firstName">firstName:</label>
        <input type="text" id="users_firstName" name="users_firstName" value="<?php echo htmlspecialchars($currentUser['first_name']); ?>" required>
    </div>
    <div>
        <label for="users_lastName">lastName:</label>
        <input type="text" id="users_lastName" name="users_lastName" value="<?php echo htmlspecialchars($currentUser['last_name']); ?>" required>
    </div>
    <div>
        <label for="email">Email:</label>
        <input type="email" id="email" name="users_email" value="<?php echo htmlspecialchars($currentUser['email']); ?>" required>
    </div>
    <div>
        <label for="phone">phone:</label>
        <input type="text" id="phone" name="users_phone" value="<?php echo htmlspecialchars($currentUser['phone']); ?>" required>
    </div>
<!--    <div>-->
<!--        <label for="password">Новий пароль (необов'язково):</label>-->
<!--        <input type="password" id="password" name="users_password" required>-->
<!--    </div>-->
    <input type="submit" value="Update record">
</form>
<a href="edit.php">Return to the list</a><br/><br/>
</body>
</html>

