<?php
session_start();
require_once "../db_connect.php";

/*
// Uncomment after login implementation
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
*/

$admin = "Administrator";

$sql = "SELECT
            complaint_logs.id,
            complaint_logs.complaint_id,
            complaint_logs.status,
            complaint_logs.remarks,
            complaint_logs.created_at,
            users.full_name,
            users.role,
            complaints.title
        FROM complaint_logs
        LEFT JOIN users
            ON complaint_logs.updated_by = users.id
        LEFT JOIN complaints
            ON complaint_logs.complaint_id = complaints.id
        ORDER BY complaint_logs.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();

$logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Activity Logs</title>

<link rel="stylesheet" href="../assets/admin.css">
<link rel="stylesheet" href="../assets/responsive.css">

</head>

<body>

<div class="admin-header">

<h2>Complaint Management System</h2>

<div class="admin-name">

Welcome, <?php echo $admin; ?>

</div>

</div>

<div class="sidebar">

<ul>
<li><a href="../index.php">🏠 Home</a></li>
<li><a href="dashboard.php">🏠 Dashboard</a></li>

<li><a href="complaints.php">📋 Manage Complaints</a></li>

<li><a href="users.php">👥 Manage Users</a></li>

<li><a href="reports.php">📊 Reports</a></li>

<li class="active">
<a href="activity_logs.php">📝 Activity Logs</a>
</li>

<li><a href="settings.php">⚙ Settings</a></li>

<li><a href="../logout.php">🚪 Logout</a></li>

</ul>

</div>

<div class="main-content">

<h2>Activity Logs</h2>

<br>

<div class="table-container">

<table>

<tr>

<th>Log ID</th>
<th>Updated By</th>
<th>Role</th>
<th>Complaint</th>
<th>Status</th>
<th>Remarks</th>
<th>Date & Time</th>

</tr>

<?php

if(count($logs)>0)
{

foreach($logs as $row)
{

?>

<tr>

<td>

<?php echo $row['id']; ?>

</td>

<td>

<?php
echo !empty($row['full_name'])
? htmlspecialchars($row['full_name'])
: "Administrator";
?>

</td>

<td>

<?php
echo !empty($row['role'])
? ucfirst($row['role'])
: "Admin";
?>

</td>

<td>

<?php
echo !empty($row['title'])
? htmlspecialchars($row['title'])
: "Complaint #".$row['complaint_id'];
?>

</td>

<td>

<?php

if($row['status']=="Pending")
{
    echo "<span class='status pending'>Pending</span>";
}
elseif($row['status']=="In Progress")
{
    echo "<span class='status progress'>In Progress</span>";
}
elseif($row['status']=="Resolved")
{
    echo "<span class='status resolved'>Resolved</span>";
}
elseif($row['status']=="Rejected")
{
    echo "<span class='status rejected'>Rejected</span>";
}
else
{
    echo htmlspecialchars($row['status']);
}

?>

</td>

<td>

<?php echo htmlspecialchars($row['remarks']); ?>

</td>

<td>

<?php echo date("d-m-Y h:i A", strtotime($row['created_at'])); ?>

</td>

</tr>

<?php

}

}
else
{

?>

<tr>

<td colspan="7" style="text-align:center;">

No Activity Found

</td>

</tr>

<?php

}

?>

</table>

</div>

</div>

</body>

</html>