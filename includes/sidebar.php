<div class="sidebar">

    <h4>User Management</h4>

    <a href="../dashboard.php">
        <i class="bi bi-speedometer2"></i>
        Dashboard
    </a>

    <a href="../profile/profile.php">
        <i class="bi bi-person-circle"></i>
        My Profile
    </a>

<?php if($_SESSION['role']=="Admin"){ ?>

    <a href="../users/view_users.php">
        <i class="bi bi-people"></i>
        View Users
    </a>

    <a href="../users/add_user.php">
        <i class="bi bi-person-plus"></i>
        Add User
    </a>

<?php } ?>

    <a href="../auth/logout.php">
        <i class="bi bi-box-arrow-right"></i>
        Logout
    </a>

</div>