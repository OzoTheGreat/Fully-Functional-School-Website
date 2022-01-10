<?php
  require "../../db.php";
  session_start();
  if(!isset($_SESSION["username"])|| $_SESSION["rank"] !='Student'){
    header("location:/panel/log-in.php");
  }
  else
  {
    $id = $_GET['id'];
    $getClassSQL ='SELECT * FROM class WHERE class.CRN =:id';
    $stmt = $connect->prepare($getClassSQL);
    $stmt->execute([':id'=>$id]);
    $class =$stmt->fetch(PDO::FETCH_ASSOC);
    $sql ='INSERT INTO enrollment (enrollment.studentID,enrollment.CRN,enrollment.grade,enrollment.semester) VALUES(:studentID,:CRN,"A",:semester)';
    $statement=$connect->prepare($sql);
    $updateSeats = intval($class["seatsAvailable"])-1;
    $updateSeatsSQL ='UPDATE class SET class.seatsAvailable=:seats WHERE class.CRN =:id';
    $updateStmt =$connect->prepare($updateSeatsSQL);
    if($statement->execute([':studentID'=>$_SESSION["studentID"],':CRN'=>$class["CRN"],':semester'=>$class["semesterID"]]) && $updateStmt->execute([':seats'=>$updateSeats,':id'=>$class["CRN"]]))
    {
      $_SESSION["credits"] +=4;
      header("Location:registerForSemester.php");
    }
  }
 ?>
