<?php
// Include your database connection here
include('../config/config.php');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the current time
    $currentTime = date('Y-m-d H:i:s');
    $id = $_POST['id'];
    
    // Update the database table with the current time for the completed_at column
    $sql = "UPDATE tasks SET completed_at = :completed_at WHERE ";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':completed_at', $currentTime);
    $stmt->execute();

    // Echo a response (optional)
    echo "Completed at updated successfully";
} else {
    // If the request method is not POST, return an error
    http_response_code(405);
    echo "Method Not Allowed";
}
?>
