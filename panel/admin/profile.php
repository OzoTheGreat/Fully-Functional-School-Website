<?php
  require "../db.php";
  session_start();

    $query = 'SELECT user.*, login.userID, login.username, admin.adminRank FROM user INNER JOIN login ON login.userID ='.$_SESSION["id"].' INNER JOIN admin ON admin.userID ='.$_SESSION["id"].' WHERE login.userID = user.userID';
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION["name"] = $result["firstName"].' '.$result["lastName"];
    $_SESSION["adminRank"] = $result["adminRank"];
    $_SESSION["delete"] =FALSE;
    $_SESSION["studentID"]=0;
    $_SESSION["facultyID"]=0;

  if(isset($_SESSION["username"])&& $_SESSION["rank"] =='Admin'){
    $_SESSION["created"]=FALSE;

    print
    '<!DOCTYPE html>
    <html lang="en">
      <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="description" content="">
        <title>Profile - Admin</title>
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
          <ul id="sidenav-left" class="sidenav sidenav-fixed grey">
          <li><a href="../../index.html" class="logo-container">XYZ University<i class="material-icons left">spa</i></a></li>
          <li class="no-padding">
            <ul class="collapsible collapsible-accordion">
            <li class="bold waves-effect"><a class="collapsible-header">Admin Panel<i class="material-icons chevron">chevron_left</i></a>
              <div class="collapsible-body">
                <ul>
                  <li><a href="users.php" class="waves-effect">All Users<i class="material-icons">person</i></a></li>
                  <li><a href="masterschedule.php" class="waves-effect">Schedule<i class="material-icons">event</i></a></li>
                  <li><a href="studentholds.php" class="waves-effect">Student Holds<i class="material-icons">warning</i></a></li>
                  </ul>
                </div>
              </li>
              <ul class="collapsible collapsible-accordion">
                <li class="bold waves-effect"><a class="collapsible-header">Student Records<i class="material-icons chevron">chevron_left</i></a>
                  <div class="collapsible-body">
                    <ul>
                      <li><a href="searchstudent.php" class="waves-effect">Search Student<i class="material-icons">search</i></a></li>
                      <li><a href="viewschedule.php?id='.$_SESSION["studentID"].'" class="waves-effect">View Schedule<i class="material-icons">event</i></a></li>
                      <li><a href="viewdegreeaudit.php?id='.$_SESSION["studentID"].'" class="waves-effect">View Degree Audit<i class="material-icons">dvr</i></a></li>
                      <li><a href="grades.php?id='.$_SESSION["studentID"].'" class="waves-effect">Grades<i class="material-icons">grading</i></a></li>
                      <li><a href="transcript.php?id='.$_SESSION["studentID"].'" class="waves-effect">Transcript<i class="material-icons">file_copy</i></a></li>
                      <li><a href="changemm.php?id='.$_SESSION["studentID"].'" class="waves-effect">Change Major/Minor<i class="material-icons">edit</i></a></li>
                      <li><a href="register.php?id='.$_SESSION["studentID"].'" class="waves-effect">Add Course<i class="material-icons">add</i></a></li>
                    </ul>
                  </div>
                </li>
              </ul>
              <li class="bold waves-effect"><a class="collapsible-header">Faculty<i class="material-icons chevron">chevron_left</i></a>
                <div class="collapsible-body">
                  <ul>
                    <li><a href="searchfaculty.php?id='.$_SESSION["facultyID"].'" class="waves-effect">Search Faculty<i class="material-icons">search</i></a></li>
                    <li><a href="viewcourses.php?id='.$_SESSION["facultyID"].'" class="waves-effect">View Courses<i class="material-icons">dvr</i></a></li>
                    </ul>
                  </div>
                </li>
              <li class="bold waves-effect active"><a class="collapsible-header">Account<i class="material-icons chevron">chevron_left</i></a>
                <div class="collapsible-body">
                  <ul>
                    <li><a href="#" class="waves-effect active">'.$_SESSION["name"].'<i class="material-icons">person</i></a></li>
                    <li><a href="../logout.php" class="waves-effect">Log Out<i class="material-icons">logout</i></a></li>
                    </ul>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </header>
        <nav class="navbar nav-extended no-padding">
          <div class="nav-wrapper"><a href="#" class="brand-logo">Profile</a><a href="#" data-target="sidenav-left" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul id="nav-mobile" class="right">
            </ul><a href="#!" data-target="sidenav-left" class="sidenav-trigger left"><i class="material-icons black-text">menu</i></a>
          </div>
        </nav>
        <main><div class="section container">
      <div class="row">
        <div class="col s12 m4">
          <span class="settings-title">Personal Information</span>
          <p>Here you can find your basic information for your account. If you need to change your password, please contact an Admin.</p>
        </div>
        <div class="col s12 m8">

          <div class="settings-group">
            <div class="setting">
              Account Level

              <div class="switch right">
                '.$_SESSION["rank"].' - '.$_SESSION["adminRank"].'
              </div>
            </div>
            <div class="setting">
              Name

              <div class="switch right">
                '.$result["firstName"].' '.$result["lastName"].'
              </div>
            </div>
            <ul class="collapsible setting">
              <li>
                <div class="collapsible-header">
                  <span>Email</span>
                  <i class="material-icons caret right">keyboard_arrow_right</i>
                </div>
                <div class="collapsible-body">
                  <div class="input-field">
                    <input id="username" type="text" class="validate">
                    <label for="username">'.$result["username"].'</label>
                  </div>
                </div>
              </li>
              <li>
                <div class="collapsible-header"><i class="material-icons">place</i>Address</div>
                <div class="collapsible-body"><span>'.$result["streetAddress"].', '.$result["city"].', '.$result["state"].' '.$result["postalCode"].'</span></div>
              </li>
            </ul>
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

';

  }else{
    header("location:/panel/log-in.php");
  }
 ?>
