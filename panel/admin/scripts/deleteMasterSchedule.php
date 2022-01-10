<?php
session_start();
require '../../db.php';
if(isset($_SESSION["username"])&& $_SESSION["rank"] =='Admin'){
  $id = $_GET['id'];
  $sql = 'DELETE FROM class  WHERE CRN =:id';
  $statement = $connect->prepare($sql);
  if ($statement->execute([':id' => $id])) {
    $_SESSION["delete"] = TRUE;
    header("Location: /panel/admin/masterschedule.php");
  }
}else{
  header("location:/panel/log-in.php");
}
