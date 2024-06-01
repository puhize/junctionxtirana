<?php 

require '../config/config.php';
if (isset($_POST['submit'])) {
    $id = $_POST["id"];
    $status = $_POST["status_active"];
    $status = str_replace("_"," ",$status);

    if (!empty($_POST["status_active"])) {

        try {
        
            $stmt = $conn->prepare("UPDATE tasks SET status = :status WHERE id = :id");
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
            header("Location: e-dashboard.php");
            exit(); 
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}


?>