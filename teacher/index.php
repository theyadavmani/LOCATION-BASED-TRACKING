<?php

ob_start();
session_start();

if($_SESSION['name']!='oasis')
{
  header('location: ../index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>ATTENDANCE BY LOCATION</title>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="../css/main.css">

</head>
<body>

<header>

  <h1>ATTENDANCE BY LOCATION</h1>
  <div class="navbar">
  <a href="index.php">Home</a>
  <a href="view_attendance.php">Students</a>
  <!-- <a href="teachers.php">Faculties</a> -->
  <!-- <a href="attendance.php">Attendance</a> -->
  <!-- <a href="report.php">Report</a> -->
  <a href="../logout.php">Logout</a>

</div>

</header>

<center>

<div class="row">
    <div class="content">
      <p>One step solution for your class room :)</p>
    <img src="../img/tcr.png" height="200px" width="300px" />

  </div>

</div>

</center>

</body>
</html>
