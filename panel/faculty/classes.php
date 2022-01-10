<?php
  require "../db.php";
  session_start();

  if(!isset($_SESSION["username"]) || $_SESSION["rank"] !='Faculty'){
    header("location:/panel/log-in.php");
    }
  else
  {
    $query ='SELECT * FROM course INNER JOIN class ON course.courseID = class.courseID WHERE class.semesterID = "FALL21" AND class.facultyID ="'.$_SESSION["facultyID"].'"';
    $statement = $connect->prepare($query);
    $statement->execute();
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
    <title>Classes- Faculty</title>
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
      <ul id="sidenav-left" class="sidenav sidenav-fixed yellow lighten-2">
        <li><a href="../../index.html" class="logo-container">XYZ University<i class="material-icons left">spa</i></a></li>
        <li class="no-padding">
          <ul class="collapsible collapsible-accordion">
            <li class="bold waves-effect active"><a class="collapsible-header">Courses<i class="material-icons chevron">chevron_left</i></a>
              <div class="collapsible-body">
                <ul>
                  <li><a href="classes.php" class="waves-effect active">Classes<i class="material-icons">school</i></a></li>
                  <li><a href="masterschedule.php" class="waves-effect">Master Schedule<i class="material-icons">event</i></a></li>
                </ul>
              </div>
            </li>
          </ul>
          <ul class="collapsible collapsible-accordion">
            <li class="bold waves-effect"><a class="collapsible-header">Student Records<i class="material-icons chevron">chevron_left</i></a>
              <div class="collapsible-body">
                <ul>
                  <li><a href="searchstudent.php" class="waves-effect">Search Student<i class="material-icons">search</i></a></li>
                  <li><a href="viewschedule.php?id=<?php echo $_SESSION["studentID"]; ?>" class="waves-effect">View Schedule<i class="material-icons">event</i></a></li>
                  <li><a href="viewdegreeaudit.php?id=<?php echo $_SESSION["studentID"]; ?>" class="waves-effect">View Degree Audit<i class="material-icons">dvr</i></a></li>
                  <li><a href="grades.php?id=<?php echo $_SESSION["studentID"]; ?>" class="waves-effect">Grades<i class="material-icons">grading</i></a></li>
                  <li><a href="transcript.php?id=<?php echo $_SESSION["studentID"]; ?>" class="waves-effect">Transcript<i class="material-icons">file_copy</i></a></li>
                  <li><a href="advisement.php" class="waves-effect">Advisement<i class="material-icons">people_alt</i></a></li>
                </ul>
              </div>
            </li>
          </ul>
          <ul class="collapsible collapsible-accordion">
            <li class="bold waves-effect"><a class="collapsible-header">Account<i class="material-icons chevron">chevron_left</i></a>
              <div class="collapsible-body">
                <ul>
                  <li><a href="profile.php" class="waves-effect active"><?php echo $_SESSION["name"];?><i class="material-icons">person</i></a></li>
                  <li><a href="../logout.php" class="waves-effect">Log Out<i class="material-icons">settings</i></a></li>
                </ul>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </header>
    <nav class="navbar nav-extended no-padding">
      <div class="nav-wrapper"><a href="#" class="brand-logo">Classes</a><a href="#" data-target="sidenav-left" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul id="nav-mobile" class="right">
        </ul><a href="#!" data-target="sidenav-left" class="sidenav-trigger left"><i class="material-icons black-text">menu</i></a>
      </div>
    </nav>
    <main>
      <div class="container">
        <div class="row">
          <div class="col s12">
            <div class="col s12 center">
                <h4>Welcome - <?php echo $_SESSION["name"];?></h4>
                <span><p>Here are your Classes For Fall 2021</p></span>
            </div>
            <?php
              while($result= $statement->fetch(PDO::FETCH_ASSOC))
              {
                echo '<ul class="collection with-header hoverable">';
                echo '<li class="collection-header center yellow lighten-3"><h4 class="section-title">'.$result["courseTitle"].' - '.$result["CRN"].'</h4></li>';
                echo '<li class="collection-item"><a href="scripts/viewclass.php?id='.$result["CRN"].'" class="brand-logo">View Class</a></li>';
                echo '<li class="collection-item"><a href="scripts/viewstudents.php?id='.$result["CRN"].'" class="brand-logo">View Students</a></li>';
                echo '<li class="collection-item"><a href="scripts/viewgrades.php?id='.$result["CRN"].'" class="brand-logo">View Grades</a></li>';
                echo '<li class="collection-item"><a href="scripts/viewattendance.php?id='.$result["CRN"].'" class="brand-logo">View Attendance</a></li>';
                echo '</ul>';
              }
            ?>

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
