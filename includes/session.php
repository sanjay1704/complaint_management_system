<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| User Login Check
|--------------------------------------------------------------------------
*/

function checkUserLogin()
{
    if (
        !isset($_SESSION['user_id']) ||
        $_SESSION['role'] != 'user'
    ) {

        header("Location: ../login.php");
        exit();

    }
}

/*
|--------------------------------------------------------------------------
| Admin Login Check
|--------------------------------------------------------------------------
*/

function checkAdminLogin()
{
    if (
        !isset($_SESSION['user_id']) ||
        $_SESSION['role'] != 'admin'
    ) {

        header("Location: ../login.php");
        exit();

    }
}

/*
|--------------------------------------------------------------------------
| Guest Check
|--------------------------------------------------------------------------
*/

function checkGuest()
{
    if (isset($_SESSION['user_id'])) {

        if ($_SESSION['role'] == "admin") {

            header("Location: admin/dashboard.php");

        } else {

            header("Location: user/dashboard.php");

        }

        exit();

    }
}

/*
|--------------------------------------------------------------------------
| Get Logged-in User
|--------------------------------------------------------------------------
*/

function getUserName()
{
    return isset($_SESSION['full_name'])
        ? $_SESSION['full_name']
        : "Guest";
}

/*
|--------------------------------------------------------------------------
| Get Logged-in User ID
|--------------------------------------------------------------------------
*/

function getUserId()
{
    return isset($_SESSION['user_id'])
        ? $_SESSION['user_id']
        : 0;
}

/*
|--------------------------------------------------------------------------
| Get User Role
|--------------------------------------------------------------------------
*/

function getUserRole()
{
    return isset($_SESSION['role'])
        ? $_SESSION['role']
        : "";
}

?>