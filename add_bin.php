<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $location = $conn->real_escape_string($_POST['location']);
    $status = $conn->real_escape_string($_POST['status']);
    $collector = $conn->real_escape_string($_POST['collector']);
    $date = $conn->real_escape_string($_POST['date']);
    $checkpoint_id = (int)$_POST['checkpoint'];

    $sql = "INSERT INTO bins (location, status, collector_name, pickup_date, checkpoint_id)
            VALUES ('$location', '$status', '$collector', '$date', $checkpoint_id)";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<div class='container'><p class='error'>Error: " . $conn->error . "</p></div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Bin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Add Bin</h2>
    <form method="post" action="">
        <label>Location:</label><br>
        <input type="text" name="location" required><br><br>

        <label>Status:</label><br>
        <select name="status">
            <option value="Empty">Empty</option>
            <option value="Full">Full</option>
        </select><br><br>

        <label>Collector Name:</label><br>
        <input type="text" name="collector" required><br><br>

        <label>Date:</label><br>
        <input type="date" name="date" required><br><br>

        <label>Checkpoint:</label><br>
        <select name="checkpoint">
            <option value="1">Checkpoint A</option>
            <option value="2">Checkpoint B</option>
            <option value="3">Checkpoint C</option>
        </select><br><br>

        <input type="submit" value="Add Bin">
    </form>
</div>
</body>
</html>
