<?php
session_start();
require_once "../db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['full_name'];
$user_id = $_SESSION['user_id'];

// Total Complaints
$stmt = $conn->prepare("SELECT COUNT(*) FROM complaints WHERE user_id=?");
$stmt->execute([$user_id]);
$total = $stmt->fetchColumn();

// Pending
$stmt = $conn->prepare("SELECT COUNT(*) FROM complaints WHERE user_id=? AND status='Pending'");
$stmt->execute([$user_id]);
$pending = $stmt->fetchColumn();

// In Progress
$stmt = $conn->prepare("SELECT COUNT(*) FROM complaints WHERE user_id=? AND status='In Progress'");
$stmt->execute([$user_id]);
$progress = $stmt->fetchColumn();

// Resolved
$stmt = $conn->prepare("SELECT COUNT(*) FROM complaints WHERE user_id=? AND status='Resolved'");
$stmt->execute([$user_id]);
$resolved = $stmt->fetchColumn();

// Recent Complaints
$stmt = $conn->prepare("SELECT * FROM complaints WHERE user_id=? ORDER BY created_at DESC LIMIT 5");
$stmt->execute([$user_id]);
$complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>User Dashboard</title>

<link rel="stylesheet" href="../assets/dashboard.css">
<link rel="stylesheet" href="../assets/responsive.css">

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

        <li><a href="profile.php">👤 Profile</a></li>

        <li><a href="change_password.php">🔒 Change Password</a></li>

        <li><a href="../logout.php">🚪 Logout</a></li>

    </ul>

</div>

<!-- Main Content -->

<div class="main-content">

    <h2>User Dashboard</h2>

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

   <table class="dashboard-table">

<thead>

<tr>

<th>ID</th>
<th>Complaint</th>
<th>Category</th>
<th>Status</th>
<th>Priority</th>
<th>Date</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php if(count($complaints)>0){ ?>

<?php foreach($complaints as $row){ ?>

<tr>

<td align="center">

<?php echo $row['id']; ?>

</td>

<td class="title-cell">

<div class="title">

<?php echo htmlspecialchars($row['title']); ?>

</div>

<div class="desc">

<?php

$text = htmlspecialchars($row['description']);

if(strlen($text)>40){

echo substr($text,0,40)." ...";

}else{

echo $text;

}

?>

</div>

</td>

<td align="center">

<span class="badge category">

<?php echo $row['category']; ?>

</span>

</td>

<td align="center">

<?php

switch($row['status']){

case "Pending":

echo "<span class='badge pending'>Pending</span>";

break;

case "In Progress":

echo "<span class='badge progress'>In Progress</span>";

break;

case "Resolved":

echo "<span class='badge resolved'>Resolved</span>";

break;

default:

echo "<span class='badge rejected'>Rejected</span>";

}

?>

</td>

<td align="center">

<?php

switch($row['priority']){

case "High":

echo "<span class='badge high'>High</span>";

break;

case "Medium":

echo "<span class='badge medium'>Medium</span>";

break;

default:

echo "<span class='badge low'>Low</span>";

}

?>

</td>

<td align="center">

<?php echo date("d-m-Y",strtotime($row['created_at'])); ?>

</td>

<td align="center">

<a href="complaint_details.php?id=<?php echo $row['id']; ?>" class="view-btn">

👁 View

</a>

</td>

</tr>

<?php } ?>

<?php } else { ?>

<tr>

<td colspan="7" style="text-align:center;padding:30px;">

No Complaints Found

</td>

</tr>

<?php } ?>

</tbody>

</table>

    </div>

</div>

</body>
</html>