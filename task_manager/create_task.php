<?php
require('../config/config.php');

// Function to fetch users for dropdown
function getUsersDropdown($conn) {
    $stmt = $conn->query("SELECT id, name FROM users");
    $options = "";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $options .= "<option value='{$row['id']}'>{$row['name']}</option>";
    }
    return $options;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $title = $_POST["title"];
    $description = $_POST["description"];
    $status = $_POST["status"];
    $priority = $_POST["priority"];
    $deadline = $_POST["deadline"];
    $assigned_to = $_POST["assigned_to"];

    // Prepare and execute SQL query to insert data
    $sql = "INSERT INTO tasks (title, description, status, priority, deadline, assigned_to) 
            VALUES (:title, :description, :status, :priority, :deadline, :assigned_to)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':priority', $priority);
    $stmt->bindParam(':deadline', $deadline);
    $stmt->bindParam(':assigned_to', $assigned_to);
  
    if ($stmt->execute()) {
        // Display success message
        echo "<script>alert('New record created successfully.');</script>";
        header("Location: ../views/all_tasks.php");
    } else {
        // Display error message if the execution fails
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>


