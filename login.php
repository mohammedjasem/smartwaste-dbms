<?php
session_start();
include 'db.php';

$errorMessage = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check credentials in database
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Login success: save user session
        $_SESSION['user'] = $username;
        header("Location: dashboard.php");
        exit();
    } else {
        $errorMessage = "Wrong username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login-Smart Waste</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <?php if ($errorMessage != "") { ?>
        <p class="error"><?= $errorMessage ?></p>
    <?php } ?>
    <form method="post">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Login">
    </form>
</div>
</body>
</html>
