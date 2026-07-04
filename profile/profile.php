<?php
session_start();
include("../config/database.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$id = $_SESSION['user_id'];

$stmt = mysqli_prepare($conn, "SELECT users.*, roles.role_name
FROM users
JOIN roles ON users.role_id = roles.id
WHERE users.id=?");

mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

include("../includes/header.php");
?>

<div class="container-fluid">

    <div class="card">

        <div class="card-header bg-primary text-white">
            <h4>My Profile</h4>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-4 text-center">

                    <?php
                    if (!empty($user['profile_picture']) && file_exists("../uploads/" . $user['profile_picture'])) {
                    ?>

                        <img src="../uploads/<?php echo $user['profile_picture']; ?>"
                             class="img-fluid rounded-circle border"
                             width="180"
                             height="180">

                    <?php
                    } else {
                    ?>

                        <img src="../assets/images/default.png"
                             class="img-fluid rounded-circle border"
                             width="180"
                             height="180">

                    <?php
                    }
                    ?>

                </div>

                <div class="col-md-8">

                    <table class="table table-bordered">

                        <tr>
                            <th width="30%">Full Name</th>
                            <td><?php echo $user['full_name']; ?></td>
                        </tr>

                        <tr>
                            <th>Username</th>
                            <td><?php echo $user['username']; ?></td>
                        </tr>

                        <tr>
                            <th>Email</th>
                            <td><?php echo $user['email']; ?></td>
                        </tr>

                        <tr>
                            <th>Mobile</th>
                            <td><?php echo $user['mobile']; ?></td>
                        </tr>

                        <tr>
                            <th>Role</th>
                            <td>
                                <span class="badge bg-success">
                                    <?php echo $user['role_name']; ?>
                                </span>
                            </td>
                        </tr>

                    </table>

                    <a href="./edit_profile.php" class="btn btn-primary">
                        Edit Profile
                    </a>

                    <a href="../dashboard.php" class="btn btn-secondary">
                        Back
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?php
include("../includes/footer.php");
?>