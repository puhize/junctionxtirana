<?php
include('../config/config.php');

if(isset($_GET['id'])) {
    $sql = "DELETE FROM tasks WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':id', $_GET['id']);
    if($stmt->execute()) {
        header("Location: ../views/all_tasks.php");
        exit();
    } else {
        // Error occurred while deleting the task
        echo "Error deleting task.";
    }
} else {
    // Invalid or missing task ID
    echo "Invalid task ID.";
}
?>
