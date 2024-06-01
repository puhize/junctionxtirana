<?php
require('../config/config.php');

// Function to fetch users for dropdown
function getUsersDropdown($conn) {
    $stmt = $conn->query("SELECT id, name FROM users");
    $options = "";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $options .= "<option value='{$row['id']}'>{$row['name']}</option>";
    }
    return $options;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $title = htmlspecialchars($_POST["title"]);
    $description = htmlspecialchars($_POST["description"]);
    $status = htmlspecialchars($_POST["status"]);
    $priority = htmlspecialchars($_POST["priority"]);
    $deadline = htmlspecialchars($_POST["deadline"]);
    $assigned_to = htmlspecialchars($_POST["assigned_to"]);

    // Prepare and execute SQL query to insert data
    $sql = "INSERT INTO tasks (title, description, status, priority, deadline, assigned_to) 
            VALUES (:title, :description, :status, :priority, :deadline, :assigned_to)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':title', $title);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':status', $status);
    $stmt->bindParam(':priority', $priority);
    $stmt->bindParam(':deadline', $deadline);
    $stmt->bindParam(':assigned_to', $assigned_to);
  
    if ($stmt->execute()) {
        // Display success message
        echo "<script>alert('New record created successfully.');</script>";
    } else {
        // Display error message if the execution fails
        echo "Error: " . $stmt->errorInfo()[2];
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Create Task</title>
</head>
<body>
<h2>Create Task</h2>
<form method="post" action="create_task.php">
  <label for="title">Title:</label>
  <input type="text" id="title" name="title" required><br>
  
  <label for="description">Description:</label>
  <textarea id="description" name="description" required></textarea><br>
  
  <label for="status">Status:</label>
  <select id="status" name="status" required>
    <option value="Pending">Pending</option>
    <option value="In Progress">In Progress</option>
    <option value="Completed">Completed</option>
  </select><br>
  
  <label for="priority">Priority:</label>
  <select id="priority" name="priority" required>
    <option value="Low">Low</option>
    <option value="Medium">Medium</option>
    <option value="High">High</option>
  </select><br>
  
  <label for="deadline">Deadline:</label>
  <input type="date" id="deadline" name="deadline" required><br>
  
  <label for="assigned_to">Assigned To:</label>
  <select id="assigned_to" name="assigned_to" required>
    <?php echo getUsersDropdown($conn); ?>
  </select><br>

  <input type="submit" value="Submit">
</form>
</body>
</html>
