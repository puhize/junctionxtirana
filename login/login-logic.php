
<?php
session_start();


require "./database/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
    $email = $_POST["inputEmail"];
    $password = $_POST["inputPassword"];

    $sql = "SELECT * FROM users WHERE Email=:email";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":email", $email);
    $stmt->execute();
    $user = $stmt->fetch();
    header("Location: index.php");
    exit();
} else {
    echo "Invalid email or password";
}
?>