<?php
session_start();
require_once 'php/dbconnect.php';

$nameErr = $emailErr = $passErr = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Input validation
    if (!preg_match("/^[a-zA-Z ]*$/", $name)) {
        $nameErr = "Only letters and white space allowed";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
    } elseif (strlen($password) < 6) {
        $passErr = "Password must be at least 6 characters";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $hashedPassword);

        if ($stmt->execute()) {
            $success = "Signup successful! Please <a href='login.php'>login here</a>.";
        } else {
            $emailErr = "Email already registered.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link id="themeStylesheet" rel="stylesheet" href="css/style.css">

    <meta charset="UTF-8">
    <title>Signup | Study Buddy</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 500px;">
        <div class="card-body">
            <h3 class="card-title text-center">Create an Account</h3>
            <?php if ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>
            <form method="post" action="">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" class="form-control" required>
                    <small class="text-danger"><?= $nameErr ?></small>
                </div>
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
                <button type="submit" class="btn btn-primary btn-block">Signup</button>
            </form>
            <p class="mt-3 text-center">Already have an account? <a href="login.php">Login here</a>.</p>
        </div>
    </div>
</div>
</body>
</html>
