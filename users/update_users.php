<?php
// Include database configuration
require '../config/config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["userId"])) {
    // Get user ID and other edited information from the form

    $userId = $_POST["userId"];
    $firstName = $_POST["editFirstName"];
    $lastName = $_POST["editLastName"];
    $email = $_POST["editEmail"];
    $role = $_POST["editRole"];

    try {
        // Prepare SQL statement to update user information
        $sql = "UPDATE users SET name = :firstName, surname = :lastName, email = :email, role = :role WHERE id = :userId";
        $stmt = $conn->prepare($sql);
        // Bind parameters
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":firstName", $firstName);
        $stmt->bindParam(":lastName", $lastName);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":role", $role);
        // Execute the update query
        $stmt->execute();
        // Redirect back to the page with the user table
        header("Location:../dashboards/Admin.php");
        exit();
    } catch (PDOException $e) {
        // Handle any errors
        echo "Error: " . $e->getMessage();
    }
} else {
    // If the form is not submitted, redirect back to the page with the user table
    header("Location:../dashboards/Admin.php");
    exit();
}
?>
