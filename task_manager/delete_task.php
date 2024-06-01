<?php
require ('../config/config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM tasks WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        echo "Task deleted successfully";
    } else {
        echo "Error: " . $stmt->errorInfo()[2];
    }
} else {
    die("ID not specified.");
}

header("Location: task_m.php");
?>
