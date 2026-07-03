<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<div class="sidebar">

<?php if(isset($_SESSION['role']) && $_SESSION['role']=="admin"){ ?>

    <ul>

        <li>
            <a href="../admin/dashboard.php">🏠 Dashboard</a>
        </li>

        <li>
            <a href="../admin/complaints.php">📋 Manage Complaints</a>
        </li>

        <li>
            <a href="../admin/users.php">👥 Manage Users</a>
        </li>

        <li>
            <a href="../admin/reports.php">📊 Reports</a>
        </li>

        <li>
            <a href="../admin/activity_logs.php">📝 Activity Logs</a>
        </li>

        <li>
            <a href="../admin/settings.php">⚙ Settings</a>
        </li>

        <li>
            <a href="../logout.php">🚪 Logout</a>
        </li>

    </ul>

<?php } else { ?>

    <ul>

        <li>
            <a href="../user/dashboard.php">🏠 Dashboard</a>
        </li>

        <li>
            <a href="../user/create_complaint.php">➕ New Complaint</a>
        </li>

        <li>
            <a href="../user/my_complaints.php">📋 My Complaints</a>
        </li>

        <li>
            <a href="../user/profile.php">👤 My Profile</a>
        </li>

        <li>
            <a href="../user/change_password.php">🔒 Change Password</a>
        </li>

        <li>
            <a href="../logout.php">🚪 Logout</a>
        </li>

    </ul>

<?php } ?>

</div>