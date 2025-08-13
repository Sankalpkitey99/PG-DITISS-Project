<?php
// Enable error reporting
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Correct absolute paths for your setup
require_once '../config/database.php';
require_once '../includes/auth_functions.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /users/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch tasks
try {
    $stmt = $pdo->prepare("SELECT * FROM tasks WHERE user_id = ? ORDER BY due_date ASC");
    $stmt->execute([$user_id]);
    $tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Include header
require_once '../includes/header.php';
?>

<div class="content">
    <h2>My Tasks</h2>
    <a href="create.php" class="btn">+ New Task</a>

    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert"><?= htmlspecialchars($_SESSION['message']) ?></div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

    <?php if (empty($tasks)): ?>
        <p>No tasks found. Create your first task!</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                <tr>
                    <td><?= htmlspecialchars($task['title']) ?></td>
                    <td><?= htmlspecialchars($task['description']) ?></td>
                    <td><?= ucfirst(str_replace('_', ' ', $task['status'])) ?></td>
                    <td><?= $task['due_date'] ?: 'None' ?></td>
                    <td>
                        <a href="edit.php?id=<?= $task['id'] ?>" class="btn">Edit</a>
                        <a href="delete.php?id=<?= $task['id'] ?>" 
                           class="btn btn-danger" 
                           onclick="return confirm('Delete this task?')">
                            Delete
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php
// Include footer
require_once '../includes/footer.php';
?>
