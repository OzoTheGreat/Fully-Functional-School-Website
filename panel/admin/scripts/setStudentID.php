<?php
session_start();
$_SESSION["studentID"]=$_GET["id"];
header('Location: /panel/admin/transcript.php?id='.$_SESSION["studentID"].'');
 ?>
