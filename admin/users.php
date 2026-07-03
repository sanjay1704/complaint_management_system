<?php
session_start();
require_once "../db_connect.php";

/*
// Enable after admin login
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
*/

// Update user status
if(isset($_GET['action']) && isset($_GET['id']))
{
    $id=$_GET['id'];
    $action=$_GET['action'];

    if($action=="active")
        $status="Active";
    else
        $status="Inactive";

    $stmt=$conn->prepare("UPDATE users SET status=? WHERE id=?");
    $stmt->execute([$status,$id]);

    header("Location: users.php");
    exit();
}

// Fetch users
$stmt=$conn->query("SELECT * FROM users ORDER BY created_at DESC");
$users=$stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Manage Users</title>

<link rel="stylesheet" href="../assets/admin.css">
<link rel="stylesheet" href="../assets/responsive.css">

<style>

.table-container{
    background:#fff;
    padding:20px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:#0d6efd;
    color:#fff;
    padding:14px;
}

td{
    padding:14px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

tr:hover{
    background:#f8f9fa;
}

.role{
    padding:5px 12px;
    border-radius:20px;
    color:#fff;
    font-size:13px;
}

.admin{
    background:#dc3545;
}

.user{
    background:#198754;
}

.status{
    padding:5px 12px;
    border-radius:20px;
    color:#fff;
}

.active{
    background:#198754;
}

.inactive{
    background:#dc3545;
}

.btn{
    padding:8px 15px;
    border-radius:5px;
    text-decoration:none;
    color:#fff;
}

.enable{
    background:#198754;
}

.disable{
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

<li><a href="complaints.php">📋 Manage Complaints</a></li>

<li class="active"><a href="users.php">👥 Manage Users</a></li>

<li><a href="reports.php">📊 Reports</a></li>

<li><a href="activity_logs.php">📝 Activity Logs</a></li>

<li><a href="settings.php">⚙ Settings</a></li>

<li><a href="../logout.php">🚪 Logout</a></li>

</ul>

</div>

<div class="main-content">

<h2>Manage Users</h2>

<br>

<div class="table-container">

<table>

<tr>

<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Role</th>
<th>Status</th>
<th>Registered</th>
<th>Action</th>

</tr>

<?php

if(count($users)>0)
{

foreach($users as $row)
{

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo htmlspecialchars($row['full_name']); ?></td>

<td><?php echo htmlspecialchars($row['email']); ?></td>

<td><?php echo htmlspecialchars($row['phone']); ?></td>

<td>

<?php

if($row['role']=="admin")
{
    echo "<span class='role admin'>Admin</span>";
}
else
{
    echo "<span class='role user'>User</span>";
}

?>

</td>

<td>

<?php

if($row['status']=="Active")
{
    echo "<span class='status active'>Active</span>";
}
else
{
    echo "<span class='status inactive'>Inactive</span>";
}

?>

</td>

<td>

<?php echo date("d-m-Y",strtotime($row['created_at'])); ?>

</td>

<td>

<?php

if($row['status']=="Active")
{

?>

<a
class="btn disable"
href="users.php?action=inactive&id=<?php echo $row['id']; ?>">

Deactivate

</a>

<?php

}
else
{

?>

<a
class="btn enable"
href="users.php?action=active&id=<?php echo $row['id']; ?>">

Activate

</a>

<?php

}

?>

</td>

</tr>

<?php

}

}
else
{

?>

<tr>

<td colspan="8">

No Users Found

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