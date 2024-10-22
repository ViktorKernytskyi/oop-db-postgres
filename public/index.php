<?php
session_start(); // Session initialization
/**
 *Checking if the session is active
 */
if (isset($_SESSION['id'])) {
    include('select.php'); // Include select.php if the session is active
} else {
    header('Location: select.php'); // Redirect to select.php if session is inactive
    exit(); //We end the script so that it does not continue
}

