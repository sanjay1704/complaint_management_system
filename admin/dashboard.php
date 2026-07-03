<?php
session_start();
require_once "../db_connect.php";

// Uncomment after admin login
/*
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
*/

$admin = "Administrator";

// Total Complaints
$stmt = $conn->query("SELECT COUNT(*) FROM complaints");
$total = $stmt->fetchColumn();

// Pending
$stmt = $conn->query("SELECT COUNT(*) FROM complaints WHERE status='Pending'");
$pending = $stmt->fetchColumn();

// In Progress
$stmt = $conn->query("SELECT COUNT(*) FROM complaints WHERE status='In Progress'");
$progress = $stmt->fetchColumn();

// Resolved
$stmt = $conn->query("SELECT COUNT(*) FROM complaints WHERE status='Resolved'");
$resolved = $stmt->fetchColumn();

// Recent Complaints
$sql = "SELECT complaints.*, users.full_name
        FROM complaints
        INNER JOIN users
        ON complaints.user_id = users.id
        ORDER BY complaints.created_at DESC
        LIMIT 10";

$stmt = $conn->query($sql);
$complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Dashboard</title>

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

<li class="active"><a href="dashboard.php">🏠 Dashboard</a></li>

<li><a href="complaints.php">📋 Manage Complaints</a></li>

<li><a href="users.php">👥 Manage Users</a></li>

<li><a href="reports.php">📊 Reports</a></li>

<li><a href="activity_logs.php">📝 Activity Logs</a></li>

<li><a href="settings.php">⚙ Settings</a></li>

<li><a href="../logout.php">🚪 Logout</a></li>

</ul>

</div>

<div class="main-content">

<h2>Admin Dashboard</h2>

<br>

<div class="card-container">

<div class="card">
<h3>Total Complaints</h3>
<h1><?php echo $total; ?></h1>
</div>

<div class="card">
<h3>Pending</h3>
<h1><?php echo $pending; ?></h1>
</div>

<div class="card">
<h3>In Progress</h3>
<h1><?php echo $progress; ?></h1>
</div>

<div class="card">
<h3>Resolved</h3>
<h1><?php echo $resolved; ?></h1>
</div>

</div>

<div class="table-container">

<h3>Recent Complaints</h3>

<br>

<table>

<tr>

<th>ID</th>
<th>User</th>
<th>Title</th>
<th>Category</th>
<th>Priority</th>
<th>Status</th>
<th>Date</th>
<th>Action</th>

</tr>

<?php

if(count($complaints)>0)
{

foreach($complaints as $row)
{

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo htmlspecialchars($row['full_name']); ?></td>

<td><?php echo htmlspecialchars($row['title']); ?></td>

<td><?php echo htmlspecialchars($row['category']); ?></td>

<td>

<?php

if($row['priority']=="High")
echo "<span class='priority high'>High</span>";

elseif($row['priority']=="Medium")
echo "<span class='priority medium'>Medium</span>";

else
echo "<span class='priority low'>Low</span>";

?>

</td>

<td>

<?php

if($row['status']=="Pending")
echo "<span class='status pending'>Pending</span>";

elseif($row['status']=="In Progress")
echo "<span class='status progress'>In Progress</span>";

elseif($row['status']=="Resolved")
echo "<span class='status resolved'>Resolved</span>";

else
echo "<span class='status rejected'>Rejected</span>";

?>

</td>

<td>

<?php echo date("d-m-Y",strtotime($row['created_at'])); ?>

</td>

<td>

<a href="complaint_details.php?id=<?php echo $row['id']; ?>" class="btn view">

View

</a>

</td>

</tr>

<?php

}

}
else
{

?>

<tr>

<td colspan="8" align="center">

No Complaints Found

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