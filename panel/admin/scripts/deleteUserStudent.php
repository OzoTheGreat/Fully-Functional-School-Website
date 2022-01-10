<?php
session_start();
require '../../db.php';
if(isset($_SESSION["username"])&& $_SESSION["rank"] =='Admin'){
  $id = $_GET['id'];
  $sql = 'DELETE FROM login WHERE login.userID=:id';
  $statement = $connect->prepare($sql);
  if ($statement->execute([':id' => $id])) {
    $sql1 = 'DELETE FROM user WHERE user.userID =:id';
    $stmt = $connect->prepare($sql);
    if($stmt->execute([':id'=>$id]))
    {
      $getID ='SELECT * FROM student WHERE student.userID=:id';
      $getStmt =$connect->prepare($getID);
      $getStmt->execute([':id'=>$id]);
      $result = $getStmt->fetch(PDO::FETCH_ASSOC);
      $studentID = $result["studentID"];
      $student ='DELETE FROM student WHERE student.userID=:id';
      $state =$connect->prepare($student);
      if($state->execute([':id'=>$id]))
      {
        $deleteFromEnrollment ='DELETE FROM enrollment WHERE enrollment.studentID =:studentID';
        $deleteStmt=$connect->prepare($deleteFromEnrollment);
        if($deleteStmt->execute([':studentID'=>$studentID]))
        {
          $_SESSION["delete"] = TRUE;
          header("Location: /panel/admin/users.php");
        }
      }
    }
  }
}else{
  header("location:/panel/log-in.php");
}
