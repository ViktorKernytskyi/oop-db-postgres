<?php


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вибір користувача</title>
</head>
<body>
<h1>Вибір користувача за іменем</h1>

<form action="select.php" method="POST">
    <label for="name">Ім'я:</label>
    <input type="text" name="name" required><br><br>
    <input type="submit" value="Знайти">
</form>

<!-- Виведення результатів -->
<?php
    if (isset($users)) {
        echo "<h2>Результати:</h2>";
foreach ($users as $user) {
echo "<p>{$user['first_name']} {$user['last_name']}</p>";
}
}
?>
</body>
</html>

<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список Користувачів</title>
</head>
<body>
<h1>Список Користувачів</h1>
<a href="add.php">Додати Користувача</a> <!-- Посилання на сторінку додавання -->
<table>
    <tr>
        <th>ID</th>
        <th>Ім'я</th>
        <th>Прізвище</th>
        <th>Email</th>
        <th>Телефон</th>
        <th>Дії</th>
    </tr>
<!--    --><?php //foreach ($users as $user): ?>
        <tr>
<!--            <td>--><?php //echo $user['id']; ?><!--</td>-->
<!--            <td>--><?php //echo $user['first_name']; ?><!--</td>-->
<!--            <td>--><?php //echo $user['last_name']; ?><!--</td>-->
<!--            <td>--><?php //echo $user['email']; ?><!--</td>-->
<!--            <td>--><?php //echo $user['phone']; ?><!--</td>-->
            <td>
<!--                <a href="edit.php?id=--><?php //echo $user['id']; ?><!--">Редагувати</a> |-->
<!--                <a href="delete.php?id=--><?php //echo $user['id']; ?><!--">Видалити</a>-->
            </td>
        </tr>
<!--    --><?php //endforeach; ?>
</table>
</body>
</html>