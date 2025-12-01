<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once("php/dbconnect.php");

// Save the session to the database once it ends
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['duration'])) {
    $user_id = $_SESSION['user_id'];
    $duration = $_POST['duration'];  // Duration in minutes
    $sql = "INSERT INTO sessions (user_id, duration, session_date) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $duration);
    $stmt->execute();
    header("Location: pomodoro.php");  // Refresh the page to show saved session
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Pomodoro Timer | Study Buddy</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f7f7f7; }
        .container { margin-top: 80px; }
        h2 { margin-bottom: 30px; }
        .timer { font-size: 48px; font-weight: bold; text-align: center; }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center">⏲️ Pomodoro Timer</h2>

    <div class="text-center">
        <div class="timer" id="timerDisplay">25:00</div>
        <div>
            <button id="startBtn" class="btn btn-success">Start</button>
            <button id="pauseBtn" class="btn btn-warning" disabled>Pause</button>
            <button id="resetBtn" class="btn btn-danger">Reset</button>
        </div>
    </div>

    <form action="pomodoro.php" method="POST">
        <input type="hidden" name="duration" id="hiddenDuration">
        <div class="text-center mt-4">
            <button type="submit" class="btn btn-primary">Save Session</button>
        </div>
    </form>

    <div class="text-center mt-4">
        <a href="dashboard.php" class="btn btn-secondary">← Back to Dashboard</a>
    </div>
</div>

<script>
    // Pomodoro Timer Logic
    let timer;
    let minutes = 25;
    let seconds = 0;
    let isRunning = false;

    const timerDisplay = document.getElementById('timerDisplay');
    const startBtn = document.getElementById('startBtn');
    const pauseBtn = document.getElementById('pauseBtn');
    const resetBtn = document.getElementById('resetBtn');
    const hiddenDuration = document.getElementById('hiddenDuration');

    function updateDisplay() {
        let minutesStr = minutes < 10 ? '0' + minutes : minutes;
        let secondsStr = seconds < 10 ? '0' + seconds : seconds;
        timerDisplay.textContent = `${minutesStr}:${secondsStr}`;
        hiddenDuration.value = minutes;
    }

    function startTimer() {
        if (!isRunning) {
            timer = setInterval(() => {
                if (seconds === 0) {
                    if (minutes === 0) {
                        clearInterval(timer);
                        alert('Pomodoro session finished! Take a break!');
                    } else {
                        minutes--;
                        seconds = 59;
                    }
                } else {
                    seconds--;
                }
                updateDisplay();
            }, 1000);
            startBtn.disabled = true;
            pauseBtn.disabled = false;
            isRunning = true;
        }
    }

    function pauseTimer() {
        clearInterval(timer);
        startBtn.disabled = false;
        pauseBtn.disabled = true;
        isRunning = false;
    }

    function resetTimer() {
        clearInterval(timer);
        minutes = 25;
        seconds = 0;
        updateDisplay();
        startBtn.disabled = false;
        pauseBtn.disabled = true;
        isRunning = false;
    }

    startBtn.addEventListener('click', startTimer);
    pauseBtn.addEventListener('click', pauseTimer);
    resetBtn.addEventListener('click', resetTimer);

    updateDisplay();
</script>

</body>
</html>
