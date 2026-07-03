<?php
session_start();

$loggedIn = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Complaint Management System</title>

<link rel="stylesheet" href="assets/style.css">
<link rel="stylesheet" href="assets/responsive.css">

</head>

<body>

<header>

<div class="logo">
<h2>Complaint Management System</h2>
</div>

<nav>

<ul>

<li><a href="index.php">Home</a></li>

<li><a href="#features">Features</a></li>

<li><a href="#about">About</a></li>

<?php if($loggedIn){ ?>

<li>
<a href="user/dashboard.php" class="btn">Dashboard</a>
</li>

<li>
<a href="logout.php" class="btn">Logout</a>
</li>

<?php } else { ?>

<li>
<a href="login.php" class="btn">Login</a>
</li>

<li>
<a href="register.php" class="btn">Register</a>
</li>

<?php } ?>

</ul>

</nav>

</header>

<section class="hero">

<div class="hero-left">

<h1>Complaint <span>Management System</span></h1>

<p>
Register complaints online, upload supporting documents,
track complaint status and receive updates from the administrator.
</p>

<?php if($loggedIn){ ?>

<a href="user/dashboard.php" class="hero-btn">
Go to Dashboard
</a>

<?php } else { ?>

<a href="register.php" class="hero-btn">
Get Started
</a>

<?php } ?>

</div>

<div class="hero-right">

<img src="images/image.jpg" alt="Complaint Management">

</div>

</section>

<section id="features">

<h2>Features</h2>

<div class="feature-container">

<div class="card">
<h3>👤 User Registration</h3>
<p>Create your account securely.</p>
</div>

<div class="card">
<h3>📝 Complaint Submission</h3>
<p>Submit complaints with images or PDF.</p>
</div>

<div class="card">
<h3>📊 Track Status</h3>
<p>Monitor complaint progress anytime.</p>
</div>

<div class="card">
<h3>🛡 Admin Dashboard</h3>
<p>Manage complaints efficiently.</p>
</div>

</div>

</section>

<section id="about">

<h2 class="about-title">About Complaint Management System</h2>

<p class="about-description">
    <strong>Complaint Management System</strong> is a web-based application developed using
    <strong>HTML, CSS, PHP, and MySQL</strong>. It provides a secure and user-friendly platform
    for users to register complaints, upload supporting documents, track complaint status,
    and receive timely updates from the administrator. Administrators can efficiently manage
    complaints, users, reports, activity logs, and system settings through a centralized dashboard,
    ensuring transparency, faster issue resolution, and improved communication.
</p>

<div class="about-container">

<div class="about-card">

<h3>🎯 Key Features</h3>

<ul class="about-list">

<li>✔ User Registration & Secure Login</li>
<li>✔ Submit Complaints Online</li>
<li>✔ Upload Images & PDF Files</li>
<li>✔ Track Complaint Status</li>
<li>✔ View Complaint History</li>

</ul>

</div>

<div class="about-card">

<h3>🛡 Admin Features</h3>

<ul class="about-list">

<li>✔ Manage Complaints</li>
<li>✔ Manage Users</li>
<li>✔ Update Complaint Status</li>
<li>✔ Generate Reports</li>
<li>✔ View Activity Logs</li>

</ul>

</div>

<div class="about-card">

<h3>💻 Technologies Used</h3>

<ul class="about-list">

<li>✔ HTML5</li>
<li>✔ CSS3</li>
<li>✔ PHP</li>
<li>✔ MySQL</li>
<li>✔ XAMPP</li>

</ul>

</div>

</div>

</section>

<footer>

<p>

© <?php echo date("Y"); ?>

Complaint Management System

</p>

</footer>

</body>
</html>