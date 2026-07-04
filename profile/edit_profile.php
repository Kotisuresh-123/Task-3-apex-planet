<?php
session_start();
include("../config/database.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$id = $_SESSION['user_id'];
$message = "";

/* Fetch user details */
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);

/* Update Profile */
if (isset($_POST['update_profile'])) {

    $full_name = trim($_POST['full_name']);
    $username  = trim($_POST['username']);
    $email     = trim($_POST['email']);
    $mobile    = trim($_POST['mobile']);

    /* Keep old profile picture by default */
    $profile_picture = $user['profile_picture'];

    /* Check duplicate username or email */
    $check = mysqli_prepare(
        $conn,
        "SELECT id FROM users
         WHERE (username=? OR email=?)
         AND id!=?"
    );

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

        $message = "
        <div class='alert alert-danger'>
            Username or Email already exists.
        </div>";

    } else {

       /* Upload new profile picture */
$profile_picture = $user['profile_picture'];

echo "<pre>";
print_r($_FILES);
echo "</pre>";

if (isset($_FILES['profile_picture'])) {

    echo "File input detected.<br>";

    if ($_FILES['profile_picture']['error'] == 0) {

        echo "No upload error.<br>";

        $allowed = ['jpg', 'jpeg', 'png'];

        $extension = strtolower(
            pathinfo(
                $_FILES['profile_picture']['name'],
                PATHINFO_EXTENSION
            )
        );

        echo "Extension: " . $extension . "<br>";

        if (in_array($extension, $allowed)) {

            echo "Extension allowed.<br>";

            $new_file_name =
                time() . "_" .
                basename($_FILES['profile_picture']['name']);

            $upload_path = "../uploads/" . $new_file_name;

            echo "Upload Path: " . $upload_path . "<br>";

            if (!is_dir("../uploads")) {
                echo "ERROR: uploads folder does not exist.<br>";
            }

            if (!is_writable("../uploads")) {
                echo "ERROR: uploads folder is not writable.<br>";
            }

            if (
                move_uploaded_file(
                    $_FILES['profile_picture']['tmp_name'],
                    $upload_path
                )
            ) {

                echo "File uploaded successfully.<br>";

                $profile_picture = $new_file_name;

                echo "Filename to save in DB: "
                     . $profile_picture . "<br>";

            } else {

                echo "move_uploaded_file() failed.<br>";

            }

        } else {

            echo "Invalid file type.<br>";

        }

    } else {

        echo "Upload error code: "
             . $_FILES['profile_picture']['error']
             . "<br>";
    }

} else {

    echo "profile_picture input not found.<br>";
}

echo "Final value stored in database will be: ";
var_dump($profile_picture);
        /* Update user details */
        $update = mysqli_prepare(
            $conn,
            "UPDATE users
             SET full_name=?,
                 username=?,
                 email=?,
                 mobile=?,
                 profile_picture=?
             WHERE id=?"
        );

        mysqli_stmt_bind_param(
            $update,
            "sssssi",
            $full_name,
            $username,
            $email,
            $mobile,
            $profile_picture,
            $id
        );

        if (mysqli_stmt_execute($update)) {

            $_SESSION['full_name'] = $full_name;

            header("Location: profile.php");
            exit();

        } else {

            $message = "
            <div class='alert alert-danger'>
                Update failed.
            </div>";
        }
    }
}

include("../includes/header.php");
?>

<div class="card">

    <div class="card-header bg-primary text-white">
        <h4>Edit Profile</h4>
    </div>

    <div class="card-body">

        <?php echo $message; ?>

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label>Full Name</label>
                <input type="text"
                       name="full_name"
                       class="form-control"
                       value="<?php echo $user['full_name']; ?>"
                       required>
            </div>

            <div class="mb-3">
                <label>Username</label>
                <input type="text"
                       name="username"
                       class="form-control"
                       value="<?php echo $user['username']; ?>"
                       required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email"
                       name="email"
                       class="form-control"
                       value="<?php echo $user['email']; ?>"
                       required>
            </div>

            <div class="mb-3">
                <label>Mobile</label>
                <input type="text"
                       name="mobile"
                       class="form-control"
                       value="<?php echo $user['mobile']; ?>"
                       required>
            </div>

            <div class="mb-3">
                <label>Current Profile Picture</label>
                <br>

                <?php
                if (
                    !empty($user['profile_picture']) &&
                    file_exists(
                        "../uploads/" .
                        $user['profile_picture']
                    )
                ) {
                ?>
                    <img src="../uploads/<?php echo $user['profile_picture']; ?>"
                         width="120"
                         height="120"
                         class="rounded-circle border">
                <?php
                } else {
                ?>
                    <img src="../assets/images/deafult.png"
                         width="120"
                         height="120"
                         class="rounded-circle border">
                <?php
                }
                ?>
            </div>

            <div class="mb-3">
                <label>Change Profile Picture</label>
                <input type="file"
                       name="profile_picture"
                       class="form-control"
                       accept=".jpg,.jpeg,.png">
            </div>

            <button type="submit"
                    name="update_profile"
                    class="btn btn-primary">
                Update Profile
            </button>

            <a href="profile.php"
               class="btn btn-secondary">
                Cancel
            </a>

        </form>

    </div>

</div>

<?php
include("../includes/footer.php");
?>