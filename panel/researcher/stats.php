<?php
  require '../db.php';
  session_start();
  if(!isset($_SESSION["username"])&& $_SESSION["rank"] =='Researcher'){
    header("location:/panel/log-in.php");
  }
  else
  {
    //students
    $getNumOfStudents ='SELECT COUNT(studentID) FROM student';
    $getNumOfStudentsSTMT = $connect->prepare($getNumOfStudents);
    $getNumOfStudentsSTMT->execute();
    $result1 = $getNumOfStudentsSTMT->fetch(PDO::FETCH_ASSOC);
    $numberOfStudents = $result1["COUNT(studentID)"];

    //undergrad
    $getNumOfUnderGrad ='SELECT COUNT(studentID) FROM undergraduate';
    $getNumOfUnderGradSTMT = $connect->prepare($getNumOfUnderGrad);
    $getNumOfUnderGradSTMT->execute();
    $result2 = $getNumOfUnderGradSTMT->fetch(PDO::FETCH_ASSOC);
    $numberOfUndergrad = $result2["COUNT(studentID)"];

    //grad
    $getNumOfGrad ='SELECT COUNT(studentID) FROM graduatestudent';
    $getNumOfGradSTMT =$connect->prepare($getNumOfGrad);
    $getNumOfGradSTMT->execute();
    $result3 = $getNumOfGradSTMT->fetch(PDO::FETCH_ASSOC);
    $numberOfGrad = $result3["COUNT(studentID)"];

    //fac
    $getNumOfFac ='SELECT COUNT(facultyID) FROM faculty';
    $getNumOfFacSTMT =$connect->prepare($getNumOfFac);
    $getNumOfFacSTMT->execute();
    $result4 = $getNumOfFacSTMT->fetch(PDO::FETCH_ASSOC);
    $numberOfFaculty = $result4["COUNT(facultyID)"];
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
        <title>Profile - Researcher</title>
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
          <ul id="sidenav-left" class="sidenav sidenav-fixed green lighten-2">
            <li><a href="../../index.html" class="logo-container">XYZ University<i class="material-icons left">spa</i></a></li>
            <li class="no-padding">
              <ul class="collapsible collapsible-accordion">
                <li class="bold waves-effect"><a class="collapsible-header">XYZ Stats<i class="material-icons chevron">chevron_left</i></a>
                  <div class="collapsible-body">
                    <ul>
                      <li><a href="stats.php" class="waves-effect ">Campus Stats<i class="material-icons">info</i></a></li>
                    </ul>
                  </div>
                </li>
              </ul>
              <ul class="collapsible collapsible-accordion">
                <li class="bold waves-effect active"><a class="collapsible-header">Account<i class="material-icons chevron">chevron_left</i></a>
                  <div class="collapsible-body">
                    <ul>
                      <li><a href="profile.php" class="waves-effect active"><?php echo $_SESSION["name"];?><i class="material-icons">person</i></a></li>
                      <li><a href="../logout.php" class="waves-effect">Log Out<i class="material-icons">logout</i></a></li>
                    </ul>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </header>
        <nav class="navbar nav-extended no-padding">
          <div class="nav-wrapper"><a href="#" class="brand-logo">Campus Stats</a><a href="#" data-target="sidenav-left" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul id="nav-mobile" class="right">
            </ul><a href="#!" data-target="sidenav-left" class="sidenav-trigger left"><i class="material-icons black-text">menu</i></a>
          </div>
        </nav>
        <main>
          <div class="container">
            <div class="card-panel hoverable">
              <h4 class="center">Here are some Basic Stats for XYZ University</h4>
            </div>
            <div class="row">
              <div class="col s12 m12">
                <div class="card-panel green">
                  <h5 class="white-text">Number of Students Enrolled in XYZ University</h5>
                  <h4 class="black-text"><?php echo $numberOfStudents; ?>
                  </h4>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m12">
                <div class="card-panel red">
                  <h5 class="white-text">Number of Undergraduate Students Enrolled in XYZ University</h5>
                  <h4 class="black-text"><?php echo $numberOfUndergrad; ?>
                  </h4>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m12">
                <div class="card-panel yellow darken-3">
                  <h5 class="white-text">Number of Graduate Students Enrolled in XYZ University</h5>
                  <h4 class="black-text"><?php echo $numberOfGrad; ?>
                  </h4>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col s12 m12">
                <div class="card-panel grey">
                  <h5 class="white-text">Number of Faculty in XYZ University</h5>
                  <h4 class="black-text"><?php echo $numberOfFaculty; ?>
                  </h4>
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
