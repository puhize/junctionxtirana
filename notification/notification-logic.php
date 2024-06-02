<?php
require('../config/config.php');

// Function to fetch users for dropdown
function getUsersDropdown($conn) {
    $stmt = $conn->query("SELECT id, name FROM notification");
    $options = "";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $options .= "<option value='{$row['id']}'>{$row['name']}</option>";
    }
    return $options;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = $_POST["name"];
    $task_id = $_POST["task_id"];
    $employee_id = $_POST["employee_id"];
    $manager_id = $_POST["manager_id"];
    $notification_type = $_POST["notification_type"];
    $created_at = $_POST["created_at"];
    $read_at = $_POST["read_at"];
    $description = $_POST["description"];

    // Prepare and execute SQL query to insert data
    $sql = "INSERT INTO notifications (name,task_id, employee_id, manager_id, notification_type, created_at, read_at, description) 
            VALUES (:name,:task_id, :employee_id, :manager_id, :notification_type, :created_at, :read_at, :description)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':task_id', $task_id);
    $stmt->bindParam(':employee_id', $employee_id);
    $stmt->bindParam(':manager_id', $manager_id);
    $stmt->bindParam(':notification_type', $notification_type);
    $stmt->bindParam(':created_at', $created_at);
    $stmt->bindParam(':read_at', $read_at);
    $stmt->bindParam(':description', $description);
  
    if ($stmt->execute()) {
        // Display success message
        echo "<script>alert('New record created successfully.');</script>";
        header("Location: ../views/e-dashboard.php");
    } else {
        // Display error message if the execution fails
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>