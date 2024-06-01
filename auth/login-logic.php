<?php
session_start();
require("../config/config.php");
include('index.php');


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {

    $email = $_POST["email"];
    $password = $_POST["password"];

    try {
        $sql = "SELECT * FROM users WHERE email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'surname' => $user['surname'],
                    'email' => $user['email'],
                    'role' => $user['role']
                ];

                if ($user['role'] == 'manager') {
                    header("Location: ../views/manager_dashboard.php");
                } else {
                    header("Location: ../views/e-dashboard.php");
                }
                exit();
            } else {
                $error = "Invalid email or password";
            }
        } else {
            $error = "Invalid email or password";
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
} else {
    $error = "Invalid request method";
}
