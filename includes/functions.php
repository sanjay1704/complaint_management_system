<?php

/*
|--------------------------------------------------------------------------
| Sanitize Input
|--------------------------------------------------------------------------
*/

function cleanInput($data)
{
    return htmlspecialchars(trim($data));
}

/*
|--------------------------------------------------------------------------
| Generate Password Hash
|--------------------------------------------------------------------------
*/

function hashPassword($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

/*
|--------------------------------------------------------------------------
| Verify Password
|--------------------------------------------------------------------------
*/

function verifyPassword($password, $hash)
{
    return password_verify($password, $hash);
}

/*
|--------------------------------------------------------------------------
| Display Success Message
|--------------------------------------------------------------------------
*/

function successMessage($message)
{
    return "<div class='alert-success'>$message</div>";
}

/*
|--------------------------------------------------------------------------
| Display Error Message
|--------------------------------------------------------------------------
*/

function errorMessage($message)
{
    return "<div class='alert-error'>$message</div>";
}

/*
|--------------------------------------------------------------------------
| Upload File
|--------------------------------------------------------------------------
*/

function uploadFile($file)
{
    $targetDir = "../assets/uploads/";

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

    $fileName = time() . "_" . basename($file["name"]);

    $targetFile = $targetDir . $fileName;

    $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    $allowedTypes = ["jpg", "jpeg", "png", "pdf"];

    if (!in_array($fileType, $allowedTypes)) {
        return false;
    }

    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        return $fileName;
    }

    return false;
}

/*
|--------------------------------------------------------------------------
| Complaint Status Badge
|--------------------------------------------------------------------------
*/

function statusBadge($status)
{
    switch ($status) {

        case "Pending":
            return "<span class='status pending'>Pending</span>";

        case "In Progress":
            return "<span class='status progress'>In Progress</span>";

        case "Resolved":
            return "<span class='status resolved'>Resolved</span>";

        case "Rejected":
            return "<span class='status rejected'>Rejected</span>";

        default:
            return $status;
    }
}

/*
|--------------------------------------------------------------------------
| Priority Badge
|--------------------------------------------------------------------------
*/

function priorityBadge($priority)
{
    switch ($priority) {

        case "High":
            return "<span class='priority high'>High</span>";

        case "Medium":
            return "<span class='priority medium'>Medium</span>";

        case "Low":
            return "<span class='priority low'>Low</span>";

        default:
            return $priority;
    }
}

/*
|--------------------------------------------------------------------------
| Format Date
|--------------------------------------------------------------------------
*/

function formatDate($date)
{
    return date("d-m-Y", strtotime($date));
}

/*
|--------------------------------------------------------------------------
| Redirect
|--------------------------------------------------------------------------
*/

function redirect($url)
{
    header("Location: $url");
    exit();
}

/*
|--------------------------------------------------------------------------
| Generate Complaint Number
|--------------------------------------------------------------------------
*/

function complaintNumber($id)
{
    return "CMP-" . str_pad($id, 5, "0", STR_PAD_LEFT);
}

?>