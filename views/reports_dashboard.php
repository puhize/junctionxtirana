<?php 
require '../config/config.php';
session_start();
include('../dashboards/employee.php');
include('../config/config.php');
include('includes/header.php');
include('../task_manager/reports.php');

$today = date('Y-m-d');
$tomorrow = date('Y-m-d', strtotime('+1 day'));
$dailyTasks = fetchCompletedTasks($conn, $today, $tomorrow);

$firstDayOfMonth = date('Y-m-01');
$firstDayOfNextMonth = date('Y-m-d', strtotime('first day of next month'));
$monthlyTasks = fetchCompletedTasks($conn, $firstDayOfMonth, $firstDayOfNextMonth);

// Yearly Report
$firstDayOfYear = date('Y-01-01');
$firstDayOfNextYear = date('Y-m-d', strtotime('first day of January next year'));
$yearlyTasks = fetchCompletedTasks($conn, $firstDayOfYear, $firstDayOfNextYear);
?>

?>

<body>
    <div class="wrapper">
        <div class="sidebar" data-color="white" data-active-color="danger">
            <div class="logo">
                <a class="simple-text logo-mini"></a>
                <a href="Admin.php" class="simple-text logo-normal">Manage Mate</a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="active"><a href="all_tasks.php"><i class="nc-icon nc-paper"></i><p>Dashboard</p></a></li>
                    <li class="active"><a href="manager_dashboard.php"><i class="nc-icon nc-watch-time"></i><p>Tasks</p></a></li>
                    <li class="nav-item"><a class="nav-link" href="../auth/logout-logic.php"><i class="nc-icon nc-button-power"></i><p>Logout</p></a></li>
                </ul>
            </div>
        </div>
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
                                    <p><span class="d-lg-none d-md-block">Some Actions</span></p>
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
                    <div class="container-fluid px-1 py-3">
                        <div class="card mb-4">
                            <div class="card-header">
                                <button id="dailyReportBtn" class="btn btn-primary">Daily Reports</button>
                                <button id="monthlyReportBtn" class="btn btn-secondary">Monthly Reports</button>
                                <button id="yearlyReportBtn" class="btn btn-secondary">Yearly Reports</button>
                            </div>
                            <div class="card-body">
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
                                            <th>Completed At</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reportTableBody">
                                        <?php foreach ($dailyTasks as $task) : ?>
                                            <tr>
                                                <td><?= $task['id'] ?></td>
                                                <td><?= $task['title'] ?></td>
                                                <td><?= $task['description'] ?></td>
                                                <td><?= $task['status'] ?></td>
                                                <td><?= $task['priority'] ?></td>
                                                <td><?= $task['deadline'] ?></td>
                                                <td><?= $task['assigned_to'] ?></td>
                                                <td><?= $task['completed_at'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
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
            </div>
        </div>
    </div>

    <script>
        // Update button classes and load report data
        document.getElementById('dailyReportBtn').addEventListener('click', function() {
            console.log('Daily report button clicked');
            loadReport('daily');
            setActiveButton(this);
        });

        document.getElementById('monthlyReportBtn').addEventListener('click', function() {
            console.log('Monthly report button clicked');
            loadReport('monthly');
            setActiveButton(this);
        });

        document.getElementById('yearlyReportBtn').addEventListener('click', function() {
            console.log('Yearly report button clicked');
            loadReport('yearly');
            setActiveButton(this);
        });

        function setActiveButton(button) {
            document.getElementById('dailyReportBtn').classList.remove('btn-primary');
            document.getElementById('dailyReportBtn').classList.add('btn-secondary');
            document.getElementById('monthlyReportBtn').classList.remove('btn-primary');
            document.getElementById('monthlyReportBtn').classList.add('btn-secondary');
            document.getElementById('yearlyReportBtn').classList.remove('btn-primary');
            document.getElementById('yearlyReportBtn').classList.add('btn-secondary');
            button.classList.remove('btn-secondary');
            button.classList.add('btn-primary');
        }

        function loadReport(reportType) {
            let reportData;
            switch (reportType) {
                case 'daily':
                    reportData = <?php echo json_encode($dailyTasks); ?>;
                    break;
                case 'monthly':
                    reportData = <?php echo json_encode($monthlyTasks); ?>;
                    break;
                case 'yearly':
                    reportData = <?php echo json_encode($yearlyTasks); ?>;
                    break;
                default:
                    reportData = [];
            }

            console.log('Loading report data for:', reportType, reportData);

            const reportTableBody = document.getElementById('reportTableBody');
            reportTableBody.innerHTML = '';

            if (reportData.length === 0) {
                console.log('No data available for:', reportType);
                const row = document.createElement('tr');
                row.innerHTML = '<td colspan="8" class="text-center">No data available</td>';
                reportTableBody.appendChild(row);
                return;
            }

            reportData.forEach(task => {
                console.log('Adding row for task:', task);
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${task.id}</td>
                    <td>${task.title}</td>
                    <td>${task.description}</td>
                    <td>${task.status}</td>
                    <td>${task.priority}</td>
                    <td>${task.deadline}</td>
                    <td>${task.assigned_to}</td>
                    <td>${task.completed_at}</td>
                `;
                reportTableBody.appendChild(row);
            });

            console.log('Report table updated');
        }
    </script>
</body>
