<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once("php/dbconnect.php");

// Quotes Array (You can later fetch these from the database if desired)
$quotes = [
    "The best way to get started is to quit talking and begin doing. - Walt Disney",
    "Don’t watch the clock; do what it does. Keep going. - Sam Levenson",
    "You are never too old to set another goal or to dream a new dream. - C.S. Lewis",
    "It does not matter how slowly you go as long as you do not stop. - Confucius",
    "Everything you can imagine is real. - Pablo Picasso",
    "The harder you work for something, the greater you'll feel when you achieve it. - Anonymous"
];

// Random quote selection
$randomQuote = $quotes[array_rand($quotes)];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Study Buddy</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f7f7f7; }
        .container { margin-top: 80px; text-align: center; }
        h2 { margin-bottom: 30px; }
        .quote { font-style: italic; color: #6c757d; margin-top: 30px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Welcome to Study Buddy! 😊</h2>
    <p class="lead">Your personalized study companion.</p>
    
    <div class="quote">
        <p>“<?= $randomQuote ?>”</p>
    </div>

    <div class="mt-4">
        <a href="pomodoro.php" class="btn btn-primary">Start Pomodoro Timer</a>
        <a href="task-planner.php" class="btn btn-secondary">Go to Task Planner</a>
    </div>
</div>
</body>
</html>
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once("php/dbconnect.php");

// Quotes Array (You can later fetch these from the database if desired)
$quotes = [
    "The best way to get started is to quit talking and begin doing. - Walt Disney",
    "Don’t watch the clock; do what it does. Keep going. - Sam Levenson",
    "You are never too old to set another goal or to dream a new dream. - C.S. Lewis",
    "It does not matter how slowly you go as long as you do not stop. - Confucius",
    "Everything you can imagine is real. - Pablo Picasso",
    "The harder you work for something, the greater you'll feel when you achieve it. - Anonymous"
];

// Random quote selection
$randomQuote = $quotes[array_rand($quotes)];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard | Study Buddy</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f7f7;
            transition: background-color 0.3s ease;
        }
        body.dark-mode {
            background-color: #333;
            color: #fff;
        }
        .container {
            margin-top: 80px;
            text-align: center;
        }
        h2 {
            margin-bottom: 30px;
        }
        .quote {
            font-style: italic;
            color: #6c757d;
            margin-top: 30px;
        }
        .quote.dark-mode {
            color: #aaa;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Welcome to Study Buddy! 😊</h2>
    <p class="lead">Your personalized study companion.</p>
    
    <div class="quote">
        <p>“<?= $randomQuote ?>”</p>
    </div>

    <div class="mt-4">
        <a href="pomodoro.php" class="btn btn-primary">Start Pomodoro Timer</a>
        <a href="task-planner.php" class="btn btn-secondary">Go to Task Planner</a>
    </div>

    <!-- Toggle Button -->
    <button id="themeToggle" class="btn btn-dark mt-4">Switch to Dark Mode</button>
</div>

<script>
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;

    // Check if dark mode is saved in localStorage
    if (localStorage.getItem('darkMode') === 'enabled') {
        body.classList.add('dark-mode');
        themeToggle.innerText = 'Switch to Light Mode';
    }

    themeToggle.addEventListener('click', () => {
        body.classList.toggle('dark-mode');
        
        // Save the user's preference to localStorage
        if (body.classList.contains('dark-mode')) {
            themeToggle.innerText = 'Switch to Light Mode';
            localStorage.setItem('darkMode', 'enabled');
        } else {
            themeToggle.innerText = 'Switch to Dark Mode';
            localStorage.removeItem('darkMode');
        }
    });
</script>
</body>
</html>
