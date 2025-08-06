<?php
require_once '../includes/auth_functions.php';

session_destroy();
header("Location: login.php");
exit();
?>
