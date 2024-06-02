<?php require_once('../config/config.php');
// Function to fetch completed tasks based on a given date range
function fetchCompletedTasks($conn, $startDate, $endDate) {
    $sql = "SELECT * FROM tasks WHERE status = 'Done' AND completed_at BETWEEN :startDate AND :endDate";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':startDate', $startDate);
    $stmt->bindParam(':endDate', $endDate);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Daily Report
$today = date('Y-m-d');
$tomorrow = date('Y-m-d', strtotime('+1 day'));
$dailyTasks = fetchCompletedTasks($conn, $today, $tomorrow);

// Monthly Report
$firstDayOfMonth = date('Y-m-01');
$firstDayOfNextMonth = date('Y-m-d', strtotime('first day of next month'));
$monthlyTasks = fetchCompletedTasks($conn, $firstDayOfMonth, $firstDayOfNextMonth);

// Yearly Report
$firstDayOfYear = date('Y-01-01');
$firstDayOfNextYear = date('Y-m-d', strtotime('first day of January next year'));
$yearlyTasks = fetchCompletedTasks($conn, $firstDayOfYear, $firstDayOfNextYear);
?>