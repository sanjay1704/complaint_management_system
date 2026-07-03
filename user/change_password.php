<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['full_name'];
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

<div class="password-card">

<h2 class="password-title">
Change Password
</h2>

<form action="" method="POST">

<div class="form-group">

<label>Current Password</label>

<input
type="password"
name="current_password"
placeholder="Enter current password"
required>

</div>

<div class="form-group">

<label>New Password</label>

<input
type="password"
name="new_password"
placeholder="Enter new password"
required>

</div>

<div class="form-group">

<label>Confirm New Password</label>

<input
type="password"
name="confirm_password"
placeholder="Confirm new password"
required>

</div>

<button
type="submit"
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
</html>