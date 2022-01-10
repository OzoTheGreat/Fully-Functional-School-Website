<?php
  session_start();

  if(isset($_SESSION["username"])){
    echo '<title>Log Successful -Redirecting...</title>';
    echo '<h3>Login Success, Welcome - '.$_SESSION["username"].' role '.$_SESSION["rank"].' id '.$_SESSION["id"].'</h3>';
    if(isset($_SESSION["username"])and $_SESSION["rank"]==='Admin'){
      header("location:/panel/admin/profile.php");
      exit();
    }
    if (isset($_SESSION["username"])and $_SESSION["rank"]==='Faculty'){
      header("location:/panel/faculty/profile.php");
      exit();
    }
    elseif (isset($_SESSION["username"])and $_SESSION["rank"]=='Student'){
      header("location:/panel/student/profile.php");
      exit();
    }elseif (isset($_SESSION["username"])and $_SESSION["rank"]=='Researcher'){
      header("location:/panel/researcher/profile.php");
      exit();
    }
  }else{
    header("location:log-in.php");
    exit();
  }
 ?>
