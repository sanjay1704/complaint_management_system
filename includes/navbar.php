<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<nav class="navbar">

    <div class="nav-logo">
        <a href="../index.php">
            Complaint Management System
        </a>
    </div>

    <ul class="nav-menu">

        <li>
            <a href="../index.php">Home</a>
        </li>

        <?php if(isset($_SESSION['role']) && $_SESSION['role'] == "admin"){ ?>

            <li>
                <a href="../admin/dashboard.php">Dashboard</a>
            </li>

            <li>
                <a href="../admin/complaints.php">Complaints</a>
            </li>

            <li>
                <a href="../admin/users.php">Users</a>
            </li>

            <li>
                <a href="../admin/reports.php">Reports</a>
            </li>

            <li>
                <a href="../admin/settings.php">Settings</a>
            </li>

        <?php } elseif(isset($_SESSION['role']) && $_SESSION['role'] == "user"){ ?>

            <li>
                <a href="../user/dashboard.php">Dashboard</a>
            </li>

            <li>
                <a href="../user/create_complaint.php">New Complaint</a>
            </li>

            <li>
                <a href="../user/my_complaints.php">My Complaints</a>
            </li>

            <li>
                <a href="../user/profile.php">Profile</a>
            </li>

        <?php } ?>

    </ul>

    <div class="nav-right">

        <?php if(isset($_SESSION['full_name'])){ ?>

            <span class="welcome-text">
                Welcome,
                <strong><?php echo $_SESSION['full_name']; ?></strong>
            </span>

            <a href="../logout.php" class="logout-btn">
                Logout
            </a>

        <?php } else { ?>

            <a href="../login.php" class="login-btn">
                Login
            </a>

            <a href="../register.php" class="register-btn">
                Register
            </a>

        <?php } ?>

    </div>

</nav>