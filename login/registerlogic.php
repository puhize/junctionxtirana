<?php
session_start();

require "./database/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $name = $_POST["name"];
    $surname = $_POST["surname"];
    $email = $_POST["email"];
    $password = $_POST["password"];

    // Hash the password before storing it
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, surname, email, password,) VALUES (:name, :surname, :email, :password,)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":surname", $surname);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $hashedPassword);

    if ($stmt->execute()) {
        // Redirect after successful registration
        header("Location: login.php");
        exit();
    } else {
        echo "Error: Unable to register. Please try again.";
    }
}
