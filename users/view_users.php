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

$sql = "SELECT users.*, roles.role_name
        FROM users
        JOIN roles
        ON users.role_id = roles.id
        ORDER BY users.id ASC";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<title>View Users</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<h3>User List</h3>

<a href="../dashboard.php" class="btn btn-secondary mb-3">
Back
</a>

<table class="table table-bordered table-striped">

<thead class="table-dark">

<tr>

<th>ID</th>
<th>Name</th>
<th>Username</th>
<th>Email</th>
<th>Mobile</th>
<th>Role</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($row=mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo $row['full_name']; ?></td>

<td><?php echo $row['username']; ?></td>

<td><?php echo $row['email']; ?></td>

<td><?php echo $row['mobile']; ?></td>

<td><?php echo $row['role_name']; ?></td>

<td>

<?php
if($row['role_name']=="Admin"){
?>

<button class="btn btn-warning btn-sm" disabled>Edit</button>

<button class="btn btn-danger btn-sm" disabled>Delete</button>

<?php
}else{
?>

<a href="edit_user.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">
Edit
</a>

<a href="delete_user.php?id=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Are you sure you want to delete this user?');">
Delete
</a>

<?php
}
?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</body>

</html>