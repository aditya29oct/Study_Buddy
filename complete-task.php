<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once("php/dbconnect.php");

$user_id = $_SESSION['user_id'];
$task_id = $_GET['id'];

// Ensure task belongs to the logged-in user
$sql = "UPDATE tasks SET completed = 1 WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $task_id, $user_id);
$stmt->execute();

header("Location: task-planner.php");  // Redirect back to task planner
exit;
?>
