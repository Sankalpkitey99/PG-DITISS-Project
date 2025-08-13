<?php
require_once 'includes/auth_functions.php';
require_once 'config/database.php';

if (isLoggedIn()) {
    header("Location: tasks/view.php");
    exit();
} else {
    header("Location: users/login.php");
    exit();
}
?>
