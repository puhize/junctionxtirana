<?php
require ('../config/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["taskId"])) {
        $id = $_POST['taskId'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        $priority = $_POST['priority'];
        $deadline = $_POST['deadline'];
        $assigned_to = $_POST['assigned_to'];


        $sql = "UPDATE tasks SET title = :title, description = :description, status = :status, priority = :priority, deadline = :deadline, assigned_to = :assigned_to WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':priority', $priority);
        $stmt->bindParam(':deadline', $deadline);
        $stmt->bindParam(':assigned_to', $assigned_to);

        if ($stmt->execute()) {
            echo "Task updated successfully";
            header("Location: ../views/all_tasks.php");
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    } else {
        $sql = "SELECT * FROM tasks WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $task = $stmt->fetch(PDO::FETCH_ASSOC);
    }


?>

