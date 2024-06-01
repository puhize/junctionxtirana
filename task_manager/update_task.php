<?php
require ('../config/config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $status = $_POST['status'];
        $priority = $_POST['priority'];
        $deadline = $_POST['deadline'];
        $assigned_to = $_POST['assigned_to'];
        $client_id = $_POST['client_id'];
        $project_id = $_POST['project_id'];

        $sql = "UPDATE tasks SET title = :title, description = :description, status = :status, priority = :priority, deadline = :deadline, assigned_to = :assigned_to, client_id = :client_id, project_id = :project_id, updated_at = NOW() WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':priority', $priority);
        $stmt->bindParam(':deadline', $deadline);
        $stmt->bindParam(':assigned_to', $assigned_to);
        $stmt->bindParam(':client_id', $client_id);
        $stmt->bindParam(':project_id', $project_id);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            echo "Task updated successfully";
        } else {
            echo "Error: " . $stmt->errorInfo()[2];
        }
    } else {
        $sql = "SELECT * FROM tasks WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $task = $stmt->fetch(PDO::FETCH_ASSOC);
    }
} else {
    die("ID not specified.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Task</title>
</head>
<body>
    <h2>Update Task</h2>
    <form method="post" action="">
        Title: <input type="text" name="title" value="<?php echo $task['title']; ?>" required><br>
        Description: <textarea name="description" required><?php echo $task['description']; ?></textarea><br>
        Status: <input type="text" name="status" value="<?php echo $task['status']; ?>" required><br>
        Priority: <input type="text" name="priority" value="<?php echo $task['priority']; ?>" required><br>
        Deadline: <input type="date" name="deadline" value="<?php echo $task['deadline']; ?>" required><br>
        Assigned To: <input type="text" name="assigned_to" value="<?php echo $task['assigned_to']; ?>" required><br>
        Client ID: <input type="number" name="client_id" value="<?php echo $task['client_id']; ?>" required><br>
        Project ID: <input type="number" name="project_id" value="<?php echo $task['project_id']; ?>" required><br>
        <input type="submit" value="Update Task">
    </form>
</body>
</html>
