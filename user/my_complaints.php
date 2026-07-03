<?php
session_start();
require_once "../db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['full_name'];   // <-- Add this line

$sql = "SELECT * FROM complaints WHERE user_id=? ORDER BY created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute([$user_id]);

$complaints = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Complaints</title>

<link rel="stylesheet" href="../assets/dashboard.css">
<link rel="stylesheet" href="../assets/complaint.css">
<link rel="stylesheet" href="../assets/responsive.css">

</head>
<body>

<!-- Header -->

<div class="header">

    <h2>Complaint Management System</h2>

   <div class="profile">
    Welcome, <?php echo htmlspecialchars($username); ?>
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

        <h2 class="page-title">My Complaints</h2>

        <!-- Search -->

        <form action="" method="GET" class="filter-box">

            <input
                type="text"
                name="search"
                placeholder="Search Complaint">

            <select name="status">

                <option value="">All Status</option>
                <option>Pending</option>
                <option>In Progress</option>
                <option>Resolved</option>
                <option>Rejected</option>

            </select>

            <button type="submit">
                Search
            </button>

        </form>

        <!-- Complaint Table -->

        <div class="table-container">

<table>

<tr>

<th>ID</th>
<th>Title</th>
<th>Category</th>
<th>Priority</th>
<th>Status</th>
<th>Date</th>
<th>Attachment</th>
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

<td><?php echo htmlspecialchars($row['title']); ?></td>

<td><?php echo htmlspecialchars($row['category']); ?></td>

<td>

<?php

if($row['priority']=="High")
{

echo "<span class='priority-high'>High</span>";

}
elseif($row['priority']=="Medium")
{

echo "<span class='priority-medium'>Medium</span>";

}
else
{

echo "<span class='priority-low'>Low</span>";

}

?>

</td>

<td>

<?php

if($row['status']=="Pending")
{

echo "<span class='status-pending'>Pending</span>";

}
elseif($row['status']=="In Progress")
{

echo "<span class='status-progress'>In Progress</span>";

}
elseif($row['status']=="Resolved")
{

echo "<span class='status-resolved'>Resolved</span>";

}
else
{

echo "<span class='status-rejected'>Rejected</span>";

}

?>

</td>

<td>

<?php echo date("d-m-Y",strtotime($row['created_at'])); ?>

</td>

<td>

<?php

if($row['attachment']!="")
{

?>

<a href="../uploads/<?php echo $row['attachment']; ?>" target="_blank">

View

</a>

<?php

}
else
{

echo "-";

}

?>

</td>

<td>

<a href="complaint_details.php?id=<?php echo $row['id']; ?>" class="btn btn-view">

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

<td colspan="8" style="text-align:center;">

No Complaints Found

</td>

</tr>

<?php

}

?>

</table>

</div>

    </div>

</div>

</body>
</html>