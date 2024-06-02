<?php
require '../config/config.php';
session_start();
include('../dashboards/employee.php');
include('../config/config.php');
include('includes/header.php');

$sql = "SHOW COLUMNS FROM tasks WHERE Field = 'status'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt3 = $conn->query("SELECT * FROM notifications");
  $notifications = $stmt3->fetchAll(PDO::FETCH_ASSOC);


// Fetch the column information
$columnInfo = $stmt->fetch(PDO::FETCH_ASSOC);

if ($columnInfo) {
    // Extract enum values from the column definition
    preg_match_all("/'([^']+)'/", $columnInfo['Type'], $matches);
    $enumValues = $matches[1];

    // Output the enum values
}



?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="100x100" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="https://cdn.discordapp.com/attachments/1239877130016264203/1246494735955398756/erta-logo.png?ex=665c982f&is=665b46af&hm=37da24a2c8e62d1df181f3041a913d796ff77b270f56268bd5996b06f7b9ec37&">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Manage Mate
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <!-- CSS Files -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="../assets/css/paper-dashboard.css" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    <link href="../assets/demo/demo.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>


<?php include('includes/header.php'); ?>

<body>
    <div class="wrapper ">
        <?php include('includes/sidebar.php'); ?>
        <div class="main-panel" style="height: 100vh;">
            <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
                <div class="container-fluid">
                    <div class="navbar-wrapper">
                        <div class="navbar-toggle">
                            <button type="button" class="navbar-toggler">
                                <span class="navbar-toggler-bar bar1"></span>
                                <span class="navbar-toggler-bar bar2"></span>
                                <span class="navbar-toggler-bar bar3"></span>
                            </button>
                        </div>
                        <a class="navbar-brand" href="javascript:;"><?php echo $_SESSION['user']['name'] . " " . $_SESSION['user']['surname'] ?></a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                        <span class="navbar-toggler-bar navbar-kebab"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-end" id="navigation">
                        <ul class="navbar-nav">
                            <li class="nav-item btn-rotate dropdown">
                                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="nc-icon nc-bell-55"></i>
                                    <p>
                                        <span class="d-lg-none d-md-block">Some Actions</span>
                                    </p>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                                    <?php foreach ($notifications as $notification) : ?>
                                        <a class="dropdown-item" href="detailedNotifications.php?notificationId=<?php echo $notification['id']; ?>"><?php echo $notification['name']; ?></a>
                                    <?php endforeach; ?>


                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <style>
                .task {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 10px;
                    border-bottom: 1px solid #ddd;
                }

                .task-title {
                    margin: 0;
                    font-size: 14px;
                }

                .task-icon {
                    cursor: pointer;
                }
            </style>
            <div class="content">
                <div class="row">
                    <?php
                    foreach ($enumValues as $status) { ?>
                        <div class="col-md-2">
                            <div class="card">
                                <div class="card-header" style="background-color: #00344F; color: white;">
                                    <h5 class="card-category"><?php echo $status; ?></h5>
                                </div>
                                <div class="card-body" style="max-height: 300px; height: 300px; overflow-y: auto;" id="backlogCardBody">
                                    <?php
                                    // $taskStmt = $conn->prepare("SELECT * FROM tasks WHERE status = :status");
                                    // $taskStmt->bindParam(':status', $status);
                                    // $taskStmt->execute();
                                    // $tasks = $taskStmt->fetchAll(PDO::FETCH_ASSOC);
                                    foreach ($tasks as $task) { ?>
                                        <?php if ($task['status'] == $status) { ?>
                                            <?php $modalId = 'taskModal' . $task['id']; ?>
                                            <div class="task">
                                                <span class="task-title">
                                                    <?php echo $task['title']; ?>
                                                </span>
                                                <i class="fa fa-info-circle task-icon" data-toggle="modal" data-target="#<?php echo $modalId; ?>"></i>

                                            </div>
                                            <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $modalId; ?>" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="<?php echo $modalId; ?>"><?php echo $task['title']; ?></h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="title" class="form-label">Title:</label>
                                                                <p class="form-control" name="title" id="title"> <?php echo $task['title']; ?></p>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="description" class="form-label">Description:</label>

                                                                <p class="form-control" id="description" name="description"><?php echo $task['description']; ?></p>

                                                            </div>

                                                            <form method="POST" name="editStatus" action="../task_manager/edit_status.php">
                                                                <div class="mb-3">
                                                                    <input type="hidden" name="id" id="editTaskIdInput" value="<?php echo $task['id']; ?>">
                                                                    <label for="status" class="form-label">Status:</label>
                                                                    <select class="form-select" id="status_active" name="status_active">
                                                                        <option value="backlog">Backlog</option>
                                                                        <option value="in_progress">In Progress</option>
                                                                        <option value="in_review">In Review</option>
                                                                        <option value="ready_for_schedule">Ready for Schedule</option>
                                                                        <option value="scheduled">Scheduled</option>
                                                                        <option value="done">Done</option>
                                                                    </select>
                                                                </div>
                                                                <button type="submit" class="btn btn-primary" name="submit">Set status</button>
                                                            </form>

                                                            <div class="mb-3">
                                                                <label for="priority" class="form-label">Priority:</label>
                                                                <select class="form-select" id="priority" name="priority" readonly>
                                                                    <option value="<?php echo $task['priority']; ?>"><?php echo $task['priority']; ?></option>
                                                                </select>
                                                            </div>
                                                            <?php if ($task['deadline'] !== null) : ?>
                                                                <div class="mb-3">
                                                                    <label for="deadline" class="form-label">Deadline:</label>
                                                                    <p class="form-control" id="deadline" name="deadline"><?php echo $task['deadline']; ?></p>
                                                                </div>
                                                            <?php endif; ?>



                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                    <?php } ?>

                                </div>
                            </div>
                        </div>
                    <?php  } ?>
                </div>

                <footer class="footer" style="position: absolute; bottom: 0; width: -webkit-fill-available;">
                    <div class="container-fluid">
                        <div class="row">
                            <nav class="footer-nav">
                                <ul>
                                    <li><a href="https://ertadigitalmarketing.com/" target="_blank">ERTA</a></li>
                                    <li><a href="https://www.facebook.com/ertadigitalmarketing" target="_blank">Facebook</a></li>
                                    <li><a href="https://www.instagram.com/fioralbafazlli/" target="_blank">Instagram</a></li>

                                </ul>
                            </nav>

                        </div>
                    </div>
                </footer>
            </div>
            <!--   Core JS Files   -->
            <script src="../assets/js/core/jquery.min.js"></script>
            <script src="../assets/js/core/popper.min.js"></script>
            <script src="../assets/js/core/bootstrap.min.js"></script>
            <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
            <!--  Google Maps Plugin    -->
            <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
            <!-- Chart JS -->
            <script src="../assets/js/plugins/chartjs.min.js"></script>
            <!--  Notifications Plugin    -->
            <script src="../assets/js/plugins/bootstrap-notify.js"></script>
            <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
            <script src="../assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>

            <script>
                // function selectOption() {
                //     const selectElement = document.getElementById('status_active');
                //     const selectedValue = selectElement.value;

                //     for (let i = 0; i < selectElement.options.length; i++) {
                //         if (selectElement.options[i].value == selectElement.value) {
                //             selectElement.options[i].selected = true;
                //         }
                //     }

                // }
            </script>
</body>

</html>