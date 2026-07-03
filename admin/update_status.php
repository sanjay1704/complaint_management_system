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

if(isset($_POST['update']))
{
    $status = $_POST['status'];
    $remarks = trim($_POST['remarks']);

    // Update complaint
    $sql = "UPDATE complaints
            SET status=?, admin_remarks=?
            WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$status, $remarks, $id]);

    // Save activity log
    $log = $conn->prepare("
        INSERT INTO complaint_logs
        (complaint_id, status, remarks, updated_by)
        VALUES (?, ?, ?, ?)
    ");

    $log->execute([
        $id,
        $status,
        $remarks,
        $_SESSION['user_id']
    ]);

    header("Location: complaint_details.php?id=".$id);
    exit();
}

$sql = "SELECT complaints.*, users.full_name
        FROM complaints
        INNER JOIN users
        ON complaints.user_id = users.id
        WHERE complaints.id=?";

$stmt = $conn->prepare($sql);
$stmt->execute([$id]);

$row = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$row)
{
    die("Complaint Not Found");
}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Update Complaint Status</title>

<link rel="stylesheet" href="../assets/admin.css">
<link rel="stylesheet" href="../assets/responsive.css">

<style>

.update-box{
    width:700px;
    background:#fff;
    padding:30px;
    margin:auto;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,.15);
}

.form-group{
    margin-bottom:20px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:bold;
}

.form-group input,
.form-group textarea,
.form-group select{

    width:100%;
    padding:12px;
    border:1px solid #ccc;
    border-radius:5px;
    font-size:15px;

}

.form-group textarea{

    resize:none;
    height:130px;

}

.btn-save{

    background:#0d6efd;
    color:#fff;
    padding:12px 25px;
    border:none;
    border-radius:5px;
    cursor:pointer;
    font-size:16px;

}

.btn-save:hover{

    background:#0b5ed7;

}

.btn-back{

    display:inline-block;
    margin-left:10px;
    background:#6c757d;
    color:white;
    text-decoration:none;
    padding:12px 25px;
    border-radius:5px;

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

<li class="active"><a href="complaints.php">📋 Manage Complaints</a></li>

<li><a href="users.php">👥 Manage Users</a></li>

<li><a href="reports.php">📊 Reports</a></li>

<li><a href="activity_logs.php">📝 Activity Logs</a></li>

<li><a href="settings.php">⚙ Settings</a></li>

<li><a href="../logout.php">🚪 Logout</a></li>

</ul>

</div>

<div class="main-content">

<h2>Update Complaint Status</h2>

<br>

<div class="update-box">

<form method="POST">

<div class="form-group">

<label>Complaint ID</label>

<input
type="text"
value="<?php echo $row['id']; ?>"
readonly>

</div>

<div class="form-group">

<label>User Name</label>

<input
type="text"
value="<?php echo htmlspecialchars($row['full_name']); ?>"
readonly>

</div>

<div class="form-group">

<label>Complaint Title</label>

<input
type="text"
value="<?php echo htmlspecialchars($row['title']); ?>"
readonly>

</div>

<div class="form-group">

<label>Current Status</label>

<select name="status">

<option value="Pending"
<?php if($row['status']=="Pending") echo "selected"; ?>>
Pending
</option>

<option value="In Progress"
<?php if($row['status']=="In Progress") echo "selected"; ?>>
In Progress
</option>

<option value="Resolved"
<?php if($row['status']=="Resolved") echo "selected"; ?>>
Resolved
</option>

<option value="Rejected"
<?php if($row['status']=="Rejected") echo "selected"; ?>>
Rejected
</option>

</select>

</div>

<div class="form-group">

<label>Admin Remarks</label>

<<textarea
name="remarks"><?php echo htmlspecialchars($row['admin_remarks']); ?></textarea>

</div>

<button
type="submit"
name="update"
class="btn-save">

Update Complaint

</button>

<a
href="complaints.php"
class="btn-back">

Back

</a>

</form>

</div>

</div>

</body>

</html>