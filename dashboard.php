<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">

        <span class="navbar-brand">
            User Management System
        </span>

        <span class="text-white">
            Welcome,
            <strong><?php echo $_SESSION['full_name']; ?></strong>
        </span>

    </div>
</nav>

<div class="container mt-4">

    <div class="card">

        <div class="card-header">
            Dashboard
        </div>

        <div class="card-body">

            <h5>Role :
                <span class="badge bg-primary">
                    <?php echo $_SESSION['role']; ?>
                </span>
            </h5>

            <hr>

            <div class="list-group">

                <a href="dashboard.php" class="list-group-item list-group-item-action">
                    Dashboard
                </a>

                <a href="profile/profile.php" class="list-group-item list-group-item-action">
                    My Profile
                </a>

                <?php if($_SESSION['role']=="Admin"){ ?>

                    <a href="users/view_users.php" class="list-group-item list-group-item-action">
                        View Users
                    </a>

                    <a href="users/add_user.php" class="list-group-item list-group-item-action">
                        Add User
                    </a>

                <?php } ?>

                <a href="auth/logout.php" class="list-group-item list-group-item-action text-danger">
                    Logout
                </a>

            </div>

        </div>

    </div>

</div>

</body>
</html>