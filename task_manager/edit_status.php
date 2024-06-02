<?php 

require '../config/config.php';

if (isset($_POST['submit'])) {
    $id = $_POST["id"];
    $status = $_POST["status_active"];
    $status = str_replace("_"," ",$status);

    if (!empty($_POST["status_active"])) {
        try {
            if ($status === "done") {
                $currentTime = date('Y-m-d H:i:s');
                $stmt = $conn->prepare("UPDATE tasks SET status = :status, completed_at = :completed_at WHERE id = :id");
                $stmt->bindParam(':completed_at', $currentTime);
            } else {
                // Update only the status column
                $stmt = $conn->prepare("UPDATE tasks SET status = :status WHERE id = :id");
            }

            // Bind parameters and execute the query
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':status', $status);
            $stmt->execute();
            // Redirect back to the dashboard
            header("Location: ../views/e-dashboard.php");
            exit(); 
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

?>
