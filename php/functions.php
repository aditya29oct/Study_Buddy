<?php
require_once("dbconnect.php");

// Check if the user is logged in
function checkLoginStatus() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit;
    }
}

// Add a task to the database
function addTask($user_id, $title, $deadline) {
    global $conn;
    $sql = "INSERT INTO tasks (user_id, title, deadline, status) VALUES (?, ?, ?, 'pending')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iss", $user_id, $title, $deadline);
    $stmt->execute();
    $stmt->close();
}

// Get tasks for the logged-in user
function getTasks($user_id) {
    global $conn;
    $sql = "SELECT id, title, deadline, status FROM tasks WHERE user_id = ? ORDER BY deadline ASC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result();
}

// Mark a task as completed
function completeTask($task_id) {
    global $conn;
    $sql = "UPDATE tasks SET status = 'completed' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $task_id);
    $stmt->execute();
    $stmt->close();
}

// Save Pomodoro session
function savePomodoroSession($user_id, $duration) {
    global $conn;
    $sql = "INSERT INTO sessions (user_id, duration, session_date) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $duration);
    $stmt->execute();
    $stmt->close();
}

// Get Pomodoro session data for chart
function getPomodoroData($user_id) {
    global $conn;
    $sql = "SELECT duration, session_date FROM sessions WHERE user_id = ? ORDER BY session_date DESC LIMIT 7";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result();
}
?>
