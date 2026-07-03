<?php
session_start();
require_once "db_connect.php";

$message = "";

// Already Logged In
if (isset($_SESSION['user_id'])) {

    if ($_SESSION['role'] == "admin") {
        header("Location: admin/dashboard.php");
    } else {
        header("Location: user/dashboard.php");
    }
    exit();
}

// Login
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {

        $message = "Please fill all fields.";

    } else {

        // Find user by email
        $stmt = $conn->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
        $stmt->execute([$email]);

        if ($stmt->rowCount() == 1) {

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Plain Text Password
            if ($password == $user['password']) {

                $_SESSION['user_id']   = $user['id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['email']     = $user['email'];
                $_SESSION['role']      = $user['role'];

                if ($user['role'] == "admin") {

                    header("Location: admin/dashboard.php");

                } else {

                    header("Location: user/dashboard.php");

                }

                exit();

            } else {

                $message = "Invalid Password.";

            }

        } else {

            $message = "Email not found.";

        }

    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Login - Complaint Management System</title>

<link rel="stylesheet" href="assets/login.css">
<link rel="stylesheet" href="assets/responsive.css">

</head>
<body>

<div class="login-wrapper">

    <div class="login-overlay">

        <div class="login-box">

            <h2>Complaint Management System</h2>

            <h3>User Login</h3>

            <?php
            if($message!="")
            {
                echo "<p style='color:red;text-align:center;margin-bottom:15px;'>$message</p>";
            }
            ?>

            <form method="POST">

                <div class="input-group">

                    <label>Email Address</label>

                    <input
                    type="email"
                    name="email"
                    placeholder="Enter Email Address"
                    required>

                </div>

                <div class="input-group">

                    <label>Password</label>

                    <input
                    type="password"
                    name="password"
                    placeholder="Enter Password"
                    required>

                </div>

                <button
                type="submit"
                class="btn-login">

                Login

                </button>

            </form>

            <p class="register-link">

                Don't have an account?

                <a href="register.php">
                Register Here
                </a>

            </p>

            <div class="back-home">

                <a href="index.php" class="btn-home">

                ← Back to Home

                </a>

            </div>

        </div>

    </div>

</div>

</body>

</html>