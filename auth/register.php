<?php
include("../config/database.php");

$message = "";

if (isset($_POST['register'])) {

    $full_name = trim($_POST['full_name']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $password = trim($_POST['password']);

    // Basic Validation
    if (empty($full_name) || empty($username) || empty($email) || empty($mobile) || empty($password)) {
        $message = "<div class='alert alert-danger'>All fields are required.</div>";
    } else {

        // Check Username
        $check = mysqli_prepare($conn, "SELECT id FROM users WHERE username=? OR email=?");
        mysqli_stmt_bind_param($check, "ss", $username, $email);
        mysqli_stmt_execute($check);
        mysqli_stmt_store_result($check);

        if (mysqli_stmt_num_rows($check) > 0) {

            $message = "<div class='alert alert-danger'>Username or Email already exists.</div>";

        } else {

            // First Registered User becomes Admin
            $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM users");
            $row = mysqli_fetch_assoc($result);

            if ($row['total'] == 0) {
                $role_id = 1; // Admin
            } else {
                $role_id = 2; // User
            }

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $insert = mysqli_prepare($conn, "INSERT INTO users(full_name, username, email, mobile, password, role_id)
                    VALUES(?,?,?,?,?,?)");

            mysqli_stmt_bind_param(
                $insert,
                "sssssi",
                $full_name,
                $username,
                $email,
                $mobile,
                $hashedPassword,
                $role_id
            );

        if (mysqli_stmt_execute($insert)) {

    $message = "
    <div class='alert alert-success'>
        Registration completed successfully.
        <a href='login.php'>Click here to Login</a>
    </div>";

} else {

    $message = "
    <div class='alert alert-danger'>
        Registration Failed.
    </div>";

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
    <title>Register</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-header text-center">
                    <h3>User Registration</h3>
                </div>

                <div class="card-body">
<?php
if(!empty($message)){
    echo $message;
}
?>
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

                        <button type="submit" name="register" class="btn btn-primary w-100">
                            Register
                        </button>

                    </form>

                    <div class="text-center mt-3">
                        Already have an account?
                        <a href="login.php">Login</a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

</body>
</html>