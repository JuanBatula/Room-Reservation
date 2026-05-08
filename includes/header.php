<!doctype html>
<?php $title = isset($title) ? $title : "Admin"; ?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../styles/admin.css">
    <title>CIT — <?php echo $title ?></title>
  </head>
  <body>

    <header class="container">
      <img src="../images/citlogo.png" class="cit-logo" alt="CIT Logo">
      <a href="dashboard.php">Dashboard</a>
      <a href="bookings.php">Bookings</a>
      <a href="rooms.php">Rooms</a>
      <a href="admins.php">Admins</a>
      <a href="../logout.php">Logout</a>
    </header>