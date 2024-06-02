<?php
require '../config/config.php';

try {
  $stmt = $conn->query("SELECT * FROM users");
  $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
  $stmt2 = $conn->query("SELECT * FROM tasks");
  $tasks = $stmt2->fetchAll(PDO::FETCH_ASSOC);
  $userCount = count($users);
  $tasksCount = count($tasks);

  $stmt2 = $conn->query("SELECT COUNT(*) AS in_progress_tasks_count FROM tasks WHERE status = 'In Progress'");
  $taskResult = $stmt2->fetch(PDO::FETCH_ASSOC);
  $inProgressTasksCount = $taskResult['in_progress_tasks_count'];


  $stmt2 = $conn->query("SELECT COUNT(*) AS done_tasks_count FROM tasks WHERE status = 'Done'");
  $taskResult2 = $stmt2->fetch(PDO::FETCH_ASSOC);
  $doneTasksCount = $taskResult2['done_tasks_count'];
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}
?>


<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
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


<body>
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
      <div class="logo">
        <!-- <a class="simple-text logo-mini"> -->
        <!-- </a> -->
        <a href="" class="simple-text logo-normal">
          <img src="https://cdn.discordapp.com/attachments/1239877130016264203/1246494735955398756/erta-logo.png?ex=665c982f&is=665b46af&hm=37da24a2c8e62d1df181f3041a913d796ff77b270f56268bd5996b06f7b9ec37&" alt="" style="width: 50px; height: auto;">
          Manage Mate
        </a>

      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          <li class="active ">
            <a href="javascript:;">
              <i class="nc-icon nc-layout-11"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li>
            <a href="../views/employee_dashboard.php">
              <i class="nc-icon nc-paper"></i>

              <p> Tasks</p>
            </a>
          </li>
          <li>
            <a href="profile.php">
              <i class="nc-icon nc-single-02 profile-icon"></i>
              <p>Profile</p>
            </a>
          </li>
          <li>
            <a href="../auth/logout-logic.php">
              <i class="nc-icon nc-button-power"></i>

              <p>Log Out</p>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="main-panel" style="height: 100vh;">
      <!-- Navbar -->
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
            <a class="navbar-brand">DASHBOARD</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <form>
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <div class="input-group-append">
                  <div class="input-group-text">
                    <i class="nc-icon nc-zoom-split"></i>
                  </div>
                </div>
              </div>
            </form>
            <!--Notification part -->
            <ul class="navbar-nav">
              <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="nc-icon nc-bell-55"></i>
                  <p>
                    <span class="d-lg-none d-md-block">Some Actions</span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item" href="#">Action</a>
                  <a class="dropdown-item" href="#">Another action</a>
                  <a class="dropdown-item" href="#">Something else here</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="content">
        <div class="row">
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-single-02 text-warning"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Users</p>
                      <p class="card-title"><?= $userCount ?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-money-coins text-success"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Tasks</p>
                      <p class="card-title"><?= $tasksCount ?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-satisfied text-danger"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">Finished</p>
                      <p class="card-title"><?= $doneTasksCount ?></p>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 col-sm-6">
            <div class="card card-stats">
              <div class="card-body ">
                <div class="row">
                  <div class="col-5 col-md-4">
                    <div class="icon-big text-center icon-warning">
                      <i class="nc-icon nc-bullet-list-67 text-primary"></i>
                    </div>
                  </div>
                  <div class="col-7 col-md-8">
                    <div class="numbers">
                      <p class="card-category">In-Progress Tasks</p>
                      <p class="card-title"><?= $inProgressTasksCount ?></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <style>
          .table tr,
          td {
            padding: 0px;
          }

          .table-wrapper {
            max-height: 380px;
            overflow-y: auto;
          }
        </style>
        <div class="table-wrapper">
          <table class="table" style="background-color:#e3e1e1;">
            <thead>
              <tr>
                <th scope="col">User ID</th>
                <th scope="col">Name</th>
                <th scope="col">Surname</th>
                <th scope="col">Email</th>
                <th scope="col">Role</th>
                <th scope="col">Created At</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($users as $user) : ?>
                <tr>
                  <td><?= $user['id'] ?></td>
                  <td><?= $user['name'] ?></td>
                  <td><?= $user['surname'] ?></td>
                  <td><?= $user['email'] ?></td>
                  <td><?= $user['role'] ?></td>
                  <td><?= $user['created_at'] ?></td>
                  <td>
                    <a href="#" data-toggle="modal" data-target="#editUserModal<?= $user['id'] ?>"><i class="fas fa-edit"></i></a>
                    <a href="#" data-bs-toggle="modal" onclick="deleteUser(<?php echo $user['id']; ?>)"><i class="fas fa-trash-alt"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <?php foreach ($users as $user) : ?>
          <div class="modal fade" id="editUserModal<?= $user['id'] ?>" tabindex="-1" aria-labelledby="editUserModalLabel<?= $user['id'] ?>" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="editUserModalLabel<?= $user['id'] ?>">Edit User</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="../users/update_users.php" method="post">
                    <input type="hidden" name="userId" value="<?= $user['id'] ?>">
                    <div class="mb-3">
                      <label for="editFirstName<?= $user['id'] ?>" class="form-label">First Name:</label>
                      <input type="text" class="form-control" id="editFirstName<?= $user['id'] ?>" name="editFirstName" value="<?= $user['name'] ?>" required>
                    </div>
                    <div class="mb-3">
                      <label for="editLastName<?= $user['id'] ?>" class="form-label">Last Name:</label>
                      <input type="text" class="form-control" id="editLastName<?= $user['id'] ?>" name="editLastName" value="<?= $user['surname'] ?>" required>
                    </div>
                    <div class="mb-3">
                      <label for="editEmail<?= $user['id'] ?>" class="form-label">Email:</label>
                      <input type="email" class="form-control" id="editEmail<?= $user['id'] ?>" name="editEmail" value="<?= $user['email'] ?>" required>
                    </div>
                    <div class="mb-3">
                      <label for="editRole<?= $user['id'] ?>" class="form-label">Role:</label>
                      <select class="form-select" id="editRole<?= $user['id'] ?>" name="editRole" required>
                        <option value="manager" <?= $user['role'] === 'Manager' ? 'selected' : '' ?>>Manager</option>
                        <option value="employee" <?= $user['role'] === 'employee' ? 'selected' : '' ?>>Employee</option>
                      </select>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>



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
    </div>
    <script>
      function deleteUser(userId) {
        var confirmation = confirm("Are you sure you want to delete this user?");
        if (confirmation) {
          // If user confirms, send an AJAX request to delete the user
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "delete_user.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
              // Handle the response here if needed
              // For example, you can reload the page or remove the deleted user row from the table
              window.location.reload(); // Reload the page
            }
          };
          xhr.send("id=" + userId); // Send the user ID to the PHP script
        }
      }
    </script>






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
</body>

</html>