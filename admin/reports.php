<?php
session_start();
require_once "../db_connect.php";

/*
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
*/

$admin = "Administrator";

// Dashboard Cards
$total = $conn->query("SELECT COUNT(*) FROM complaints")->fetchColumn();

$resolved = $conn->query("SELECT COUNT(*) FROM complaints WHERE status='Resolved'")->fetchColumn();

$pending = $conn->query("SELECT COUNT(*) FROM complaints WHERE status='Pending'")->fetchColumn();

$rejected = $conn->query("SELECT COUNT(*) FROM complaints WHERE status='Rejected'")->fetchColumn();

// Monthly Report
$sql = "
SELECT
DATE_FORMAT(created_at,'%M') AS month,
COUNT(*) AS total,
SUM(status='Resolved') AS resolved,
SUM(status='Pending') AS pending,
SUM(status='Rejected') AS rejected

FROM complaints

GROUP BY MONTH(created_at), MONTHNAME(created_at)

ORDER BY MONTH(created_at)
";

$stmt = $conn->query($sql);

$reports = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Reports</title>

<link rel="stylesheet" href="../assets/admin.css">
<link rel="stylesheet" href="../assets/responsive.css">

<style>

.report-section{
    margin-top:30px;
}

.report-card-container{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(250px,1fr));
    gap:20px;
    margin-bottom:30px;
}

.report-card{
    background:#fff;
    padding:25px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
    text-align:center;
}

.report-card h3{
    color:#0d6efd;
    margin-bottom:15px;
}

.report-card h1{
    font-size:38px;
    color:#333;
}

.report-table{
    background:#fff;
    padding:20px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
    overflow-x:auto;
}

.report-table table{
    width:100%;
    border-collapse:collapse;
}

.report-table th{
    background:#0d6efd;
    color:#fff;
    padding:15px;
}

.report-table td{
    padding:15px;
    border-bottom:1px solid #ddd;
}

.report-table tr:hover{
    background:#f8f9fa;
}

.download-btn{
    display:inline-block;
    margin-top:20px;
    padding:12px 20px;
    background:#198754;
    color:#fff;
    text-decoration:none;
    border-radius:5px;
}

.download-btn:hover{
    background:#157347;
}
.report-table{
    background:#fff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 5px 20px rgba(0,0,0,.1);
}

.report-table h3{
    color:#0d6efd;
    margin-bottom:15px;
}

.report-table table{
    width:100%;
    border-collapse:collapse;
}

.report-table th{
    background:#0d6efd;
    color:#fff;
    padding:15px;
    text-align:center;
    font-size:16px;
}

.report-table td{
    padding:15px;
    text-align:center;
    border-bottom:1px solid #ddd;
}

.report-table tbody tr:nth-child(even){
    background:#f8f9fa;
}

.report-table tbody tr:hover{
    background:#eaf4ff;
}

.badge{
    display:inline-block;
    min-width:45px;
    padding:6px 14px;
    border-radius:20px;
    color:#fff;
    font-weight:bold;
}

.total{
    background:#0d6efd;
}

.resolved{
    background:#198754;
}

.pending{
    background:#ffc107;
    color:#000;
}

.rejected{
    background:#dc3545;
}

.download-btn{
    display:inline-block;
    margin-top:20px;
    padding:12px 25px;
    background:#198754;
    color:#fff;
    text-decoration:none;
    border-radius:6px;
    font-weight:bold;
    transition:.3s;
}

.download-btn:hover{
    background:#157347;
}

</style>

</head>

<body>

<!-- Header -->

<div class="admin-header">

<h2>Complaint Management System</h2>

<div class="admin-name">
Welcome, <?php echo $admin; ?>
</div>

</div>

<!-- Sidebar -->

<div class="sidebar">

<ul>
<li><a href="../index.php">🏠 Home</a></li>
<li><a href="dashboard.php">🏠 Dashboard</a></li>

<li><a href="complaints.php">📋 Manage Complaints</a></li>

<li><a href="users.php">👥 Manage Users</a></li>

<li class="active"><a href="reports.php">📊 Reports</a></li>

<li><a href="activity_logs.php">📝 Activity Logs</a></li>

<li><a href="settings.php">⚙ Settings</a></li>

<li><a href="../logout.php">🚪 Logout</a></li>

</ul>

</div>

<!-- Main Content -->

<div class="main-content">

<h2>Reports</h2>

<div class="report-section">

<div class="report-card-container">

<div class="report-card">
<h3>Total Complaints</h3>
<h1><?php echo $total; ?></h1>
</div>

<div class="report-card">
<h3>Resolved</h3>
<h1><?php echo $resolved; ?></h1>
</div>

<div class="report-card">
<h3>Pending</h3>
<h1><?php echo $pending; ?></h1>
</div>

<div class="report-card">
<h3>Rejected</h3>
<h1><?php echo $rejected; ?></h1>
</div>

</div>

<div class="report-table">

<h3>📅 Monthly Complaint Report</h3>

<br>

<table>

<thead>

<tr>

<th>Month</th>
<th>Total</th>
<th>Resolved</th>
<th>Pending</th>
<th>Rejected</th>

</tr>

</thead>

<tbody>

<?php

if(count($reports)>0)
{

foreach($reports as $row)
{

?>

<tr>

<td><strong><?php echo $row['month']; ?></strong></td>

<td>
<span class="badge total">
<?php echo $row['total']; ?>
</span>
</td>

<td>
<span class="badge resolved">
<?php echo $row['resolved']; ?>
</span>
</td>

<td>
<span class="badge pending">
<?php echo $row['pending']; ?>
</span>
</td>

<td>
<span class="badge rejected">
<?php echo $row['rejected']; ?>
</span>
</td>

</tr>

<?php

}

}
else
{

?>

<tr>

<td colspan="5" style="text-align:center;padding:20px;">

No Report Available

</td>

</tr>

<?php

}

?>

</tbody>

</table>

<a href="download_report.php" class="download-btn">
📥 Download Report
</a>
</div>

</div>

</div>

</body>
</html>