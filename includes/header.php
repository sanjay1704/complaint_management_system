<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Complaint Management System</title>

    <!-- Main CSS -->

    <link rel="stylesheet" href="../assets/style.css">

    <!-- Dashboard CSS -->

    <link rel="stylesheet" href="../assets/dashboard.css">

    <!-- Complaint CSS -->

    <link rel="stylesheet" href="../assets/complaint.css">

    <!-- Admin CSS -->

    <link rel="stylesheet" href="../assets/admin.css">

    <!-- Responsive CSS -->

    <link rel="stylesheet" href="../assets/responsive.css">

</head>

<body>

<header class="header">

    <div class="logo">

        <h2>Complaint Management System</h2>

    </div>

    <div class="profile">

        <?php
        if(isset($_SESSION['full_name'])){
            echo "Welcome, <strong>" . $_SESSION['full_name'] . "</strong>";
        }else{
            echo "Welcome, Guest";
        }
        ?>

    </div>

</header>