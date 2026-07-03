<?php
session_start();
require_once "../db_connect.php";

/*
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
*/

if(!isset($_GET['id']))
{
    header("Location: complaints.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT complaints.*, users.full_name, users.email, users.phone
        FROM complaints
        INNER JOIN users
        ON complaints.user_id = users.id
        WHERE complaints.id=?";

$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

if($stmt->rowCount()==0)
{
    die("Complaint Not Found");
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Complaint Details</title>

<link rel="stylesheet" href="../assets/admin.css">
<link rel="stylesheet" href="../assets/responsive.css">

<style>

.details-box{
    background:#fff;
    padding:25px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

.details-table{
    width:100%;
    border-collapse:collapse;
}

.details-table td{
    padding:14px;
    border:1px solid #ddd;
}

.details-table td:first-child{
    width:220px;
    font-weight:bold;
    background:#f5f5f5;
}

.back-btn{
    display:inline-block;
    margin-top:20px;
    background:#0d6efd;
    color:#fff;
    padding:10px 20px;
    text-decoration:none;
    border-radius:5px;
}

.back-btn:hover{
    background:#0b5ed7;
}

.priority{
    padding:6px 12px;
    border-radius:20px;
    color:#fff;
}

.high{
    background:#dc3545;
}

.medium{
    background:#ffc107;
    color:#000;
}

.low{
    background:#198754;
}

.status{
    padding:6px 12px;
    border-radius:20px;
    color:#fff;
}

.pending{
    background:#fd7e14;
}

.progress{
    background:#0dcaf0;
}

.resolved{
    background:#198754;
}

.rejected{
    background:#dc3545;
}

</style>

</head>

<body>

<div class="admin-header">

<h2>Complaint Management System</h2>

<div class="admin-name">
Administrator
</div>

</div>

<div class="sidebar">

<ul>
<li><a href="../index.php">🏠 Home</a></li>
<li><a href="dashboard.php">🏠 Dashboard</a></li>

<li class="active">
<a href="complaints.php">📋 Manage Complaints</a>
</li>

<li><a href="users.php">👥 Manage Users</a></li>

<li><a href="reports.php">📊 Reports</a></li>

<li><a href="activity_logs.php">📝 Activity Logs</a></li>

<li><a href="settings.php">⚙ Settings</a></li>

<li><a href="../logout.php">🚪 Logout</a></li>

</ul>

</div>

<div class="main-content">

<h2>Complaint Details</h2>

<br>

<div class="details-box">

<table class="details-table">

<tr>
<td>Complaint ID</td>
<td><?php echo $row['id']; ?></td>
</tr>

<tr>
<td>User Name</td>
<td><?php echo htmlspecialchars($row['full_name']); ?></td>
</tr>

<tr>
<td>Email</td>
<td><?php echo htmlspecialchars($row['email']); ?></td>
</tr>

<tr>
<td>Phone</td>
<td><?php echo htmlspecialchars($row['phone']); ?></td>
</tr>

<tr>
<td>Complaint Title</td>
<td><?php echo htmlspecialchars($row['title']); ?></td>
</tr>

<tr>
<td>Category</td>
<td><?php echo htmlspecialchars($row['category']); ?></td>
</tr>

<tr>
<td>Priority</td>
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
</tr>

<tr>
<td>Status</td>
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
</tr>

<tr>
<td>Description</td>
<td><?php echo nl2br(htmlspecialchars($row['description'])); ?></td>
</tr>

<tr>
<td>Attachment</td>
<td>

<?php

if(!empty($row['attachment']))
{

?>

<a href="../uploads/<?php echo $row['attachment']; ?>" target="_blank">

View Attachment

</a>

<?php

}
else
{

echo "No Attachment";

}

?>

</td>
</tr>

<tr>
<td>Created Date</td>
<td><?php echo date("d-m-Y h:i A",strtotime($row['created_at'])); ?></td>
</tr>

</table>

<a href="update_status.php?id=<?php echo $row['id']; ?>" class="back-btn">

Update Status

</a>

<a href="complaints.php" class="back-btn">

Back

</a>

</div>

</div>

</body>

</html>