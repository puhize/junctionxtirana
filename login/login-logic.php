<?php
session_start();

require ("../config/config.php");
include('index.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (password_verify($password, $user['password'])) {
                header("Location: index.php");
                exit();
            } else {
                echo "Invalid email or password";
            }
        } else {
            echo "Invalid email or password";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
} else {
    echo "Invalid email or password";
}
?>
