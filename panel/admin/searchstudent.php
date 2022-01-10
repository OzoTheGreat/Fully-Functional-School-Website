<?php
require "../db.php";
session_start();
if(!isset($_SESSION["username"])|| $_SESSION["rank"] !='Admin')
{
  header("location:/panel/log-in.php");
}
else
{
    $query ='SELECT * FROM student INNER JOIN user ON student.userID = user.userID INNER JOIN studentmajor ON student.studentID = studentmajor.studentID INNER JOIN major ON studentmajor.majorID = major.majorID';
    $statement = $connect->prepare($query);
    $statement ->execute();

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
     <title>Master Schedule - Admin</title>
     <link href="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.css" rel="stylesheet">
     <link href="../css/jqvmap.css" rel="stylesheet">
     <link href="../css/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
     <!-- Fullcalendar-->
     <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.7.0/fullcalendar.min.css" rel="stylesheet">
     <!-- Materialize-->
     <link href="../css/admin-materialize.min.css" rel="stylesheet">
     <!-- Material Icons-->
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
   </head>
   <body class="has-fixed-sidenav">
     <header>
       <ul id="sidenav-left" class="sidenav sidenav-fixed grey">
       <li><a href="../../../index.html" class="logo-container">XYZ University<i class="material-icons left">spa</i></a></li>
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
               <li class="bold waves-effect active"><a class="collapsible-header">Student Records<i class="material-icons chevron">chevron_left</i></a>
                 <div class="collapsible-body">
                   <ul>
                     <li><a href="searchstudent.php" class="waves-effect active">Search Student<i class="material-icons">search</i></a></li>
                     <li><a href="viewschedule.php?id=<?php echo $_SESSION["studentID"]; ?>" class="waves-effect">View Schedule<i class="material-icons">event</i></a></li>
                     <li><a href="viewdegreeaudit.php?id=<?php echo $_SESSION["studentID"]; ?>" class="waves-effect">View Degree Audit<i class="material-icons">dvr</i></a></li>
                     <li><a href="grades.php?id=<?php echo $_SESSION["studentID"]; ?>" class="waves-effect">Grades<i class="material-icons">grading</i></a></li>
                     <li><a href="transcript.php?id=<?php echo $_SESSION["studentID"]; ?>" class="waves-effect">Transcript<i class="material-icons">file_copy</i></a></li>
                     <li><a href="changemm.php?id=<?php echo $_SESSION["studentID"]; ?>" class="waves-effect">Change Major/Minor<i class="material-icons">edit</i></a></li>
                     <li><a href="register.php?id=<?php echo $_SESSION["studentID"]; ?>" class="waves-effect">Add Course<i class="material-icons">add</i></a></li>
                   </ul>
                 </div>
               </li>
             </ul>
             <li class="bold waves-effect"><a class="collapsible-header">Faculty<i class="material-icons chevron">chevron_left</i></a>
               <div class="collapsible-body">
                 <ul>
                   <li><a href="searchfaculty.php?id=<?php echo $_SESSION["facultyID"]; ?>" class="waves-effect">Search Faculty<i class="material-icons">search</i></a></li>
                   <li><a href="viewcourses.php?id=<?php echo $_SESSION["facultyID"]; ?>" class="waves-effect">View Courses<i class="material-icons">dvr</i></a></li>
                   </ul>
                 </div>
               </li>
           <li class="bold waves-effect"><a class="collapsible-header">Account<i class="material-icons chevron">chevron_left</i></a>
             <div class="collapsible-body">
               <ul>
                 <li><a href="profile.php" class="waves-effect"><?php echo $_SESSION["name"];?><i class="material-icons">person</i></a></li>
                 <li><a href="../logout.php" class="waves-effect">Log Out<i class="material-icons">logout</i></a></li>
                 </ul>
               </div>
             </li>
           </ul>
         </li>
       </ul>
     </header>
     <!-- Main / Tables -->
     <main>
       <div class="container">
         <div class="row">
           <div class="col s12">
             <h2 class="section-title">All Students</h2>
               <span class="settings-title">All Students in XYZ University</span>
               <p>You can view ANY students Schedule, Degree Audit, Grades, and Transcript records just by looking them up in the database.</p>
                 <div class='col s12'>
                   <div class='card'>
                     <table id ='defualt-table' class='row-border' cellspacing='0' width='100%'>
                       <thead>
                         <tr>
                           <th>Student ID</th>
                           <th>Last Name</th>
                     		   <th>First Name</th>
                     		   <th>Major</th>
                           <th>Year</th>
                           <th>Search</th>
                         </tr>
                       </thead>
                       <?php
                          while($result=$statement->fetch(PDO::FETCH_ASSOC))
                          {
                            echo '<tr>';
                            echo '<td>' .$result["studentID"]. '</td>';
                            echo '<td>' .$result["lastName"]. '</td>';
                            echo '<td>' .$result["firstName"]. '</td>';
                            echo '<td>' .$result["majorName"]. '</td>';
                            echo '<td>' .$result["studentType"]. '</td>';
                            echo '<td><a href="scripts/setStudentID.php?id='.$result["studentID"].'"class="waves-effect waves-light btn-small grey darken-1"><i class="material-icons">search</i></a></td>';
                            echo '</tr>';
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
