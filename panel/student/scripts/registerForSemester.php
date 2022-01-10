<?php
  require "../../db.php";
  session_start();
  if(!isset($_SESSION["username"])|| $_SESSION["rank"] !='Student'){
    header("location:/panel/log-in.php");
  }
  else
  {
    $sql ="SELECT * FROM class
    INNER JOIN
     course ON course.courseID = class.courseID
    INNER JOIN
      dept ON course.departmentID = dept.departmentID
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
    $stmt->execute([':semester'=>$_SESSION["selectedSemester"]]);
    $query ='SELECT * FROM course INNER JOIN class ON class.courseID = course.courseID INNER JOIN enrollment ON class.CRN = enrollment.CRN INNER JOIN faculty ON class.facultyID = faculty.facultyID INNER JOIN user ON faculty.userID = user.userID INNER JOIN room ON class.roomID = room.roomID INNER JOIN building ON room.buildingID= building.buildingID INNER JOIN timeslot ON class.timeslotID =timeslot.timeslotID INNER JOIN period ON timeslot.periodID = period.periodID INNER JOIN day ON timeslot.dayID = day.dayID WHERE enrollment.studentID =:studentID AND class.semesterID =:semester';
    $statement = $connect->prepare($query);
    $statement->execute([':studentID'=>$_SESSION["studentID"],':semester'=>$_SESSION["selectedSemester"]]);
    $query1 ='SELECT * FROM course INNER JOIN class ON class.courseID = course.courseID INNER JOIN enrollment ON class.CRN = enrollment.CRN INNER JOIN faculty ON class.facultyID = faculty.facultyID INNER JOIN user ON faculty.userID = user.userID INNER JOIN room ON class.roomID = room.roomID INNER JOIN building ON room.buildingID= building.buildingID INNER JOIN timeslot ON class.timeslotID =timeslot.timeslotID INNER JOIN period ON timeslot.periodID = period.periodID INNER JOIN day ON timeslot.dayID = day.dayID WHERE enrollment.studentID =:studentID AND class.semesterID =:semester';
    $statement1 = $connect->prepare($query1);
    $statement1->execute([':studentID'=>$_SESSION["studentID"],':semester'=>$_SESSION["selectedSemester"]]);
    $currentCRN =[];
    $currentTime=[];
    $currentCourses=[];
    while($alreadyRegistered =$statement1->fetch(PDO::FETCH_ASSOC))
    {
      $currentCRN[] .=$alreadyRegistered["CRN"];
      $currentTime[] .=$alreadyRegistered["periodID"]. ' ' .$alreadyRegistered["dayID"];
      $currentCourses[].=$alreadyRegistered["courseID"];
    }
    $studenthistorySQL ='SELECT * FROM course INNER JOIN studenthistory ON course.courseID = studenthistory.courseID WHERE studenthistory.studentID ="'.$_SESSION["studentID"].'"';
    $historyStmt = $connect->prepare($studenthistorySQL);
    $historyStmt->execute();
    $studenthistory=[];
    while($history =$historyStmt->fetch(PDO::FETCH_ASSOC))
    {
      $studenthistory[] .=$history["courseID"];
    }
    $addDropSQL ='SELECT * FROM timewindow WHERE timewindow.semesterID =:semesterID';
    $addDropStatement = $connect->prepare($addDropSQL);
    $addDropStatement->execute([':semesterID'=>$_SESSION["selectedSemester"]]);
    $addDrop = $addDropStatement->fetch(PDO::FETCH_ASSOC);

    $checkPrereqSQL ="SELECT * FROM prerequisite";
    $prereqStatement =$connect->prepare($checkPrereqSQL);
    $prereqStatement->execute();

    $regCourseID =[];
    $courseID =[];
    while($prereqs=$prereqStatement->fetch(PDO::FETCH_ASSOC))
    {
      $regCourseID[] .=$prereqs["regCourseID"];
      $courseID[] .=$prereqs["courseID"];
    }
    $checkFullSQL = 'SELECT COUNT(*) FROM fulltimeundergrad WHERE fulltimeundergrad.studentID="'.$_SESSION["studentID"].'"';
    $fullStatement = $connect->prepare($checkFullSQL);
    $fullStatement->execute();
    $isFullTime =$fullStatement->fetch(PDO::FETCH_ASSOC);

    $checkPartSQL ='SELECT COUNT(*) FROM parttimeundergrad WHERE parttimeundergrad.studentID ="'.$_SESSION['studentID'].'"';
    $partStatement =$connect->prepare($checkPartSQL);
    $partStatement->execute();
    $isPartTime =$partStatement->fetch(PDO::FETCH_ASSOC);

    if($isFullTime["COUNT(*)"]==1)
    {
      $maxCredits =16;
      $status ="Full Time";
    }
    elseif($isPartTime["COUNT(*)"]==1)
    {
      $status ="Part Time";
      $maxCredits =8;
    }else
    {
      $status ="Graduate";
      $maxCredits =16;
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
       <title>Schedule - Student</title>
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
         <ul id="sidenav-left" class="sidenav sidenav-fixed red">
         <li><a href="../../index.html" class="logo-container">XYZ University<i class="material-icons left">spa</i></a></li>
         <li class="no-padding">
           <ul class="collapsible collapsible-accordion">
             <li class="bold waves-effect active"><a class="collapsible-header">Coruses<i class="material-icons chevron">chevron_left</i></a>
               <div class="collapsible-body">
                 <ul>
                   <li><a href="../viewschedule.php" class="waves-effect">View Schedule<i class="material-icons">event</i></a></li>
                   <li><a href="../register.php" class="waves-effect active">Register For a Course<i class="material-icons">how_to_reg</i></a></li>
                   </ul>
                 </div>
               </li>
             </ul>
             <ul class="collapsible collapsible-accordion">
               <li class="bold waves-effect"><a class="collapsible-header">Records<i class="material-icons chevron">chevron_left</i></a>
                 <div class="collapsible-body">
                   <ul>
                     <li><a href="../viewdegreeaudit.php" class="waves-effect">View Degree Audit<i class="material-icons">dvr</i></a></li>
                     <li><a href="../grades.php" class="waves-effect">Grades<i class="material-icons">grading</i></a></li>
                     <li><a href="../transcript.php" class="waves-effect">Transcript<i class="material-icons">file_copy</i></a></li>
                     <li><a href="../attendance.php" class="waves-effect">Attendance<i class="material-icons">class</i></a></li>
                     </ul>
                   </div>
                 </li>
               </ul>
           <ul class="collapsible collapsible-accordion">
             <li class="bold waves-effect"><a class="collapsible-header">Account<i class="material-icons chevron">chevron_left</i></a>
               <div class="collapsible-body">
                 <ul>
                   <li><a href="../profile.php" class="waves-effect"><?php echo $_SESSION["name"]; ?><i class="material-icons">person</i></a></li>
                   <li><a href="../changemm.php" class="waves-effect ">Change Major/Minor<i class="material-icons">edit</i></a></li>
                   <li><a href="../../logout.php" class="waves-effect">Log Out<i class="material-icons">logout</i></a></li>
                   </ul>
                 </div>
               </li>
             </ul>
           </li>
         </ul>
       </header>
       <nav class="navbar nav-extended no-padding">
         <div class="nav-wrapper"><a href="#" class="brand-logo">Register For a Course</a><a href="#" data-target="sidenav-left" class="sidenav-trigger"><i class="material-icons">menu</i></a>
           <ul id="nav-mobile" class="right">
           </ul><a href="#!" data-target="sidenav-left" class="sidenav-trigger left"><i class="material-icons black-text">menu</i></a>
         </div>
       </nav>
       <main>
         <div class="container">
           <div class="row">
             <div class="col s12">
               <h4 class="section-title">Register For a Course - <?php echo $_SESSION["selectedSemester"]; ?></h4>
               <span><p>You can add courses from this selection</p></span>
               <?php
                  echo '<div class="col s12 center">
                    <span><p>You are a '.$status.' Student and may only register for '.$maxCredits.' Credits per semester</p></span>
                  </div>';
                  if($_SESSION["hold"]===true)
                  {
                    echo '<div class="col s12 center">
                      <span><p class="red-text">You have a hold on your account. You will NOT be able to register for classes at this time. For more information about your hold, please visit <a href="../profile.php">Profile</a></p></span>
                    </div>';
                  }
                  if($addDrop["canAdd"]==0)
                  {
                    echo '<div class="col s12 center">
                      <span><p class="red-text">You cannot Add a course due to the withdrawl date being passed. <i>'.$addDrop["registrationTimeLimit"].'</i></p></span>
                    </div>';

                  }
                  if($addDrop["canDrop"]==0)
                  {
                    echo '<div class="col s12 center">
                      <span><p class="red-text">You cannot Drop a course due to the withdrawl date being passed. <i>'.$addDrop["dropCourseTimeLimit"].'</i></p></span>
                    </div>';

                  }

                ?>
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
                         <th>Department</th>
                         <th>Room</th>
                         <th>Seats Available</th>
                         <th>Start Time</th>
                         <th>End Time</th>
                         <th>Day</th>
                         <?php
                         if($addDrop["canAdd"]==1)
                         {
                           if($_SESSION["hold"]===false)
                           {
                             echo '<th>Add Course</th>';
                           }
                         }
                          ?>
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
                                     echo '<td>' . $row["department"] . '</td> ';
                                     echo '<td>' . $row["roomNumber"] . '</td>';
                                     echo '<td>' . $row["seatsAvailable"] . '</td>';
                                     echo '<td>' . $row["startTime"] . '</td>';
                                     echo '<td>' . $row["endTime"] . '</td>';
                                     echo '<td>' . $row["weekday"] . '</td> ';
                                     //add logic for add/drop course (such as time window,prereq, holds, time conflicts,seats available...make sure to -1 from seats)
                                     if($addDrop["canAdd"]==1)
                                     {
                                       if($_SESSION["hold"]===false)
                                       {
                                         $timeslot = $row["periodID"]. ' ' .$row["dayID"];
                                         $course =$row["courseID"];
                                         if($row["seatsAvailable"]<=0)
                                         {
                                           echo '<td class="red-text">No Seats</td>';
                                         }
                                         elseif($maxCredits==$_SESSION["credits"])
                                         {
                                           echo '<td class="red-text">Max Credits</td>';
                                         }
                                         elseif(in_array($timeslot, $currentTime))
                                         {
                                           echo '<td class="red-text">Time Conflict</td>';
                                         }
                                         elseif(in_array($course, $regCourseID))
                                         {
                                           if(!in_array($courseID,$studenthistory))
                                           {
                                             echo '<td class="red-text">Missing Prerequisite <a href="../../checkPrerequisites.php?id='.$row["courseID"].'">(?)</a></td>';
                                           }
                                         }

                                         else
                                         {
                                           echo '<td><a href="addCourse.php?id='.$row["CRN"].'"class="waves-effect waves-light btn-small green lighten-1">add<i class="right material-icons">add</i></a></td>';
                                         }
                                       }
                                     }
                                     echo '</tr>';
                         }
                      ?>
                   </table>
                 </div>
                 <h4 class="center"><?php echo $_SESSION["name"];?>'s Schedule For <?php echo $_SESSION["selectedSemester"];?></h4>
                 <span><p>You can drop courses from this selection</p></span>
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
                         <th>Start Time</th>
                         <th>End Time</th>
                         <th>Day</th>
                         <?php
                            if($addDrop["canDrop"]==1)
                            {
                              echo '<th>Drop</th>';
                            }?>

                       </tr>
                     </thead>
                     <?php
                      while($rows =$statement->fetch(PDO::FETCH_ASSOC))
                      {
                        echo '<tr>';
                        echo '<td>' . $rows["CRN"] . '</td>';
                        echo '<td>' . $rows["section"] . '</td>';
                        echo '<td>' . $rows["courseID"] . '</td> ';
                        echo '<td>' . $rows["courseTitle"] . '</td>';
                        echo '<td>' . $rows["lastName"] . '</td>';
                        echo '<td>' . $rows["buildingName"] . '</td> ';
                        echo '<td>' . $rows["roomNumber"] . '</td>';
                        echo '<td>' . $rows["startTime"] . '</td>';
                        echo '<td>' . $rows["endTime"] . '</td>';
                        echo '<td>' . $rows["weekday"] . '</td> ';
                        //add logic for drop (only time window...make sure to add 1 to seats)
                        if($addDrop["canDrop"]==1){
                          echo '<td><a href="dropCourse.php?id='.$rows["CRN"].'"class="waves-effect waves-light btn-small red lighten-1">drop<i class="right material-icons">remove</i></a></td>';
                        }
                        echo '</tr>';
                      }
                     ?>
                   </table>
               </div>
             </div>
           </div>
         </div>
       </main><!-- Scripts -->
       <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
       <script src="../js/materialize.min.js"></script>
       <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.19.2/moment.min.js"></script>

       <!-- External libraries -->

       <!-- jqvmap -->
       <script type="text/javascript" src="../js/jqvmap/jquery.vmap.min.js"></script>
       <script type="text/javascript" src="../js/jqvmap/jquery.vmap.world.js" charset="utf-8"></script>
       <script type="text/javascript" src="../js/jqvmap/jquery.vmap.sampledata.js"></script>

       <!-- ChartJS -->
       <script type="text/javascript" src="../js/Chart.js"></script>
       <script type="text/javascript" src="../js/Chart.Financial.js"></script>


       <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.7.0/fullcalendar.min.js"></script>
       <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.16/datatables.min.js"></script>
       <script src="../js/imagesloaded.pkgd.min.js"></script>
       <script src="../js/masonry.pkgd.min.js"></script>


       <!-- Initialization script -->
       <script src="../js/admin.js"></script>
           <script src="../js/init.js"></script>
         </body>
       </html>
