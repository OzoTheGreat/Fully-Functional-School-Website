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
      $_SESSION["delete"] = TRUE;
      header("Location: /panel/admin/users.php");
    }  
  }
}else{
  header("location:/panel/log-in.php");
}
