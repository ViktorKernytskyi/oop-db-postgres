<?php
session_start(); // Ініціалізація сесії

// Перевірка, чи є активна сесія
if (isset($_SESSION['id'])) {
    include('select.php'); // Включаємо select.php, якщо сесія активна
} else {
    header('Location: select.php'); // Перенаправлення на select.php, якщо сесія неактивна
    exit(); // Завершуємо скрипт, щоб не виконувати далі
}

?>