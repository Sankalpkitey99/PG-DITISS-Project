<?php
require_once '../config/database.php';
require_once '../includes/auth_functions.php';
redirectIfNotLoggedIn();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $due_date = $_POST['due_date'];
    $user_id = $_SESSION['user_id'];

    try {
        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, title, description, due_date) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $title, $description, $due_date]);
        
        $_SESSION['message'] = "Task created successfully!";
        header("Location: view.php");
        exit();
    } catch (PDOException $e) {
        $error = "Task creation failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Task</title>
</head>
<body>
    <h2>Create New Task</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="post">
        <input type="text" name="title" placeholder="Title" required>
        <textarea name="description" placeholder="Description"></textarea>
        <input type="date" name="due_date">
        <button type="submit">Create Task</button>
    </form>
    <a href="view.php">Back to Tasks</a>
</body>
</html>
