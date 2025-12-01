<?php
session_start();
require_once 'php/dbconnect.php';

$emailErr = $passErr = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $stmt->store_result();
    if ($stmt->num_rows == 1) {
        $stmt->bind_result($id, $name, $hashedPassword);
        $stmt->fetch();

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            header("Location: dashboard.php");
            exit;
        } else {
            $passErr = "Incorrect password";
        }
    } else {
        $emailErr = "No user found with that email";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link id="themeStylesheet" rel="stylesheet" href="css/style.css">

    <meta charset="UTF-8">
    <title>Login | Study Buddy</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f2f2f2;
        }
        .card {
            margin-top: 80px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-body">
            <h3 class="card-title text-center">Login to Study Buddy</h3>
            <form method="post" action="">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                    <small class="text-danger"><?= $emailErr ?></small>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                    <small class="text-danger"><?= $passErr ?></small>
                </div>
                <button type="submit" class="btn btn-success btn-block">Login</button>
            </form>
            <p class="mt-3 text-center">Don't have an account? <a href="signup.php">Signup here</a>.</p>
        </div>
    </div>
</div>
</body>
</html>
