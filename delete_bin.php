<?php
include 'db.php';

$id = (int)$_GET['id'];

// Delete bin with this id
$conn->query("DELETE FROM bins WHERE id=$id");

header("Location: dashboard.php");
exit();
?>
