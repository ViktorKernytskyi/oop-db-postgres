<?php
/**
 *Configuration settings for database connection
 */
// Конфігураційні налаштування для підключення до бази даних
$dbname = 'user_data';
/** @var string User name */
$user = 'postgres';
/** @var string User password */
$password = 'root';
/** @var string The address of the database server */
$host = '127.0.0.1';
/** @var int database access port */
$port = 5432;// PostgreSQL port

/** @var string formation of DSN for connection */
$dsn = "pgsql:host=".$host.";port=".$port.";dbname=".$dbname;

// Options for PDO
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,// Error handling mode
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,// We return the data in the form of an associative array
    PDO::ATTR_EMULATE_PREPARES   => false,// We disable the emulation of prepared requests
];






