<?php
  require "../db.php";
  session_start();
  if(!isset($_SESSION["username"])|| $_SESSION["rank"] !='Student')
  {
    header("location:/panel/log-in.php");
  }
  else
  {
    $query ='SELECT * FROM course INNER JOIN studenthistory ON course.courseID =studenthistory.courseID WHERE studenthistory.studentID ="'.$_SESSION["studentID"].'"';
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
    $query3='SELECT * FROM major INNER JOIN studentmajor ON major.majorID = studentmajor.majorID WHERE studentmajor.studentID = "'.$_SESSION["studentID"].'"';
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
      <title>Schedule - Student</title>
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
              <li class="bold waves-effect active"><a class="collapsible-header">Records<i class="material-icons chevron">chevron_left</i></a>
                <div class="collapsible-body">
                  <ul>
                    <li><a href="viewdegreeaudit.php" class="waves-effect">View Degree Audit<i class="material-icons">dvr</i></a></li>
                    <li><a href="grades.php" class="waves-effect">Grades<i class="material-icons">grading</i></a></li>
                    <li><a href="transcript.php" class="waves-effect active">Transcript<i class="material-icons">file_copy</i></a></li>
                    <li><a href="attendance.php" class="waves-effect">Attendance<i class="material-icons">class</i></a></li>
                    </ul>
                  </div>
                </li>
              </ul>
          <ul class="collapsible collapsible-accordion">
            <li class="bold waves-effect"><a class="collapsible-header">Account<i class="material-icons chevron">chevron_left</i></a>
              <div class="collapsible-body">
                <ul>
                  <li><a href="profile.php" class="waves-effect"><?php echo $_SESSION["name"]; ?><i class="material-icons">person</i></a></li>
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
        <div class="nav-wrapper"><a href="#" class="brand-logo">Transcript Results for Student - <?php echo $_SESSION["name"];?></a><a href="#" data-target="sidenav-left" class="sidenav-trigger"><i class="material-icons">menu</i></a>
          <ul id="nav-mobile" class="right">
          </ul><a href="#!" data-target="sidenav-left" class="sidenav-trigger left"><i class="material-icons black-text">menu</i></a>
        </div>
      </nav>
      <main>
        <div class="container">
          <div class="row">
            <div class="col s12">
              <div class="col s12">
                <ul class="collection with-header">
                  <li class="collection-header center"><h4 class="section-title">Transcript For <?php echo $_SESSION["name"];?></h4>
                    <div class="settings-group">
                      <div class="col s4">
                        <p>Student ID: <?php echo $_SESSION["studentID"]; ?></p>
                      </div>
                      <div class="col s4">
                        <p>Credits: <?php echo $credits; ?></p>
                      </div>
                      <div class="col s4">
                        <p>GPA: <?php echo $_SESSION["GPA"]; ?></p>
                      </div>
                      <div class="col s6">
                        <p>Major: <?php echo $major["majorName"];?></p>
                      </div>
                      <div class="col s6">
                        <p>Minor: <?php if(!isset($minor["minorName"])){echo "None";}else{echo $minor["minorName"];} ?></p>
                      </div>
                      </div>
                    </br>
                  </br>
                </br>
                    </li>
                <?php
                while($result = $statement->fetch(PDO::FETCH_ASSOC))
                {
                  echo '<li class="collection-item">Course: '.$result["courseTitle"].' - '.$result["courseID"].'</br>Grade: '.$result["grade"].'</br>Semester: '.$result["semesterID"].'</li>';
                  //echo '<li class="collection-item">CRN: '.$result["CRN"].'</li>';
                }
                ?>
                </ul>
              </div>
              </div>
              <p class="center"><i><li class="center">These are grades for previous semesters and NOT courses that are currently being taken. For courses in progress, See "Grades"</li></p>
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
