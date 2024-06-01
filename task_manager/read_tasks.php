<?php
require ('../config/config.php');

$sql = "SELECT * FROM tasks";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (count($result) > 0) {
    echo "<table border='1'>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Status</th>
        <th>Priority</th>
        <th>Deadline</th>
        <th>Created At</th>
        <th>Updated At</th>
        <th>Assigned To</th>
        <th>Client ID</th>
        <th>Project ID</th>
        <th>Actions</th>
    </tr>";
    foreach ($result as $row) {
        echo "<tr>
        <td>" . $row["id"] . "</td>
        <td>" . $row["title"] . "</td>
        <td>" . $row["description"] . "</td>
        <td>" . $row["status"] . "</td>
        <td>" . $row["priority"] . "</td>
        <td>" . $row["deadline"] . "</td>
        <td>" . $row["created_at"] . "</td>
        <td>" . $row["updated_at"] . "</td>
        <td>" . $row["assigned_to"] . "</td>
        <td>" . $row["client_id"] . "</td>
        <td>" . $row["project_id"] . "</td>
        <td>
            <a href='update_task.php?id=" . $row["id"] . "'>Edit</a>
            <a href='delete_task.php?id=" . $row["id"] . "'>Delete</a>
        </td>
    </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
?>
