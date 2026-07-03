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
$message = "";

// Save Settings
if(isset($_POST['save']))
{
    $app_name = trim($_POST['app_name']);
    $organization = trim($_POST['organization']);
    $support_email = trim($_POST['support_email']);
    $support_phone = trim($_POST['support_phone']);
    $default_status = trim($_POST['default_status']);
    $about = trim($_POST['about']);

    $sql = "UPDATE settings SET
            app_name=?,
            organization_name=?,
            support_email=?,
            support_phone=?,
            default_status=?,
            about_system=?
            WHERE id=1";

    $stmt = $conn->prepare($sql);

    if($stmt->execute([
        $app_name,
        $organization,
        $support_email,
        $support_phone,
        $default_status,
        $about
    ]))
    {
        $message = "Settings Updated Successfully.";
    }
    else
    {
        $message = "Failed to Update Settings.";
    }
}

// Load Settings
$stmt = $conn->query("SELECT * FROM settings WHERE id=1");
$settings = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Settings</title>

<link rel="stylesheet" href="../assets/admin.css">
<link rel="stylesheet" href="../assets/responsive.css">

<style>

.settings-card{
    max-width:900px;
    margin:auto;
    background:#fff;
    padding:30px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

.settings-card h2{
    color:#0d6efd;
    margin-bottom:20px;
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
    min-height:120px;
    resize:vertical;
}

.btn-save{
    background:#198754;
    color:#fff;
    border:none;
    padding:12px 25px;
    border-radius:5px;
    cursor:pointer;
}

.btn-save:hover{
    background:#157347;
}

.success{
    background:#d1e7dd;
    color:#0f5132;
    padding:10px;
    margin-bottom:20px;
    border-radius:5px;
}

</style>

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

<li><a href="activity_logs.php">📝 Activity Logs</a></li>

<li class="active"><a href="settings.php">⚙ Settings</a></li>

<li><a href="../logout.php">🚪 Logout</a></li>

</ul>

</div>

<div class="main-content">

<div class="settings-card">

<h2>System Settings</h2>

<?php
if($message!="")
{
    echo "<div class='success'>$message</div>";
}
?>
<form method="POST">

<div class="form-group">
<label>Application Name</label>
<input
type="text"
name="app_name"
placeholder="Enter Application Name"
value=""
required>
</div>

<div class="form-group">
<label>Organization Name</label>
<input
type="text"
name="organization"
placeholder="Enter Organization Name"
value=""
required>
</div>

<div class="form-group">
<label>Support Email</label>
<input
type="email"
name="support_email"
placeholder="Enter Support Email"
value=""
required>
</div>

<div class="form-group">
<label>Support Phone</label>
<input
type="text"
name="support_phone"
placeholder="Enter Support Phone"
value=""
required>
</div>

<div class="form-group">
<label>Default Complaint Status</label>

<select name="default_status" required>

<option value="" selected disabled>Select Status</option>
<option value="Pending">Pending</option>
<option value="In Progress">In Progress</option>
<option value="Resolved">Resolved</option>

</select>

</div>

<div class="form-group">
<label>About System</label>

<textarea
name="about"
placeholder="Enter About System"></textarea>

</div>

<button
type="submit"
name="save"
class="btn-save">

Save Settings

</button>

</form>
</div>

</div>

</body>
</html>