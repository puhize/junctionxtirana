<?php

class DatabaseConnection {
    private $servername = "localhost";
    private $username = "root";
    private $password = ""; // Leave this empty
    private $dbname = "managemate_db"; 

    public function startConnection() {
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=$this->dbname", $this->username, $this->password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            return null;
        }
    }
}

class TaskManager {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function createTask($title, $description, $status, $priority, $deadline, $assigned_to) {
        $sql = "INSERT INTO tasks (title, description, status, priority, deadline, assigned_to) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$title, $description, $status, $priority, $deadline, $assigned_to]);
    }

    public function getTasks() {
        $sql = "SELECT * FROM tasks";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateTask($id, $title, $description, $status, $priority, $deadline, $assigned_to) {
        $sql = "UPDATE tasks SET title=?, description=?, status=?, priority=?, deadline=?, assigned_to=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$title, $description, $status, $priority, $deadline, $assigned_to, $id]);
    }

    public function deleteTask($id) {
        $sql = "DELETE FROM tasks WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
    }
}

// Initialize the connection
$database = new DatabaseConnection();
$conn = $database->startConnection();

// Initialize TaskManager
$taskManager = new TaskManager($conn);

// Handling CRUD operations

// Create operation
if(isset($_POST['create'])) {
    $taskManager->createTask($_POST['title'], $_POST['description'], $_POST['status'], $_POST['priority'], $_POST['deadline'], $_POST['assigned_to']);
}

// Read operation
$tasks = $taskManager->getTasks();

// Update operation
if(isset($_POST['update'])) {
    $taskManager->updateTask($_POST['id'], $_POST['title'], $_POST['description'], $_POST['status'], $_POST['priority'], $_POST['deadline'], $_POST['assigned_to']);
}

// Delete operation
if(isset($_POST['delete'])) {
    $taskManager->deleteTask($_POST['id']);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Task Manager</h2>

<form method="post">
    <input type="text" name="title" placeholder="Title">
    <input type="text" name="description" placeholder="Description">
    <select name="status">
        <option value="backlog">Backlog</option>
        <option value="in_progress">In Progress</option>
        <option value="in_review">In Review</option>
        <option value="ready_for_schedule">Ready for Schedule</option>
        <option value="scheduled">Scheduled</option>
        <option value="done">Done</option>
    </select>
    <select name="priority">
        <option value="low">Low</option>
        <option value="medium">Medium</option>
        <option value="high">High</option>
    </select>
    <input type="date" name="deadline" placeholder="Deadline">
    <input type="text" name="assigned_to" placeholder="Assigned To">
    <button type="submit" name="create">Create</button>
</form>

<br>

<table>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Status</th>
        <th>Priority</th>
        <th>Deadline</th>
        <th>Assigned To</th>
        <th>Actions</th>
    </tr>
    <?php foreach($tasks as $task): ?>
    <tr>
        <td><?= $task['id'] ?></td>
        <td><?= $task['title'] ?></td>
        <td><?= $task['description'] ?></td>
        <td><?= $task['status'] ?></td>
        <td><?= $task['priority'] ?></td>
        <td><?= $task['deadline'] ?></td>
        <td><?= $task['assigned_to'] ?></td>
        <td>
            <form method="post">
                <input type="text" name="assigned_to" placeholder="Assigned To">
                <button type="submit" name="update">Update</button>
                <button type="submit" name="delete">Delete</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
