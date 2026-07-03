<?php
session_start();
require_once "../db_connect.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Update Profile
if (isset($_POST['update'])) {

    $name = trim($_POST['name']);
    $phone = trim($_POST['phone']);

    $update = $conn->prepare("UPDATE users SET full_name=?, phone=? WHERE id=?");

    if ($update->execute([$name, $phone, $user_id])) {

        $_SESSION['full_name'] = $name;

        echo "<script>
                alert('Profile Updated Successfully');
                window.location='profile.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('Profile Update Failed');</script>";
    }
}

// Fetch User Details
$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$name = $user['full_name'];
$email = $user['email'];
$phone = $user['phone'];
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Profile</title>

<link rel="stylesheet" href="../assets/dashboard.css">
<link rel="stylesheet" href="../assets/responsive.css">

<style>

.profile-container{
    max-width:700px;
    background:#fff;
    margin:auto;
    padding:30px;
    border-radius:10px;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

.profile-title{
    margin-bottom:25px;
    color:#0d6efd;
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
}

.btn-update{
    background:#0d6efd;
    color:#fff;
    border:none;
    padding:12px 20px;
    border-radius:5px;
    cursor:pointer;
    border-radius:5px;
}

.btn-update:hover{
    background:#0b5ed7;
}

</style>

</head>

<body>

<div class="header">

<h2>Complaint Management System</h2>

<div class="profile">

Welcome,
<?php echo htmlspecialchars($_SESSION['full_name']); ?>

</div>

</div>

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

<div class="main-content">

<div class="profile-container">

<h2 class="profile-title">
My Profile
</h2>

<form method="POST">

<div class="form-group">

<label>Full Name</label>

<input
type="text"
name="name"
value="<?php echo htmlspecialchars($name); ?>"
required>

</div>

<div class="form-group">

<label>Email Address</label>

<input
type="email"
value="<?php echo htmlspecialchars($email); ?>"
readonly>

</div>

<div class="form-group">

<label>Phone Number</label>

<input
type="text"
name="phone"
value="<?php echo htmlspecialchars($phone); ?>"
required>

</div>

<button
type="submit"
name="update"
class="btn-update">

Update Profile

</button>

</form>

</div>

</div>

</body>
</html>