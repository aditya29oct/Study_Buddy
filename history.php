<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once("php/dbconnect.php");

$user_id = $_SESSION['user_id'];

// Fetch the last 7 Pomodoro sessions
$sql = "SELECT duration, session_date FROM sessions WHERE user_id = ? ORDER BY session_date DESC LIMIT 7";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$chartData = []; // Initialize chart data array

while ($row = $result->fetch_assoc()) {
    $chartData[] = [
        'date' => date("d M", strtotime($row['session_date'])),
        'duration' => $row['duration']
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Session History | Study Buddy</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f7f7f7; }
        .container { margin-top: 80px; }
        h2 { margin-bottom: 30px; }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center">📜 Pomodoro Session History</h2>
    
    <!-- Table displaying session history -->
    <table class="table table-bordered table-striped">
        <thead class="thead-dark">
            <tr>
                <th>Date</th>
                <th>Duration (Minutes)</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= date("d M Y, h:i A", strtotime($row['session_date'])) ?></td>
                    <td><?= htmlspecialchars($row['duration']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Chart displaying Pomodoro progress -->
    <h4 class="mt-5 text-center">📈 Your Pomodoro Progress</h4>
    <canvas id="pomodoroChart" height="100"></canvas>

    <div class="text-center mt-4">
        <a href="dashboard.php" class="btn btn-primary">← Back to Dashboard</a>
    </div>
</div>

<!-- JavaScript for Chart.js -->
<script>
    const ctx = document.getElementById('pomodoroChart').getContext('2d');
    const chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode(array_column($chartData, 'date')) ?>,
            datasets: [{
                label: 'Pomodoro Duration (mins)',
                data: <?= json_encode(array_column($chartData, 'duration')) ?>,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
