<?php
  require "../db.php";
  session_start();
  if(!isset($_SESSION["username"]) || $_SESSION["rank"] !='Faculty'){
    header("location:/panel/log-in.php");
    }
  else
  {
    if(!isset($semesterID))
    {
      $semesterID ="FALL21";
    }
    if(isset($_POST["semester"]))
    {
      $semesterID =$_POST["semester"];
    }
    $sql ="SELECT * FROM class
    INNER JOIN
     course ON course.courseID = class.courseID
    INNER JOIN
     faculty ON faculty.facultyID = class.facultyID
    INNER JOIN
     user ON user.userID = faculty.userID
    INNER JOIN
     room ON room.roomID = class.roomID
    INNER JOIN
     building ON building.buildingID = room.buildingID
    INNER JOIN
     timeslot ON timeslot.timeSlotID = class.timeSlotID
    INNER JOIN
     period ON period.periodID =timeslot.periodID
    INNER JOIN
     day ON timeslot.dayID =day.dayID
    WHERE class.semesterID =:semester
    ORDER BY course.courseID ASC";
    $stmt = $connect->prepare($sql);
    $stmt->execute([':semester'=>$semesterID]);
    $sql2 ="SELECT * FROM `semesteryear` ORDER BY `semesterYearID` DESC";
    $stmt2=$connect->prepare($sql2);
    $stmt2->execute();
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
     <title>Master Schedule- Faculty</title>
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
                   <li><a href="classes.php" class="waves-effect">Classes<i class="material-icons">school</i></a></li>
                   <li><a href="masterschedule.php" class="waves-effect active">Master Schedule<i class="material-icons">event</i></a></li>
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
             <h2 class="section-title">Master Schedule - <?php echo $semesterID; ?></h2>
             <div class='col s12'>
               <div class='card hoverable'>
                 <table id ='defualt-table' class='row-border' cellspacing='0' width='100%'>
                   <thead>
                     <tr>
                       <th>CRN</th>
                       <th>Section</th>
                       <th>Course ID</th>
                       <th>Course Name</th>
                       <th>Professor</th>
                       <th>Building</th>
                       <th>Room</th>
                       <?php
                         if($semesterID=="FALL21" || $semesterID=="SPRING22")
                         {
                           echo '<th>Seats Available</th>';
                         }
                        ?>
                       <th>Start Time</th>
                       <th>End Time</th>
                       <th>Day</th>
                     </tr>
                   </thead>
                   <?php
                       while($row =$stmt->fetch(PDO::FETCH_ASSOC)){
                                   echo '<tr>';
                                   echo '<td>' . $row["CRN"] . '</td>';
                                   echo '<td>' . $row["section"] . '</td>';
                                   echo '<td>' . $row["courseID"] . '</td> ';
                                   echo '<td>' . $row["courseTitle"] . '</td>';
                                   echo '<td>' . $row["lastName"] . '</td>';
                                   echo '<td>' . $row["buildingName"] . '</td> ';
                                   echo '<td>' . $row["roomNumber"] . '</td>';
                                   if($semesterID=="FALL21" || $semesterID=="SPRING22")
                                   {
                                     echo '<td>' .$row["seatsAvailable"]. '</td>';
                                   }
                                   echo '<td>' . $row["startTime"] . '</td>';
                                   echo '<td>' . $row["endTime"] . '</td>';
                                   echo '<td>' . $row["weekday"] . '</td> ';
                                   //echo '<td>' . $row["seatsAvailable"] . '</td>';
                                   echo '</tr>';
                       }
                    ?>
                 </table>
               </div>
             </div>
             <div class="center col 4">
               <form method="POST">
                 <div class="col 8">
                   <select name="semester">
                     <option value="FALL21">--</option>
                     <?php
                       while($result=$stmt2->fetch(PDO::FETCH_ASSOC))
                       {
                         echo '<option value ="'.$result["semesterID"].'">'.$result["semesterID"].'</option>';
                       }
                      ?>
                   </select>
                 </div>
                 <div class="col 4">
                   <button class="btn waves-effect waves-light yellow darken-1" type="submit" name="action">Change
                      <i class="material-icons right">pin</i>
                    </button>
                 </div>
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
