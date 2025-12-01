<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once("php/dbconnect.php");

// Fetch existing tasks for the user
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM tasks WHERE user_id = ? ORDER BY created_at ASC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Planner | Study Buddy</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
        }
        .container {
            margin-top: 80px;
        }
        h2 {
            margin-bottom: 30px;
        }
        .task {
            background-color: #f9f9f9;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 5px;
        }
        .task.completed {
            background-color: #d3ffd3;
            text-decoration: line-through;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center">📋 Your Task Planner</h2>
    
    <!-- Add Task Form -->
    <form action="task-planner.php" method="POST">
        <div class="form-group">
            <input type="text" name="task" class="form-control" placeholder="Enter a new task" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Task</button>
    </form>
    
    <!-- Display Existing Tasks -->
    <div class="mt-4">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="task <?= $row['completed'] ? 'completed' : '' ?>">
                <p><?= htmlspecialchars($row['task_name']) ?></p>
                <?php if (!$row['completed']): ?>
                    <a href="complete-task.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Mark as Completed</a>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
    
    <div class="text-center mt-4">
        <a href="dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['task'])) {
    $task_name = $_POST['task'];
    $sql = "INSERT INTO tasks (user_id, task_name, completed) VALUES (?, ?, 0)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $task_name);
    $stmt->execute();
    header("Location: task-planner.php");  // Refresh the page to show new task
}
?>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
<?php
session_start();
require_once('php/functions.php');  // Include the functions.php file
checkLoginStatus();  // Ensure user is logged in

// The rest of your task planner logic goes here
?>