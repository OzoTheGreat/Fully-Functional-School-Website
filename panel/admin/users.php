<?php
  session_start();
  require "../db.php";
  if(isset($_SESSION["username"])&& $_SESSION["rank"] =='Admin'){
    print
    '<!DOCTYPE html>
    <html lang="en">
      <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="description" content="">
        <title>All Users - Admin</title>
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
              <li class="bold waves-effect active"><a class="collapsible-header">Admin Panel<i class="material-icons chevron">chevron_left</i></a>
                <div class="collapsible-body">
                  <ul>
                    <li><a href="users.php" class="waves-effect active">All Users<i class="material-icons">person</i></a></li>
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
              <li class="bold waves-effect"><a class="collapsible-header">Account<i class="material-icons chevron">chevron_left</i></a>
                <div class="collapsible-body">
                  <ul>
                    <li><a href="profile.php" class="waves-effect">'.$_SESSION["name"].'<i class="material-icons">person</i></a></li>
                    <li><a href="../logout.php" class="waves-effect">Log Out<i class="material-icons">logout</i></a></li>
                    </ul>
                  </div>
                </li>
              </ul>
            </li>
          </ul>
        </header>
        <nav class="navbar nav-extended no-padding">
          <div class="nav-wrapper"><a href="#" class="brand-logo">All Users</a><a href="#" data-target="sidenav-left" class="sidenav-trigger"><i class="material-icons">menu</i></a>
            <ul id="nav-mobile" class="right">
            </ul><a href="#!" data-target="sidenav-left" class="sidenav-trigger left"><i class="material-icons black-text">menu</i></a>
          </div>
        </nav>
        <main>'?>
          <?php
            if($_SESSION["delete"]===TRUE){
              echo '<span class="badge red white-text">User has succesfully been Deleted</span>';
              $_SESSION["delete"]===FALSE;
            }if($_SESSION["created"]==TRUE){
              echo '<span class="badge blue white-text">User has succesfully been Created</span>';
            }
          echo'
          <!-- Tables -->
    <div class="container">
      <div class="row">
        <div class="col s12">
          <h2 class="section-title">All Users</h2>
            <span class="settings-title">All Users in XYZ University</span>
            <p>You can Add or Delete Users from the database from this page. Use with CAUTION.</p>
            <div id=\'test2\' class=\'row\'>
            <div class =\' col s12 row\'>
            <a href ="scripts/createUser.php" class="btn-floating btn waves-effect waves-light teal lighten-2"><i class="material-icons">add</i></a>
            </div>
              <div class=\'col s12\'>
                <div class=\'card\'>
                  <table id =\'defualt-table\' class=\'row-border\' cellspacing=\'0\' width=\'100%\'>
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>First Name</th>
              		  <th>Last Name</th>
              		  <th>Date of Birth</th>
                    <th>Address</th>
                    <th>Phone Number</th>
              		  <th>Account Level</th>
              		  <th>Email</th>
                    <th>Password</th>
                    <th>Edit</th>
                    <th>Delete</th>
                  </tr>
                </thead>
                '?>
                <?php

                try {

                    $stmt = $connect->prepare("SELECT * FROM login INNER JOIN user ON user.userID =login.userID");
                    $stmt->execute();
                    while($row =$stmt->fetch(PDO::FETCH_ASSOC)){
                                echo '<tr>';
                                echo '<td>' . $row["userID"] . '</td>';
                                echo '<td>' . $row["firstName"] . '</td> ';
    			                      echo '<td>' . $row["lastName"] . '</td>';
                                echo '<td>' . $row["DOB"] . '</td> ';
                                echo '<td>' . $row["streetAddress"] .', '. $row["city"] .', '. $row["state"] .' '. $row["postalCode"] . '</td> ';
                                echo '<td>' . $row["phoneNumber"] . '</td> ';
                                echo '<td>' . $row["userType"] . '</td> ';
                                echo '<td>' . $row["username"] . '</td> ';
                                echo '<td>' . $row["password"] . '</td>';
                                echo '<td><a href="scripts/updateUser.php?id='.$row["userID"].'"class="waves-effect waves-light btn-small orange lighten-1"><i class="material-icons">edit</i></a></td>';
                                if($_SESSION["id"]==$row["userID"]){
                                  echo '<td><button type="button" name="delete"class="btn-small disabled"><i class="material-icons">delete</i></button></td>';
                                }else if($row["userType"]=="Admin" and $_SESSION["adminRank"] !=="Administrator"){
                                  echo '<td><button type="button" name="delete" class="btn-small disabled"><i class="material-icons">delete</i></button></td>';
                                }
                                elseif($row["userType"]=="Student")
                                {
                                  echo '<td><a onClick ="javascript: return confirm(\'Are You sure to delete user '.$row["firstName"].' '.$row["lastName"].' ?\');" href="scripts/deleteUserStudent.php?id='.$row["userID"].'"class="waves-effect waves-light btn-small red lighten-1"><i class="material-icons">delete</i></a></td>';
                                }
                                else
                                {
                                  echo '<td><a onClick ="javascript: return confirm(\'Are You sure to delete user '.$row["firstName"].' '.$row["lastName"].' ?\');" href="scripts/deleteUser.php?id='.$row["userID"].'"class="waves-effect waves-light btn-small red lighten-1"><i class="material-icons">delete</i></a></td>';
                                }
                                echo '</tr>';
                    }
                  }catch(PDOException $e) {
                      echo "Error: " . $e->getMessage();
                  }

          echo  '</div>
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
    </html>'
;

  }else{
    header("location:/panel/log-in.php");
  }
 ?>
