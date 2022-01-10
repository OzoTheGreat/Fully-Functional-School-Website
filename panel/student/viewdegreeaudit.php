<?php
require "../db.php";
session_start();
if(!isset($_SESSION["username"])|| $_SESSION["rank"] !='Student'){
  header("location:/panel/log-in.php");
}
else
{
  $query ='SELECT * FROM course INNER JOIN class ON class.courseID = course.courseID INNER JOIN enrollment ON class.CRN = enrollment.CRN WHERE enrollment.studentID = "'.$_SESSION["studentID"].'"';
  $statement = $connect->prepare($query);
  $statement->execute();
  $query1 ='SELECT * FROM course INNER JOIN studenthistory ON course.courseID = studenthistory.courseID WHERE studenthistory.studentID ="'.$_SESSION["studentID"].'"';
  $statement1 = $connect->prepare($query1);
  $statement1->execute();
  $statement2 = $connect->prepare($query1);
  $statement2->execute();
  $query2 = 'SELECT * FROM major INNER JOIN studentmajor ON major.majorID = studentmajor.majorID WHERE studentmajor.studentID = "'.$_SESSION["studentID"].'"';
  $statement3 = $connect->prepare($query2);
  $statement3->execute();
  $query3 = 'SELECT * FROM minor INNER JOIN studentminor ON minor.minorID = studentminor.minorID WHERE studentminor.studentID = "'.$_SESSION["studentID"].'"';
  $statement4 = $connect->prepare($query3);
  $statement4->execute();
  $query4 ='SELECT * FROM undergraduate WHERE undergraduate.studentID ="'.$_SESSION["studentID"].'"';
  $statement5 = $connect->prepare($query4);
  $statement5->execute();
  $undergradGPA = $statement5->fetch(PDO::FETCH_ASSOC);
  $query5 ='SELECT * FROM graduatestudent WHERE graduatestudent.studentID ="'.$_SESSION["studentID"].'"';
  $statement6 = $connect->prepare($query5);
  $statement6->execute();
  $gradGPA = $statement6->fetch(PDO::FETCH_ASSOC);
  $credits =0;
  while($completedCredits = $statement1->fetch(PDO::FETCH_ASSOC))
  {
    $credits += intval($completedCredits["courseCredit"]);
  }
  $major = $statement3->fetch(PDO::FETCH_ASSOC);
  $minor = $statement4->fetch(PDO::FETCH_ASSOC);
  if(isset($major["majorID"]))
  {
    $sql1 ='SELECT * FROM majorreq INNER JOIN course ON majorreq.courseID= course.courseID WHERE majorreq.majorID =:major';
    $stmt1 = $connect->prepare($sql1);
    $stmt1->execute([':major'=>$major["majorID"]]);
  }
  if(isset($minor["minorID"]))
  {
    $sql2 ='SELECT * FROM minorreq INNER JOIN course ON minorreq.courseID= course.courseID WHERE minorreq.minorID =:minor';
    $stmt2 = $connect->prepare($sql2);
    $stmt2->execute([':minor'=>$minor["minorID"]]);
  }

}
?>
<!DOCTYPE html>
  <html lang="en">
    <head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="msapplication-tap-highlight" content="no">
      <meta name="description" content="">
      <title>Degree Audit - Student</title>
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
                  <li><a href="viewschedule.php" class="waves-effect active">View Schedule<i class="material-icons">event</i></a></li>
                  <li><a href="register.php" class="waves-effect">Register For a Course<i class="material-icons">how_to_reg</i></a></li>
                  </ul>
                </div>
              </li>
            </ul>
            <ul class="collapsible collapsible-accordion">
              <li class="bold waves-effect active"><a class="collapsible-header">Records<i class="material-icons chevron">chevron_left</i></a>
                <div class="collapsible-body">
                  <ul>
                    <li><a href="#" class="waves-effect active">View Degree Audit<i class="material-icons">dvr</i></a></li>
                    <li><a href="grades.php" class="waves-effect">Grades<i class="material-icons">grading</i></a></li>
                    <li><a href="transcript.php" class="waves-effect">Transcript<i class="material-icons">file_copy</i></a></li>
                    <li><a href="attendance.php" class="waves-effect">Attendance<i class="material-icons">class</i></a></li>
                    </ul>
                  </div>
                </li>
              </ul>
          <ul class="collapsible collapsible-accordion">
            <li class="bold waves-effect"><a class="collapsible-header">Account<i class="material-icons chevron">chevron_left</i></a>
              <div class="collapsible-body">
                <ul>
                  <li><a href="profile.php" class="waves-effect active"><?php echo $_SESSION["name"]; ?><i class="material-icons">person</i></a></li>
                  <li><a href="changemm.php" class="waves-effect ">Change Major/Minor<i class="material-icons">edit</i></a></li>
                  <li><a href="../logout.php" class="waves-effect">Log Out<i class="material-icons">logout</i></a></li>
                  </ul>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </header>
      <nav class="navbar nav-extended no-padding">
        <div class="nav-wrapper"><a href="#" class="brand-logo">Degree Audit</a><a href="#" data-target="sidenav-left" class="sidenav-trigger"><i class="material-icons">menu</i></a>
          <ul id="nav-mobile" class="right">
          </ul><a href="#!" data-target="sidenav-left" class="sidenav-trigger left"><i class="material-icons black-text">menu</i></a>
        </div>
      </nav>
      <main>
        <div class="container">
          <div class="row">
            <div class="col s12">
              <div class="col s12">
                <div class="settings-group">
                  <div class="setting center red lighten-2 hoverable">
                    <h5 class="section-title">Degree Audit For - <?php echo $_SESSION["name"]; ?></h5>
                  </div>
                  <div class="center">
                  <div class="col s3">
                    <p>Credits: <?php echo $credits; ?></p>
                  </div>
                  <div class="col s3">
                    <p>Major: <?php if(!isset($major["majorName"])){echo "None";}else{echo $major["majorName"];};?></p>
                  </div>
                  <div class="col s3">
                    <p>Minor: <?php if(!isset($minor["minorName"])){echo "None";}else{echo $minor["minorName"];} ?></p>
                  </div>
                  <div class="col s3">
                    <p>GPA: <?php echo $_SESSION["GPA"]; ?></p>
                  </div>
                  <div class="col s12">
                    <p>Completion: <?php $percent = round(100*($credits/120),2); if($percent>100){$percent= 100;}; echo $percent;?>%</p>
                  </div>
                  </div>
                </div>
                <div class="progress">
                  <div class="determinate red darken-2" style="width: <?php echo $percent; ?>%"></div>
                </div>
                </div>
                <ul class="collection with-header hoverable">
                  <li class="collection-header center red lighten-2"><h4 class="section-title">Courses Completed</h4></li>
                  <?php
                  while($completed = $statement2->fetch(PDO::FETCH_ASSOC))
                  {
                    echo '<li class="collection-item">'.$completed["courseID"].' - '.$completed["courseTitle"].'</br>Credits: '.$completed["courseCredit"].'</br>Grade: '.$completed["grade"].'</br>Semester Completed: </i>'.$completed["semesterID"].'<i class="right green-text lighten-2">Satisfied</i></li>';
                  }
                  ?>
                </ul>

                <ul class="collection with-header hoverable">
                  <li class="collection-header center red lighten-2"><h4 class="section-title">In Progress</h4></li>
                  <?php
                  while($inprogress = $statement->fetch(PDO::FETCH_ASSOC))
                  {
                    echo '<li class="collection-item">'.$inprogress["courseID"].' - '.$inprogress["courseTitle"].'</br>Credits: '.$inprogress["courseCredit"].'</li>';
                  }
                  ?>
                </ul>
                <?php
                if(isset($major["majorID"]))
                {
                  echo '<ul class="collection with-header hoverable">';
                  echo '<li class="collection-header center red lighten-2"><h4 class="section-title">Requirements For Major '.$major["majorName"].'</h4></li>';
                  while($reqmajor=$stmt1->fetch(PDO::FETCH_ASSOC))
                  {
                    echo '<li class="collection-item">'.$reqmajor["courseID"].' - '.$reqmajor["courseTitle"].'</br>Credits: '.$reqmajor["courseCredit"].'</li>';
                  }

                  echo '</ul>';
                }
                if(isset($minor["majorID"]))
                {
                  echo '<ul class="collection with-header hoverable">';
                  echo '<li class="collection-header center red lighten-2"><h4 class="section-title">Requirements For Minor '.$minor["minorName"].'</h4></li>';
                  while($reqminor=$stmt2->fetch(PDO::FETCH_ASSOC))
                  {
                    echo '<li class="collection-item">'.$reqminor["courseID"].' - '.$reqminor["courseTitle"].'</br>Credits: '.$reqminor["courseCredit"].'</li>';
                  }

                  echo '</ul>';
                }
                 ?>
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
