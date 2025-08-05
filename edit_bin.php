<?php
include 'db.php';
$id = (int)$_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $location = $conn->real_escape_string($_POST['location']);
    $status = $conn->real_escape_string($_POST['status']);
    $collector = $conn->real_escape_string($_POST['collector']);
    $date = $conn->real_escape_string($_POST['pickup_date']);
    $checkpoint_id = (int)$_POST['checkpoint_id'];

    $sql = "UPDATE bins SET location='$location', status='$status', collector_name='$collector', pickup_date='$date', checkpoint_id=$checkpoint_id WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<div class='container'><p class='error'>Error: " . $conn->error . "</p></div>";
    }
}

$result = $conn->query("SELECT * FROM bins WHERE id=$id");
$bin = $result->fetch_assoc();

$checkpoints = $conn->query("SELECT * FROM checkpoints");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Bin</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Edit Bin</h2>
    <form method="post">
        <label>Location:</label><br>
        <input type="text" name="location" value="<?= htmlspecialchars($bin['location']) ?>" required><br><br>

        <label>Status:</label><br>
        <select name="status">
            <option value="Empty" <?= $bin['status'] == 'Empty' ? 'selected' : '' ?>>Empty</option>
            <option value="Full" <?= $bin['status'] == 'Full' ? 'selected' : '' ?>>Full</option>
        </select><br><br>

        <label>Collector Name:</label><br>
        <input type="text" name="collector" value="<?= htmlspecialchars($bin['collector_name']) ?>" required><br><br>

        <label>Date:</label><br>
        <input type="date" name="pickup_date" value="<?= htmlspecialchars($bin['pickup_date']) ?>" required><br><br>

        <label>Checkpoint:</label><br>
        <select name="checkpoint_id">
            <?php while ($row = $checkpoints->fetch_assoc()) { ?>
                <option value="<?= $row['id'] ?>" <?= $row['id'] == $bin['checkpoint_id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($row['name']) ?>
                </option>
            <?php } ?>
        </select><br><br>

        <input type="submit" value="Update Bin">
    </form>
</div>
</body>
</html>
