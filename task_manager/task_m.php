<?php

class DatabaseConnection
{
    private $servername = "localhost";
    private $username = "root";
<<<<<<< HEAD
    private $password = ""; 
=======
    private $password = ""; // Leave this empty
>>>>>>> 42dbefeead2bca6fe7bb1a70dec14bdb6ad63f13
    private $dbname = "managemate_db";

    public function startConnection()
    {
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

class TaskManager
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function createTask($title, $description, $status, $priority, $deadline, $assigned_to)
    {
        $sql = "INSERT INTO tasks (title, description, status, priority, deadline, assigned_to) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$title, $description, $status, $priority, $deadline, $assigned_to]);
    }

    public function getTasks()
    {
        $sql = "SELECT tasks.id, tasks.title, tasks.description, tasks.status, tasks.priority, tasks.deadline, CONCAT(users.name, ' ', users.surname) AS assigned_to 
                FROM tasks 
                LEFT JOIN users ON tasks.assigned_to = users.id";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

<<<<<<< HEAD
    /*
=======
>>>>>>> 42dbefeead2bca6fe7bb1a70dec14bdb6ad63f13
    public function updateTask($id, $title, $description, $status, $priority, $deadline, $assigned_to)
    {
        $sql = "UPDATE tasks SET title=?, description=?, status=?, priority=?, deadline=?, assigned_to=? WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$title, $description, $status, $priority, $deadline, $assigned_to, $id]);
    }*/

<<<<<<< HEAD
  

    /*public function deleteTask($id)
=======
    public function deleteTask($id)
>>>>>>> 42dbefeead2bca6fe7bb1a70dec14bdb6ad63f13
    {
        $sql = "DELETE FROM tasks WHERE id=?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
    }
<<<<<<< HEAD
*/
=======

>>>>>>> 42dbefeead2bca6fe7bb1a70dec14bdb6ad63f13
    public function getUsers()
    {
        $sql = "SELECT id, name, surname FROM users";
        $stmt = $this->conn->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTaskById($id)
    {
        $sql = "SELECT tasks.id, tasks.title, tasks.description, tasks.status, tasks.priority, tasks.deadline, tasks.assigned_to 
                FROM tasks 
                WHERE tasks.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Initialize the connection
$database = new DatabaseConnection();
$conn = $database->startConnection();

// Initialize TaskManager
$taskManager = new TaskManager($conn);

// Fetch users
$users = $taskManager->getUsers();

// Handling CRUD operations

// Create operation
if (isset($_POST['create'])) {
    $taskManager->createTask($_POST['title'], $_POST['description'], $_POST['status'], $_POST['priority'], $_POST['deadline'], $_POST['assigned_to']);
}

// Read operation
$tasks = $taskManager->getTasks();


$sql = "SELECT * FROM users WHERE role = 'employee'";
$stmt = $conn->prepare($sql); // Prepare the SQL query
$stmt->execute(); // Execute the prepared statement
$employees = $stmt->fetchAll(); // Fetch all the rows



// Update operation
if (isset($_POST['update'])) {
    $taskManager->updateTask($_POST['id'], $_POST['title'], $_POST['description'], $_POST['status'], $_POST['priority'], $_POST['deadline'], $_POST['assigned_to']);
}

// Delete operation
<<<<<<< HEAD
//if (isset($_POST['delete'])) {
  //  $taskManager->deleteTask($_POST['id']);
//}

// Edit operation
if (isset($_POST['edit'])) {
    $taskId = $_POST['id'];
    // Retrieve the task details from the database based on the selected task ID
    $selectedTask = $taskManager->getTaskById($taskId);
=======
if (isset($_POST['delete'])) {
    $taskManager->deleteTask($_POST['id']);
>>>>>>> 42dbefeead2bca6fe7bb1a70dec14bdb6ad63f13
}

// Edit operation
if (isset($_POST['edit'])) {
    $taskId = $_POST['id'];
    // Retrieve the task details from the database based on the selected task ID
    $selectedTask = $taskManager->getTaskById($taskId);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .action-links button {
            margin-right: 5px;
        }

        .action-links button:hover {
            opacity: 0.8;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-4">
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tasks</h1>
            <ol class="breadcrumb mb-4">
            </ol>

            <div class="card mb-4">
                <div class="card-header">
                    Tasks Management Table
                </div>
                <div class="card-body ">
                    <div class="card-body">
                        <!-- Button trigger modal -->

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-secondary  mb-4" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                            <i class="fa-solid fa-plus"></i> Add New Task
                        </button>


                        <!-- Modal -->
                        <div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="post">
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Title:</label>
                                                <input type="text" class="form-control" id="title" name="title" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description:</label>
                                                <input type="text" class="form-control" id="description" name="description" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="status" class="form-label">Status:</label>
                                                <select class="form-select" id="status" name="status">
                                                    <option value="backlog">Backlog</option>
                                                    <option value="in_progress">In Progress</option>
                                                    <option value="in_review">In Review</option>
                                                    <option value="ready_for_schedule">Ready for Schedule</option>
                                                    <option value="scheduled">Scheduled</option>
                                                    <option value="done">Done</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="priority" class="form-label">Priority:</label>
                                                <select class="form-select" id="priority" name="priority">
                                                    <option value="low">Low</option>
                                                    <option value="medium">Medium</option>
                                                    <option value="high">High</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="deadline" class="form-label">Deadline:</label>
                                                <input type="date" class="form-control" id="deadline" name="deadline">
                                            </div>
                                            <div class="mb-3">
                                                <label for="assigned_to" class="form-label">Assigned To:</label>
<<<<<<< HEAD
                                                <select class="form-select" id="assigned_to" name="assigned_to">
                                                   <?php foreach($employees as $employee){
                                                    ?>  <option value="<?php echo $employee['id']; ?>"><?php echo $employee["name"]?></option>
                                                   <?php } ?>
                                                </select>

=======
                                                <input type="text" class="form-control" id="assigned_to" name="assigned_to">
>>>>>>> 42dbefeead2bca6fe7bb1a70dec14bdb6ad63f13
                                            </div>
                                            <button type="submit" class="btn btn-primary" name="create">Create</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead class="table-dark">
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
                            </thead>
                            <tbody>
                                <?php foreach ($tasks as $task) : ?>
                                    <tr>
                                        <td><?= $task['id'] ?></td>
                                        <td><?= $task['title'] ?></td>
                                        <td><?= $task['description'] ?></td>
                                        <td><?= $task['status'] ?></td>
                                        <td><?= $task['priority'] ?></td>
                                        <td><?= $task['deadline'] ?></td>
                                        <td><?= $task['assigned_to'] ?></td>
                                        <td class="action-links">


<<<<<<< HEAD
                                            <form method="post" action="edit_tasks.php">
=======
                                            <form method="post">
>>>>>>> 42dbefeead2bca6fe7bb1a70dec14bdb6ad63f13
                                                <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                                <!-- Add a hidden input field to store the ID of the task being edited -->
                                                <input type="hidden" id="editTaskId" name="edit_task_id">

<<<<<<< HEAD
                                                <a href='delete_task.php?id=<?php echo $task['id']; ?>' class="btn btn-sm btn-primary edit-btn" >Delete</a>

=======
>>>>>>> 42dbefeead2bca6fe7bb1a70dec14bdb6ad63f13
                                                <!-- Modify the Edit button to trigger the modal and populate its fields -->
                                                <button type="button" class="btn btn-sm btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editTaskModal" data-id="<?= $task['id'] ?>">Edit</button>

                                                <!-- Modal for editing task -->
                                                <div class="modal fade" id="editTaskModal" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form method="post">
<<<<<<< HEAD
                                                                    <input type="hidden" name="id" id="editTaskIdInput" value="<?php echo $task['id'];?>"> <!-- Hidden input to store task ID -->
                                                                    <div class="mb-3">
                                                                        <label for="edit_title" class="form-label">Title:</label>
                                                                        <input type="text" class="form-control" id="edit_title" name="title"  value="<?php echo $task['title']?>" required>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="desc" class="form-label">Description:</label>
                                                                        <input type="text" class="form-control" id="desc" name="description"  value="<?php echo $task['description']?>" >
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="status" class="form-label">Status:</label>
                                                                      
                                                                        <select class="form-select" id="status" name="status" value="<?php echo $task['status']; ?>">
                                                                            <option value="backlog">Backlog</option>
                                                                            <option value="in_progress">In Progress</option>
                                                                            <option value="in_review">In Review</option>
                                                                            <option value="ready_for_schedule">Ready for Schedule</option>
                                                                            <option value="scheduled">Scheduled</option>
                                                                            <option value="done">Done</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="priority" class="form-label">Priority:</label>

                                                                        <select class="form-select" id="priority" name="priority">
                                                                        <option value="low">Low</option>
                                                                        <option value="medium">Medium</option>
                                                                        <option value="high">High</option>
                                                                    </select>
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="deadline" class="form-label">Deadline:</label>
                                                                        <input type="date" class="form-control" id="deadline" name="deadline"  value="<?php echo $task['deadline']?>" >
                                                                    </div>

                                                                    <div class="mb-3">
                                                                        <label for="assigned_to" class="form-label">Assigned_to:</label>
                                                                        <select class="form-select" id="assigned_to" name="assigned_to">
                                                                        <?php foreach($employees as $employee){
                                                                            ?>  <option value="<?php echo $employee['id']; ?>"><?php echo $employee["name"]?></option>
                                                                        <?php } ?>
                                                                        </select>>

                                                                       
                                                                    </div>

                                                                    <!-- Add other input fields for description, status, priority, deadline, assigned_to -->
                                                                    <!-- Use JavaScript to populate these fields with task data -->
                                                                    <button type="submit" class="btn btn-primary" name="submit">Submit</button>
=======
                                                                    <input type="hidden" name="id" id="editTaskIdInput"> <!-- Hidden input to store task ID -->
                                                                    <div class="mb-3">
                                                                        <label for="edit_title" class="form-label">Title:</label>
                                                                        <input type="text" class="form-control" id="edit_title" name="title" required>
                                                                    </div>
                                                                    <!-- Add other input fields for description, status, priority, deadline, assigned_to -->
                                                                    <!-- Use JavaScript to populate these fields with task data -->
                                                                    <button type="submit" class="btn btn-primary" name="update">Update</button>
>>>>>>> 42dbefeead2bca6fe7bb1a70dec14bdb6ad63f13
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <script>
                                                    // JavaScript to handle edit button click and populate modal fields
                                                    document.querySelectorAll('.edit-btn').forEach(button => {
                                                        button.addEventListener('click', function() {
                                                            const taskId = this.getAttribute('data-id');
                                                            const task = <?php echo json_encode($selectedTask); ?>;
                                                            document.getElementById('editTaskIdInput').value = taskId;
                                                            document.getElementById('edit_title').value = task.title;
                                                            // Populate other fields similarly
                                                        });
                                                    });
                                                </script>

<<<<<<< HEAD
                                               <!-- <button type="submit" class="btn btn-sm btn-danger" name="delete">Delete</button>-->
=======
                                                <button type="submit" class="btn btn-sm btn-danger" name="delete">Delete</button>
>>>>>>> 42dbefeead2bca6fe7bb1a70dec14bdb6ad63f13
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Bootstrap Bundle with Popper -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> 42dbefeead2bca6fe7bb1a70dec14bdb6ad63f13
