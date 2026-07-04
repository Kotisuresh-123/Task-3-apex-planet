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

$message = "";

if (isset($_POST['add_user'])) {

    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $password = trim($_POST['password']);
    $role_id = $_POST['role_id'];

    if (empty($full_name) || empty($username) || empty($email) || empty($mobile) || empty($password)) {

        $message = "<div class='alert alert-danger'>All fields are required.</div>";

    } else {

        $check = mysqli_prepare($conn, "SELECT id FROM users WHERE username=? OR email=?");
        mysqli_stmt_bind_param($check, "ss", $username, $email);
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);

        if (mysqli_stmt_num_rows($check) > 0) {

            $message = "<div class='alert alert-danger'>Username or Email already exists.</div>";

        } else {

            $password = password_hash($password, PASSWORD_DEFAULT);

            $insert = mysqli_prepare($conn, "INSERT INTO users(full_name,username,email,mobile,password,role_id)
            VALUES(?,?,?,?,?,?)");

            mysqli_stmt_bind_param($insert, "sssssi",
                $full_name,
                $username,
                $email,
                $mobile,
                $password,
                $role_id
            );

            if (mysqli_stmt_execute($insert)) {

                header("Location: view_users.php");
                exit();

            } else {

                $message = "<div class='alert alert-danger'>Failed to add user.</div>";

            }

        }

    }

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Add User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card">

<div class="card-header">
<h3>Add User</h3>
</div>

<div class="card-body">

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">
<label>Full Name</label>
<input type="text" name="full_name" class="form-control" required>
</div>

<div class="mb-3">
<label>Username</label>
<input type="text" name="username" class="form-control" required>
</div>

<div class="mb-3">
<label>Email</label>
<input type="email" name="email" class="form-control" required>
</div>

<div class="mb-3">
<label>Mobile</label>
<input type="text" name="mobile" class="form-control" required>
</div>

<div class="mb-3">
<label>Password</label>
<input type="password" name="password" class="form-control" required>
</div>

<div class="mb-3">
<label>Role</label>

<select name="role_id" class="form-control">

<option value="2">User</option>

<option value="1">Admin</option>

</select>

</div>

<button type="submit" name="add_user" class="btn btn-success">
Save User
</button>

<a href="view_users.php" class="btn btn-secondary">
Cancel
</a>

</form>

</div>

</div>

</div>

</body>

</html>