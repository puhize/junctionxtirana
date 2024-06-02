<?php
include('../config/config.php');
include('../task_manager/getEnums.php');

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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
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
<?php
$sql = "SELECT * FROM tasks";
$stmt = $conn->prepare($sql);
$stmt->execute();
$tasks = $stmt->fetchAll(PDO::FETCH_ASSOC);



$userSql = "SELECT * FROM users WHERE role='employee'";
$userStmt = $conn->prepare($userSql);
$userStmt->execute();
$employees = $userStmt->fetchAll(PDO::FETCH_ASSOC);

$statuses = getEnumValues($conn, 'tasks', 'status');
$priorities = getEnumValues($conn, 'tasks', 'priority');


?>

<body class="bg-light">
    <div class="container py-4">
        <div class="container-fluid px-4">
            <h1 class="mt-4">Tasks</h1>
            <ol class="breadcrumb mb-4"></ol>
            <div class="card mb-4">
                <div class="card-header">Tasks Management Table</div>
                <div class="card-body">
                    <div class="card-body">
                        <button type="button" class="btn btn-secondary mb-4" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                            <i class="fa-solid fa-plus"></i> Add New Task
                        </button>
                    </div>
                    <!-- Task Table -->
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
                                        <form method="post" action="edit_tasks.php">
                                            <input type="hidden" name="id" value="<?= $task['id'] ?>">
                                            <a href='../task_manager/delete_task.php?id=<?= $task['id'] ?>' class="btn btn-sm btn-primary edit-btn">Delete</a>
                                            <button type="button" class="btn btn-sm btn-primary edit-btn" data-bs-toggle="modal" data-bs-target="#editTaskModal<?= $task['id'] ?>" data-id="<?= $task['id'] ?>">Edit</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
    <!-- Add Task Modal -->
    <div class="modal" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTaskModalLabel">Add New Task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="../task_manager/create_task.php">
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
                                <?php foreach ($statuses as $status) : ?>
                                    <option><?php echo $status; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="priority" class="form-label">Priority:</label>
                            <select class="form-select" id="priority" name="priority">
                                <?php foreach ($priorities as $priority) : ?>
                                    <option><?php echo $priority; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="deadline" class="form-label">Deadline:</label>
                            <?php $today = date('Y-m-d'); ?>
                            <input type="date" class="form-control" id="deadline" name="deadline" min=<?php echo $today; ?>>
                        </div>
                        <div class="mb-3">
                            <label for="assigned_to" class="form-label">Assign To:</label>
                            <select class="form-select" id="assigned_to" name="assigned_to">
                                <?php foreach ($employees as $employee) : ?>
                                    <option value="<?php echo $employee['id']; ?>"><?php echo $employee["name"] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="update">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Task Modal -->
    <?php foreach ($tasks as $task) : ?>
        <div class="modal" id="editTaskModal<?= $task['id'] ?>" tabindex="-1" aria-labelledby="editTaskModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTaskModalLabel">Edit Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="../task_manager/update_task.php">
                            <input type="hidden" name="taskId" value="<?= $task['id'] ?>">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" value="<?php echo $task['title']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <input type="text" class="form-control" id="description" name="description" value="<?php echo $task['description']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status:</label>
                                <select class="form-select" id="status" name="status">
                                    <?php foreach ($statuses as $status) : ?>
                                        <option <?php echo ($task['status'] == $status) ? 'selected' : ''; ?>><?php echo $status; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="priority" class="form-label">Priority:</label>
                                <select class="form-select" id="priority" name="priority">
                                    <?php foreach ($priorities as $priority) : ?>
                                        <option <?php echo ($task['priority'] == $priority) ? 'selected' : ''; ?>><?php echo $priority; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="deadline" class="form-label">Deadline:</label>
                                <?php $today = date('Y-m-d'); ?>
                                <input type="date" class="form-control" id="deadline" name="deadline" value="<?php echo $task['deadline']; ?>  min=<?php echo $today; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="assigned_to" class="form-label">Assigned To:</label>
                                <select class="form-select" id="assigned_to" name="assigned_to">
                                    <?php foreach ($employees as $employee) : ?>
                                        <option value="<?php echo $employee['id']; ?>" <?php echo ($task['assigned_to'] == $employee['id']) ? 'selected' : ''; ?>><?php echo $employee["name"]; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary" name="update">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
</body>

</html>