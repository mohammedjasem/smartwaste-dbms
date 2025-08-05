<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';

// Get bins with checkpoint names
$sql = "SELECT bins.*, checkpoints.name AS checkpoint_name 
        FROM bins LEFT JOIN checkpoints ON bins.checkpoint_id = checkpoints.id";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Smart Waste</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <nav>
        Hi,  <?= htmlspecialchars($_SESSION['user']) ?> |
        <a href="logout.php">Logout</a> |
        <a href="add_bin.php">Add Bin</a>
    </nav>

    <h3>Waste Bins Status</h3>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Location</th>
            <th>Status</th>
            <th>Collector</th>
            <th>Date</th>
            <th>Checkpoint</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { 
            $rowClass = ($row['status'] == 'Full') ? "full" : "";
        ?>
        <tr class="<?= $rowClass ?>">
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['location']) ?></td>
            <td><?= $row['status'] ?></td>
            <td><?= htmlspecialchars($row['collector_name']) ?></td>
            <td><?= htmlspecialchars($row['pickup_date'] ?: "N/A") ?></td>
            <td><?= htmlspecialchars($row['checkpoint_name']) ?></td>
            <td>
                <a href="edit_bin.php?id=<?= $row['id'] ?>">Edit</a> | 
                <a href="delete_bin.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this bin?');">Delete</a>
            </td>
        </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
