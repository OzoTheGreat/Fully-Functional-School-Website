<?php
session_start();
$_SESSION["facultyID"]=$_GET["id"];
header('Location: /panel/admin/viewcourses.php?id='.$_SESSION["facultyID"].'');
 ?>
