<?php
session_start();
include("../config/database.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

if ($_SESSION['role'] != "Admin") {
    die("Access Denied");
}

if (!isset($_GET['id'])) {
    header("Location: view_users.php");
    exit();
}

$id = $_GET['id'];

// Check user exists
$check = mysqli_prepare($conn, "SELECT role_id FROM users WHERE id=?");
mysqli_stmt_bind_param($check, "i", $id);
mysqli_stmt_execute($check);

$result = mysqli_stmt_get_result($check);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("User not found.");
}

// Don't allow deleting another Admin
if ($user['role_id'] == 1) {
    die("You cannot delete another Admin.");
}

// Delete user
$delete = mysqli_prepare($conn, "DELETE FROM users WHERE id=?");
mysqli_stmt_bind_param($delete, "i", $id);

if (mysqli_stmt_execute($delete)) {

    header("Location: view_users.php");
    exit();

} else {

    echo "Failed to delete user.";

}
?>