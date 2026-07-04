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

// Get user details
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("User not found.");
}

// Don't allow editing another admin
if ($user['role_id'] == 1) {
    die("You cannot edit another Admin.");
}

$message = "";

if (isset($_POST['update_user'])) {

    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $role_id = $_POST['role_id'];

    $check = mysqli_prepare($conn,
        "SELECT id FROM users
         WHERE (username=? OR email=?)
         AND id!=?");

    mysqli_stmt_bind_param(
        $check,
        "ssi",
        $username,
        $email,
        $id
    );

    mysqli_stmt_execute($check);
    mysqli_stmt_store_result($check);

    if (mysqli_stmt_num_rows($check) > 0) {

        $message = "<div class='alert alert-danger'>
        Username or Email already exists.
        </div>";

    } else {

        $update = mysqli_prepare($conn,
        "UPDATE users
        SET full_name=?,
            username=?,
            email=?,
            mobile=?,
            role_id=?
        WHERE id=?");

        mysqli_stmt_bind_param(
            $update,
            "ssssii",
            $full_name,
            $username,
            $email,
            $mobile,
            $role_id,
            $id
        );

        if (mysqli_stmt_execute($update)) {

            header("Location: view_users.php");
            exit();

        } else {

            $message = "<div class='alert alert-danger'>
            Update failed.
            </div>";

        }

    }

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Edit User</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card">

<div class="card-header">
<h3>Edit User</h3>
</div>

<div class="card-body">

<?php echo $message; ?>

<form method="POST">

<div class="mb-3">
<label>Full Name</label>
<input
type="text"
name="full_name"
class="form-control"
value="<?php echo $user['full_name']; ?>"
required>
</div>

<div class="mb-3">
<label>Username</label>
<input
type="text"
name="username"
class="form-control"
value="<?php echo $user['username']; ?>"
required>
</div>

<div class="mb-3">
<label>Email</label>
<input
type="email"
name="email"
class="form-control"
value="<?php echo $user['email']; ?>"
required>
</div>

<div class="mb-3">
<label>Mobile</label>
<input
type="text"
name="mobile"
class="form-control"
value="<?php echo $user['mobile']; ?>"
required>
</div>

<div class="mb-3">
<label>Role</label>

<select name="role_id" class="form-control">

<option value="2"
<?php if($user['role_id']==2) echo "selected"; ?>>
User
</option>

<option value="1"
<?php if($user['role_id']==1) echo "selected"; ?>>
Admin
</option>

</select>

</div>

<button
type="submit"
name="update_user"
class="btn btn-primary">
Update
</button>

<a
href="view_users.php"
class="btn btn-secondary">
Cancel
</a>

</form>

</div>

</div>

</div>

</body>

</html>