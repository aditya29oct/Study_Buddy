<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once("dbconnect.php");

    $user_id = intval($_POST['user_id']);
    $duration = floatval($_POST['duration']); // in minutes

    $stmt = $conn->prepare("INSERT INTO sessions (user_id, duration, session_date) VALUES (?, ?, NOW())");
    $stmt->bind_param("id", $user_id, $duration);

    if ($stmt->execute()) {
        echo "Session saved successfully";
    } else {
        echo "Error saving session: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

