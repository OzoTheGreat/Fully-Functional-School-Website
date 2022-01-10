<?php
require "../../db.php";
session_start();
if(!isset($_SESSION["username"])|| $_SESSION["rank"] !='Admin')
{
  header("location:/panel/log-in.php");
}
else
{
    $CRN = $_GET['CRN'];
    $studentID =$_GET['id'];
    $getClassSQL ='SELECT * FROM class WHERE class.CRN =:CRN';
    $stmt = $connect->prepare($getClassSQL);
    $stmt->execute([':CRN'=>$CRN]);
    $class =$stmt->fetch(PDO::FETCH_ASSOC);
    $sql='DELETE FROM enrollment WHERE enrollment.CRN=:CRN AND enrollment.studentID=:studentID';
    $updateSeats = intval($class["seatsAvailable"])+1;
    $updateSeatsSQL ='UPDATE class SET class.seatsAvailable=:seats WHERE class.CRN =:id';
    $updateStmt =$connect->prepare($updateSeatsSQL);
    $statement = $connect->prepare($sql);
    $sql1 ='DELETE FROM attendance WHERE attendance.CRN=:CRN AND attendance.studentID=:studentID';
    $stmt1 = $connect->prepare($sql1);
    if($statement->execute([':CRN'=>$CRN,':studentID'=>$studentID])&& $updateStmt->execute([':seats'=>$updateSeats,':id'=>$class["CRN"]])&&$stmt1->execute([':CRN'=>$CRN,':studentID'=>$studentID]))
    {
      header('Location:../viewschedule.php?id='.$studentID.'');
    }
  }
?>
