<?php
require_once '../config/database.php';
require_once '../includes/auth_functions.php';
redirectIfNotLoggedIn();

if (!isset($_GET['id'])) {
    header("Location: view.php");
    exit();
}

$task_id = $_GET['id'];
$user_id = $_SESSION['user_id'];

try {
    $stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->execute([$task_id, $user_id]);
    
    $_SESSION['message'] = "Task deleted successfully!";
} catch (PDOException $e) {
    $_SESSION['message'] = "Task deletion failed: " . $e->getMessage();
}

header("Location: view.php");
exit();
?>
