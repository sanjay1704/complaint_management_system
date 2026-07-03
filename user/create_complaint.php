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

if(isset($_POST['title']))
{
    $title = $_POST['title'];
    $category = $_POST['category'];
    $priority = $_POST['priority'];
    $description = $_POST['description'];

    $attachment = "";

    if(isset($_FILES['attachment']) && $_FILES['attachment']['name']!="")
    {
        $folder = "../uploads/";

        if(!is_dir($folder))
        {
            mkdir($folder,0777,true);
        }

        $attachment = time()."_".$_FILES['attachment']['name'];

        move_uploaded_file(
            $_FILES['attachment']['tmp_name'],
            $folder.$attachment
        );
    }

    $sql = "INSERT INTO complaints
    (user_id,title,category,priority,description,attachment,status)
    VALUES
    (?,?,?,?,?,?,?)";

    $stmt = $conn->prepare($sql);

    if($stmt->execute([
        $user_id,
        $title,
        $category,
        $priority,
        $description,
        $attachment,
        "Pending"
    ]))
    {
        $message = "Complaint Submitted Successfully.";
    }
    else
    {
        $message = "Failed to Submit Complaint.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Create Complaint</title>

<link rel="stylesheet" href="../assets/dashboard.css">
<link rel="stylesheet" href="../assets/complaint.css">
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

        <li><a href="profile.php">👤 My Profile</a></li>

        <li><a href="change_password.php">🔒 Change Password</a></li>

        <li><a href="../logout.php">🚪 Logout</a></li>

    </ul>

</div>

<!-- Main Content -->

<div class="main-content">

<div class="container">

<h2 class="page-title">Create New Complaint</h2>

<form action="" method="POST" enctype="multipart/form-data" class="complaint-form">

<div class="form-group">
<label>Complaint Title</label>
<input type="text" name="title" placeholder="Enter complaint title" required>
</div>

<div class="form-group">
<label>Category</label>

<select name="category" required>

<option value="">Select Category</option>

<option>Network</option>

<option>Electrical</option>

<option>Maintenance</option>

<option>Water Supply</option>

<option>Cleaning</option>

<option>Hostel</option>

<option>Transport</option>

<option>Other</option>

</select>

</div>

<div class="form-group">
<label>Priority</label>

<select name="priority" required>

<option value="">Select Priority</option>

<option>Low</option>

<option>Medium</option>

<option>High</option>

</select>

</div>

<div class="form-group">
<label>Description</label>

<textarea
name="description"
placeholder="Describe your complaint..."
required></textarea>

</div>

<div class="form-group">
<label>Upload Image / PDF</label>

<input
type="file"
name="attachment"
accept=".jpg,.jpeg,.png,.pdf">

</div>

<button
type="submit"
class="btn-submit">
Submit Complaint
</button>

</form>

</div>

</div>

</body>
</html>