<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

<link href="../assets/css/style.css" rel="stylesheet">

<title>User Management System</title>

</head>

<body>

<div class="wrapper">

<?php include("sidebar.php"); ?>

<div class="main">

<div class="topbar">

<div>

<strong>User Management System</strong>

</div>

<div>

Welcome,
<strong>

<?php echo $_SESSION['full_name']; ?>

</strong>

|

<span class="badge bg-primary">

<?php echo $_SESSION['role']; ?>

</span>

</div>

</div>

<div class="content">