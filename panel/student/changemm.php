<?php
  require "../db.php";
  session_start();
  if(!isset($_SESSION["username"])|| $_SESSION["rank"] !='Student'){
    header("location:/panel/log-in.php");
  }
  else
  {
    $sqlmajor ='SELECT * FROM major INNER JOIN studentmajor ON major.majorID = studentmajor.majorID WHERE studentmajor.studentID = "'.$_SESSION["studentID"].'"';
    $sqlminor ='SELECT * FROM minor INNER JOIN studentminor ON minor.minorID = studentminor.minorID WHERE studentminor.studentID = "'.$_SESSION["studentID"].'"';
    $majorstatement = $connect->prepare($sqlmajor);
    $majorstatement->execute();
    $minorstatement = $connect->prepare($sqlminor);
    $minorstatement->execute();
    $majorresult=$majorstatement->fetch(PDO::FETCH_ASSOC);
    $minorresult=$minorstatement->fetch(PDO::FETCH_ASSOC);
    $getMajors = 'SELECT * FROM major';
    $getMinors = 'SELECT * FROM minor';
    $getMajorsStatement = $connect->prepare($getMajors);
    $getMajorsStatement->execute();
    $getMinorsStatement = $connect->prepare($getMinors);
    $getMinorsStatement->execute();
    if(isset($_POST["major"]))
    {
      $changeMajor =$_POST["major"];
      $checkMajor ='SELECT COUNT(*) FROM major INNER JOIN studentmajor ON major.majorID = studentmajor.majorID WHERE studentmajor.studentID ="'.$_SESSION["studentID"].'"';
      $checkMajorStatement=$connect->prepare($checkMajor);
      $checkMajorStatement->execute();
      $checkMajorResult=$checkMajorStatement->fetch(PDO::FETCH_ASSOC);
      if($checkMajorResult["COUNT(*)"]==0)
      {
        $createMajor ='INSERT INTO studentmajor (studentmajor.majorID,studentmajor.studentID) VALUES(:majorID,:studentID)';
        $createMajorStatement =$connect->prepare($createMajor);
        if($createMajorStatement->execute([':majorID'=>$changeMajor,':studentID'=>$_SESSION["studentID"]]))
        {
          header("Location: viewdegreeaudit.php");
        }
      }
      else
      {
        $majorsql ='UPDATE studentmajor SET studentmajor.majorID=:majorID WHERE studentmajor.studentID=:studentID';
        $changeMajorStatement = $connect->prepare($majorsql);
        if($changeMajorStatement->execute([':majorID'=>$changeMajor,':studentID'=>$_SESSION["studentID"]]))
        {
          header("Location: viewdegreeaudit.php");
        }
      }
    }
    if(isset($_POST["minor"]))
    {
      $changeMinor =$_POST["minor"];
      $checkMinor ='SELECT COUNT(*) FROM minor INNER JOIN studentminor ON minor.minorID = studentminor.minorID WHERE studentminor.studentID ="'.$_SESSION["studentID"].'"';
      $checkMinorStatement=$connect->prepare($checkMinor);
      $checkMinorStatement->execute();
      $checkMinorResult=$checkMinorStatement->fetch(PDO::FETCH_ASSOC);
      if($checkMinorResult["COUNT(*)"]==0)
      {
        $createMinor ='INSERT INTO studentminor (studentminor.minorID,studentminor.studentID) VALUES(:minorID,:studentID)';
        $createMinorStatement =$connect->prepare($createMinor);
        if($createMinorStatement->execute([':minorID'=>$changeMinor,':studentID'=>$_SESSION["studentID"]]))
        {
          header("Location: viewdegreeaudit.php");
        }
      }
      else
      {
        $minorsql ='UPDATE studentminor SET studentminor.minorID=:minorID WHERE studentminor.studentID=:studentID';
        $changeMinorStatement = $connect->prepare($minorsql);
        if($changeMinorStatement->execute([':minorID'=>$changeMinor, ':studentID'=>$_SESSION["studentID"]]))
        {
          header("Location: viewdegreeaudit.php");
        }
      }

    }

  }
 ?>
 <html lang="en">
   <head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="msapplication-tap-highlight" content="no">
     <meta name="description" content="">
     <title>Profile - Student</title>
     <link href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css" rel="stylesheet">
     <link href="css/jqvmap.css" rel="stylesheet">
     <link href="css/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
     <!-- Fullcalendar-->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.7.0/fullcalendar.min.css" rel="stylesheet">
     <!-- Materialize-->
     <link href="css/admin-materialize.min.css" rel="stylesheet">
     <!-- Material Icons-->
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   </head>
   <body class="has-fixed-sidenav">
     <header>
       <ul id="sidenav-left" class="sidenav sidenav-fixed red">
       <li><a href="../../index.html" class="logo-container">XYZ University<i class="material-icons left">spa</i></a></li>
       <li class="no-padding">
         <ul class="collapsible collapsible-accordion">
           <li class="bold waves-effect"><a class="collapsible-header">Coruses<i class="material-icons chevron">chevron_left</i></a>
             <div class="collapsible-body">
               <ul>
                 <li><a href="viewschedule.php" class="waves-effect">View Schedule<i class="material-icons">event</i></a></li>
                 <li><a href="register.php" class="waves-effect">Register For a Course<i class="material-icons">how_to_reg</i></a></li>
                 </ul>
               </div>
             </li>
           </ul>
           <ul class="collapsible collapsible-accordion">
             <li class="bold waves-effect"><a class="collapsible-header">Records<i class="material-icons chevron">chevron_left</i></a>
               <div class="collapsible-body">
                 <ul>
                   <li><a href="viewdegreeaudit.php" class="waves-effect">View Degree Audit<i class="material-icons">dvr</i></a></li>
                   <li><a href="grades.php" class="waves-effect">Grades<i class="material-icons">grading</i></a></li>
                   <li><a href="transcript.php" class="waves-effect">Transcript<i class="material-icons">file_copy</i></a></li>
                   <li><a href="attendance.php" class="waves-effect">Attendance<i class="material-icons">class</i></a></li>
                   </ul>
                 </div>
               </li>
             </ul>
         <ul class="collapsible collapsible-accordion">
           <li class="bold waves-effect active"><a class="collapsible-header">Account<i class="material-icons chevron">chevron_left</i></a>
             <div class="collapsible-body">
               <ul>
                 <li><a href="profile.php" class="waves-effect"><?php echo $_SESSION["name"]; ?><i class="material-icons">person</i></a></li>
                 <li><a href="changemm.php" class="waves-effect active">Change Major/Minor<i class="material-icons">edit</i></a></li>
                 <li><a href="../logout.php" class="waves-effect">Log Out<i class="material-icons">logout</i></a></li>
                 </ul>
               </div>
             </li>
           </ul>
         </li>
       </ul>
     </header>
     <nav class="navbar nav-extended no-padding">
       <div class="nav-wrapper"><a href="#" class="brand-logo">Change Major Minor</a><a href="#" data-target="sidenav-left" class="sidenav-trigger"><i class="material-icons">menu</i></a>
         <ul id="nav-mobile" class="right">
         </ul><a href="#!" data-target="sidenav-left" class="sidenav-trigger left"><i class="material-icons black-text">menu</i></a>
       </div>
     </nav>
     <main>
       <div class="container">
         <div class="row">
           <div class="col s12">
             <div class="col s12">
               <h4>Change Major/Minor</h4>
               <span><p>Here you can change your current Major or Minor.</p></span>
               <div class="col 12 m12 center">
                 <span><p>Select The Major or Minor you'd like to change to and then confirm with the <i class="red-text lighten-2">CHANGE</i> button</p></span>
                 <form method="POST">
                   <div class="col s6">
                     <span>Major</span>
                     <select id="major" name="major">
                       <?php
                        if(!isset($minrresult["majorName"]))
                        {
                          echo '<option disabled="disabled" selected>-Major-</option>';
                        }
                        else
                        {
                          echo '<option value="'.$majorresult["majorID"].'">'.$majorresult["majorName"].'</option>';
                        }
                        while($majors= $getMajorsStatement->fetch(PDO::FETCH_ASSOC))
                        {
                          echo '<option value="'.$majors["majorID"].'">'.$majors["majorName"].'</option>';
                        }
                        ?>
                     </select>
                     <label for="major">Major</label>
                   </div>
                   <div class="col s6">
                     <span>Minor</span>
                     <select id="minor" name="minor">
                       <?php
                        if(!isset($minorresult["minorName"]))
                        {
                          echo '<option disabled="disabled" selected>-Minor-</option>';
                        }
                        else
                        {
                          echo '<option value="'.$minorresult["minorID"].'">'.$minorresult["minorName"].'</option>';
                        }
                        while($minors= $getMinorsStatement->fetch(PDO::FETCH_ASSOC))
                        {
                          echo '<option value="'.$minors["minorID"].'">'.$minors["minorName"].'</option>';
                        }

                        ?>
                     </select>
                     <label for="minor">Minor</label>
                   </div>

                   <button class="btn waves-effect waves-light red darken-1" type="submit" name="action">Change
                      <i class="material-icons right">pin</i>
                    </button>
                 </form>
               </div>
             </div>
            </div>
          </div>
        </div>

     </main><!-- Scripts -->
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
     <script src="js/materialize.min.js"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.2/moment.min.js"></script>

     <!-- External libraries -->

     <!-- jqvmap -->
     <script type="text/javascript" src="js/jqvmap/jquery.vmap.min.js"></script>
     <script type="text/javascript" src="js/jqvmap/jquery.vmap.world.js" charset="utf-8"></script>
     <script type="text/javascript" src="js/jqvmap/jquery.vmap.sampledata.js"></script>

     <!-- ChartJS -->
     <script type="text/javascript" src="js/Chart.js"></script>
     <script type="text/javascript" src="js/Chart.Financial.js"></script>


     <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.7.0/fullcalendar.min.js"></script>
     <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
     <script src="js/imagesloaded.pkgd.min.js"></script>
     <script src="js/masonry.pkgd.min.js"></script>


     <!-- Initialization script -->
     <script src="js/admin.js"></script>
         <script src="js/init.js"></script>
       </body>
     </html>
