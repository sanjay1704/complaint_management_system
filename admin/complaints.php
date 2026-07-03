<?php
session_start();
require_once "../db_connect.php";

/*
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}
*/

$search = "";
$status = "";

$sql = "SELECT complaints.*, users.full_name
        FROM complaints
        INNER JOIN users
        ON complaints.user_id = users.id
        WHERE 1=1";

$params = [];

if(isset($_GET['search']) && $_GET['search']!="")
{
    $search = trim($_GET['search']);
    $sql .= " AND complaints.title LIKE ?";
    $params[] = "%".$search."%";
}

if(isset($_GET['status']) && $_GET['status']!="")
{
    $status = $_GET['status'];
    $sql .= " AND complaints.status=?";
    $params[] = $status;
}

$sql .= " ORDER BY complaints.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute($params);
$complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Manage Complaints</title>

<link rel="stylesheet" href="../assets/admin.css">
<link rel="stylesheet" href="../assets/responsive.css">

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

<h2>Manage Complaints</h2>

<br>

<form method="GET">

<input
type="text"
name="search"
placeholder="Search Complaint"
value="<?php echo htmlspecialchars($search); ?>">

<select name="status">

<option value="">All Status</option>

<option value="Pending" <?php if($status=="Pending") echo "selected"; ?>>
Pending
</option>

<option value="In Progress" <?php if($status=="In Progress") echo "selected"; ?>>
In Progress
</option>

<option value="Resolved" <?php if($status=="Resolved") echo "selected"; ?>>
Resolved
</option>

<option value="Rejected" <?php if($status=="Rejected") echo "selected"; ?>>
Rejected
</option>

</select>

<button type="submit">

Search

</button>

</form>

<br>

<div class="table-container">

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

<a
href="complaint_details.php?id=<?php echo $row['id']; ?>"
class="btn view">

View

</a>

<a
href="update_status.php?id=<?php echo $row['id']; ?>"
class="btn edit">

Manage

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