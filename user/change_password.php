<?php
session_start();
require_once "../db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['full_name'];
$user_id = $_SESSION['user_id'];

$message = "";
$msgColor = "red";

if(isset($_POST['change_password']))
{
    $current_password = trim($_POST['current_password']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if(empty($current_password) || empty($new_password) || empty($confirm_password))
    {
        $message = "Please fill all fields.";
    }
    else
    {
        $stmt = $conn->prepare("SELECT password FROM users WHERE id=?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if(!$user)
        {
            $message = "User not found.";
        }
        elseif($current_password != $user['password'])
        {
            $message = "Current password is incorrect.";
        }
        elseif($new_password != $confirm_password)
        {
            $message = "New Password and Confirm Password do not match.";
        }
        elseif(strlen($new_password) < 6)
        {
            $message = "Password must be at least 6 characters.";
        }
        else
        {
            $update = $conn->prepare("UPDATE users SET password=? WHERE id=?");

            if($update->execute([$new_password,$user_id]))
            {
                $message = "Password Changed Successfully.";
                $msgColor = "green";
            }
            else
            {
                $message = "Failed to Change Password.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Change Password</title>

<link rel="stylesheet" href="../assets/dashboard.css">
<link rel="stylesheet" href="../assets/responsive.css">

<style>

.password-card{
    max-width:700px;
    background:#fff;
    margin:auto;
    padding:30px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

.password-title{
    color:#0d6efd;
    margin-bottom:25px;
}

.form-group{
    margin-bottom:20px;
}

.form-group label{
    display:block;
    margin-bottom:8px;
    font-weight:bold;
}

.form-group input{
    width:100%;
    padding:12px;
    border:1px solid #ccc;
    border-radius:5px;
    outline:none;
}

.form-group input:focus{
    border-color:#0d6efd;
}

.btn-change{
    background:#0d6efd;
    color:#fff;
    border:none;
    padding:12px 25px;
    border-radius:5px;
    cursor:pointer;
}

.btn-change:hover{
    background:#0b5ed7;
}

.btn-cancel{
    background:#dc3545;
    color:#fff;
    padding:12px 25px;
    text-decoration:none;
    border-radius:5px;
    margin-left:10px;
}

.btn-cancel:hover{
    background:#bb2d3b;
}

.message{
    padding:12px;
    margin-bottom:20px;
    border-radius:5px;
    text-align:center;
    font-weight:bold;
}

</style>

</head>

<body>

<div class="header">

<h2>Complaint Management System</h2>

<div class="profile">
Welcome, <?php echo htmlspecialchars($username); ?>
</div>

</div>

<div class="sidebar">

<ul>

<li><a href="../index.php">🏠 Home</a></li>

<li><a href="dashboard.php">📊 Dashboard</a></li>

<li><a href="create_complaint.php">➕ New Complaint</a></li>

<li><a href="my_complaints.php">📋 My Complaints</a></li>

<li><a href="profile.php">👤 My Profile</a></li>

<li><a href="change_password.php">🔒 Change Password</a></li>

<li><a href="../logout.php">🚪 Logout</a></li>

</ul>

</div>

<div class="main-content">

<div class="password-card">

<h2 class="password-title">Change Password</h2>

<?php
if($message!="")
{
?>
<div class="message"
style="background:<?php echo ($msgColor=="green") ? "#d1e7dd" : "#f8d7da"; ?>;
color:<?php echo ($msgColor=="green") ? "#0f5132" : "#842029"; ?>;">

<?php echo $message; ?>

</div>
<?php
}
?>

<form method="POST">

<div class="form-group">

<label>Current Password</label>

<input
type="password"
name="current_password"
placeholder="Enter Current Password"
required>

</div>

<div class="form-group">

<label>New Password</label>

<input
type="password"
name="new_password"
placeholder="Enter New Password"
required>

</div>

<div class="form-group">

<label>Confirm Password</label>

<input
type="password"
name="confirm_password"
placeholder="Confirm New Password"
required>

</div>

<button
type="submit"
name="change_password"
class="btn-change">

Change Password

</button>

<a
href="dashboard.php"
class="btn-cancel">

Cancel

</a>

</form>

</div>

</div>

</body>

</html>git status