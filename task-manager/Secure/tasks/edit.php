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

// Fetch task to edit
try {
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ? AND user_id = ?");
    $stmt->execute([$task_id, $user_id]);
    $task = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$task) {
        $_SESSION['message'] = "Task not found or access denied";
        header("Location: view.php");
        exit();
    }
} catch (PDOException $e) {
    die("Error fetching task: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $status = $_POST['status'];
    $due_date = $_POST['due_date'];

    try {
        $stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, status = ?, due_date = ? WHERE id = ? AND user_id = ?");
        $stmt->execute([$title, $description, $status, $due_date, $task_id, $user_id]);
        
        $_SESSION['message'] = "Task updated successfully!";
        header("Location: view.php");
        exit();
    } catch (PDOException $e) {
        $error = "Task update failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Task</title>
</head>
<body>
    <h2>Edit Task</h2>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
    <form method="post">
        <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required>
        <textarea name="description"><?= htmlspecialchars($task['description']) ?></textarea>
        <select name="status">
            <option value="pending" <?= $task['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
            <option value="in_progress" <?= $task['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
            <option value="completed" <?= $task['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
        </select>
        <input type="date" name="due_date" value="<?= $task['due_date'] ?>">
        <button type="submit">Update Task</button>
    </form>
    <a href="view.php">Back to Tasks</a>
</body>
</html>
