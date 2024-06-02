<?php 
require '../config/config.php';
session_start();
include('../dashboards/employee.php');
include('../config/config.php');
include('includes/header.php');
include('../task_manager/reports.php');


$sql = "SELECT * FROM users WHERE role='employee'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$employees = $stmt->fetchAll();

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
    <?php include('includes/sidebar.php'); ?>
        <div class="main-panel" style="height: 100vh;">
            <?php include('includes/navbar.php'); ?>
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
                            <div class="mb-3">
                                <label for="employeeFilter">Filter by Employee:</label>
                                <select class="form-select" id="employeeFilter">
                                    <!-- PHP code to populate options -->
                                    <?php foreach ($employees as $employee) : ?>
                                        <option value="<?php echo $employee['id']; ?>"><?php echo $employee['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
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
