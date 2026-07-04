<?php
session_start();
include("../config/database.php");

$message = "";

if (isset($_POST['login'])) {

    $login_input = trim($_POST['login_input']);
    $password = trim($_POST['password']);

    $sql = "SELECT users.*, roles.role_name
            FROM users
            JOIN roles ON users.role_id = roles.id
            WHERE username=? OR email=?";

    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ss",
        $login_input,
        $login_input
    );

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {

        if (password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role_name'];

            header("Location: ../dashboard.php");
            exit();

        } else {

            $message = "<div class='alert alert-danger'>
                            Invalid Password.
                        </div>";
        }

    } else {

        $message = "<div class='alert alert-danger'>
                        User not found.
                    </div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-header text-center">
                    <h3>Login</h3>
                </div>

                <div class="card-body">

                    <?php echo $message; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label>Email or Username</label>
                            <input type="text" name="login_input" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <button type="submit" name="login" class="btn btn-primary w-100">
                            Login
                        </button>

                    </form>

                    <div class="text-center mt-3">
                        Don't have an account?
                        <a href="register.php">Register</a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>

</html>