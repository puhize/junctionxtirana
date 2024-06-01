<?php
session_start();

require("../config/config.php");

// Initialize error message variable
$errorMsg = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        $checkSql = "SELECT * FROM users WHERE email=:email";
        $checkStmt = $conn->prepare($checkSql);
        $checkStmt->bindParam(":email", $email);
        $checkStmt->execute();
        $existingUser = $checkStmt->fetch();

        if ($existingUser) {
            $_SESSION['errorMsg'] = "Email is already registered. Please use a different email.";

        } else {
            $sql = "INSERT INTO users (name, surname, email, password) VALUES (:name, :surname, :email, :password)";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":surname", $surname);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $hashedPassword);

            if ($stmt->execute()) {
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['errorMsg'] = "Error: Unable to register. Please try again.";
            }
        }
    } catch (PDOException $e) {
        $_SESSION['errorMsg'] = "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid request.";
}
