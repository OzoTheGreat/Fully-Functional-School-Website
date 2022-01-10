<?php
  require "../../db.php";
  session_start();
  if(!isset($_SESSION["username"])|| $_SESSION["rank"] !='Admin')
  {
    header("location:/panel/log-in.php");
  }
  else
  {
    $id = $_GET["id"];
    $hold =$_GET["hold"];
    $query ='DELETE FROM studenthold WHERE studenthold.studentID =:studentID AND studenthold.holdID =:holdID';
    $statement =$connect->prepare($query);
    $statement->execute([':studentID'=>$id,':holdID'=>$hold]);
    header("Location: /panel/admin/studentholds.php");
  }

 ?>
