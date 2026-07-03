<?php
session_start();
require_once "db_connect.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST["fullname"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $password = trim($_POST["password"] ?? "");
    $confirm_password = trim($_POST["confirm_password"] ?? "");

    // Validation
    if (
        empty($fullname) ||
        empty($email) ||
        empty($phone) ||
        empty($password) ||
        empty($confirm_password)
    ) {

        $message = "Please fill all fields.";

    } elseif (!preg_match("/^[a-zA-Z ]+$/", $fullname)) {

        $message = "Full name should contain only letters.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $message = "Invalid email address.";

    } elseif (!preg_match("/^[6-9][0-9]{9}$/", $phone)) {

        $message = "Enter a valid 10-digit mobile number.";

    } elseif (strlen($password) < 6) {

        $message = "Password must contain at least 6 characters.";

    } elseif ($password != $confirm_password) {

        $message = "Passwords do not match.";

    } else {

        // Check email already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->execute([$email]);

        if ($check->rowCount() > 0) {

            $message = "Email already exists.";

        } else {

            $stmt = $conn->prepare("INSERT INTO users(full_name,email,phone,password,role,status)
                                    VALUES(?,?,?,?,?,?)");

            if ($stmt->execute([
                $fullname,
                $email,
                $phone,
                $password,
                "user",
                "Active"
            ])) {

                echo "<script>
                        alert('Registration Successful');
                        window.location='login.php';
                      </script>";
                exit();

            } else {

                $message = "Registration Failed.";

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

<title>Register - Complaint Management System</title>

<link rel="stylesheet" href="assets/register.css">
<link rel="stylesheet" href="assets/responsive.css">

</head>

<body>

<div class="register-wrapper">

<div class="register-overlay">

<div class="register-box">

<h2>Complaint Management System</h2>

<h3>Create Account</h3>

<?php
if($message!="")
{
    echo "<div style='background:#f8d7da;color:#842029;padding:12px;border-radius:6px;margin-bottom:15px;text-align:center;'>
    $message
    </div>";
}
?>

<form method="POST">

<div class="input-group">

<label>Full Name</label>

<input
type="text"
name="fullname"
placeholder="Enter Full Name"
pattern="[A-Za-z ]+"
title="Only letters are allowed"
value="<?php if(isset($fullname)) echo htmlspecialchars($fullname); ?>"
required>

</div>

<div class="input-group">

<label>Email Address</label>

<input
type="email"
name="email"
placeholder="Enter Email Address"
value="<?php if(isset($email)) echo htmlspecialchars($email); ?>"
required>

</div>

<div class="input-group">

<label>Phone Number</label>

<input
type="tel"
name="phone"
placeholder="Enter Phone Number"
pattern="[6-9]{1}[0-9]{9}"
maxlength="10"
title="Enter valid 10 digit mobile number"
value="<?php if(isset($phone)) echo htmlspecialchars($phone); ?>"
required>

</div>

<div class="input-group">

<label>Password</label>

<input
type="password"
name="password"
placeholder="Enter Password"
minlength="6"
required>

</div>

<div class="input-group">

<label>Confirm Password</label>

<input
type="password"
name="confirm_password"
placeholder="Confirm Password"
minlength="6"
required>

</div>

<button
type="submit"
class="btn-register">

Register

</button>

</form>

<p class="login-link">

Already have an account?

<a href="login.php">
Login Here
</a>

</p>

<p style="text-align:center;margin-top:15px;">

<a href="index.php">

← Back to Home

</a>

</p>

</div>

</div>

</div>

</body>

</html>