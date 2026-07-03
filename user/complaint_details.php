<?php
session_start();
require_once "../db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['full_name'];
$user_id = $_SESSION['user_id'];

if (!isset($_GET['id'])) {
    header("Location: my_complaints.php");
    exit();
}

$id = $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM complaints WHERE id=? AND user_id=?");
$stmt->execute([$id,$user_id]);

if($stmt->rowCount()==0){
    die("Complaint not found.");
}

$row = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Complaint Details</title>

<link rel="stylesheet" href="../assets/dashboard.css">
<link rel="stylesheet" href="../assets/complaint.css">
<link rel="stylesheet" href="../assets/responsive.css">

<style>

.details-card{
    background:#fff;
    padding:30px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.details-table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

.details-table td{
    padding:15px;
    border:1px solid #ddd;
}

.details-table td:first-child{
    width:220px;
    font-weight:bold;
    background:#f8f9fa;
}

.section-title{
    margin:30px 0 15px;
    color:#0d6efd;
}

.timeline{
    margin-top:15px;
}

.timeline-item{
    background:#f8f9fa;
    border-left:5px solid #0d6efd;
    padding:15px;
    margin-bottom:15px;
    border-radius:5px;
}

.back-btn{
    display:inline-block;
    margin-top:25px;
    padding:10px 20px;
    background:#0d6efd;
    color:#fff;
    text-decoration:none;
    border-radius:5px;
}

.back-btn:hover{
    background:#0b5ed7;
}

</style>

</head>

<body>

<!-- Header -->

<div class="header">

<h2>Complaint Management System</h2>

<div class="profile">
Welcome, <?php echo $username; ?>
</div>

</div>

<!-- Sidebar -->

<div class="sidebar">

<ul>
    <li><a href="../index.php">🏠 Home</a></li>

<li><a href="dashboard.php">🏠 Dashboard</a></li>

<li><a href="create_complaint.php">➕ New Complaint</a></li>

<li><a href="my_complaints.php">📋 My Complaints</a></li>

<li><a href="profile.php">👤 My Profile</a></li>

<li><a href="change_password.php">🔒 Change Password</a></li>

<li><a href="../logout.php">🚪 Logout</a></li>

</ul>

</div>

<!-- Main Content -->

<div class="main-content">

<div class="container">

<h2 class="page-title">
Complaint Details
</h2>

<div class="details-card">

<table class="details-table">

<tr>
<td>Complaint ID</td>
<td><?php echo $row['id']; ?></td>
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
<td><?php echo htmlspecialchars($row['priority']); ?></td>
</tr>

<tr>
<td>Status</td>
<td><?php echo htmlspecialchars($row['status']); ?></td>
</tr>

<tr>
<td>Description</td>
<td><?php echo nl2br(htmlspecialchars($row['description'])); ?></td>
</tr>

<tr>
<td>Attachment</td>
<td>

<?php

if($row['attachment']!="")
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
<td>Admin Remarks</td>
<td>

<?php

if($row['admin_remarks']!="")
{

echo htmlspecialchars($row['admin_remarks']);

}
else
{

echo "No Remarks";

}

?>

</td>
</tr>

<tr>
<td>Created Date</td>
<td><?php echo date("d-m-Y H:i",strtotime($row['created_at'])); ?></td>
</tr>

<tr>
<td>Last Updated</td>
<td><?php echo date("d-m-Y H:i",strtotime($row['updated_at'])); ?></td>
</tr>

</table>

<h3 class="section-title">
Admin Remarks
</h3>

<div class="timeline">

<div class="timeline-item">

<strong>03-07-2026</strong>

<p>
Complaint has been assigned to the Network Team.
</p>

</div>

<div class="timeline-item">

<strong>04-07-2026</strong>

<p>
Issue is under investigation.
</p>

</div>

</div>

<h3 class="section-title">
Status History
</h3>

<div class="timeline">

<div class="timeline-item">

<strong>Pending</strong>

<p>
Complaint submitted successfully.
</p>

</div>

<div class="timeline-item">

<strong>In Progress</strong>

<p>
Complaint assigned to administrator.
</p>

</div>

</div>

<a href="my_complaints.php" class="back-btn">
← Back to My Complaints
</a>

</div>

</div>

</div>

</body>
</html>