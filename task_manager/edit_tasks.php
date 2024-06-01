<?php

require('../config/config.php');

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Retrieve form data
    $id = $_POST["id"];
    $title = $_POST["title"];
    $description = $_POST["description"];
    $status = $_POST["status"];
    $priority = $_POST["priority"];
    $deadline = $_POST["deadline"];
    $assigned_to = $_POST["assigned_to"];

    try {
        // Prepare the SQL statement with named placeholders
        $stmt = $conn->prepare("UPDATE tasks SET title = :title, description = :description, status = :status, priority = :priority, deadline = :deadline, assigned_to = :assigned_to WHERE id = :id");

        // Bind the parameters to the SQL query
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':priority', $priority);
        $stmt->bindParam(':deadline', $deadline);
        $stmt->bindParam(':assigned_to', $assigned_to);

        // Execute the query
        $stmt->execute();

        // Redirect to task manager page after successful update
        header("Location: task_m.php");
        exit(); // Ensure no further code is executed after redirection
    } catch (PDOException $e) {
        // Display error message if something goes wrong
        echo "Error: " . $e->getMessage();
    }
}
?>
