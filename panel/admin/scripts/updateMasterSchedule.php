<?php
  session_start();
  require '../../db.php';
  $id = $_GET['id'];
  if(isset($_SESSION["username"])&& $_SESSION["rank"] =='Admin')
  {
    $sql = 'SELECT * FROM class INNER JOIN timeslot ON class.timeslotID = timeslot.timeSlotID WHERE CRN = :id';
    $statement = $connect->prepare($sql);
    $statement->execute([':id' => $id ]);
    $class =$statement->fetch(PDO::FETCH_ASSOC);
    if(isset($_POST["newcourseid"]) && isset($_POST["newprofessor"]) && isset($_POST["newsection"])&& isset($_POST["newroom"])&& isset($_POST["newtime"])&& isset($_POST["newday"])&& isset($_POST["newseats"]))
    {
      $newcourseid = $_POST["newcourseid"];
      $newprofessor = $_POST["newprofessor"];
      $newsection = $_POST["newsection"];
      $newroom = $_POST["newroom"];
      $newtime = $_POST["newtime"];
      $newday = $_POST["newday"];
      $newseats = $_POST["newseats"];

      $sql ='UPDATE class SET class.roomID=:room, class.seatsAvailable=:seats, class.facultyID =:faculty, class.section =:section WHERE class.CRN =:CRN';
      $statement =$connect->prepare($sql);
      if($statement->execute([':CRN'=>$id,
                              ':room'=>$newroom,
                              ':seats'=>$newseats,
                              ':faculty'=>$newprofessor,
                              ':section'=>$newsection]))
        {
          $sql ='UPDATE timeslot SET timeslot.periodID=:period, timeslot.dayID=:day WHERE timeslot.timeslotID= :timeslot';
          $statement =$connect->prepare($sql);
          if($statement->execute([':period'=>$newtime,
                                  ':day'=>$newday,
                                  ':timeslot'=>$class->timeslotID]))
              {
                header("Location: ../masterschedule.php");
              }
        }
    }

  }else{
    header("location:/panel/log-in.php");
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
     <title>Update Class  <?php echo $id;?> - Admin</title>
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
           <li class="bold waves-effect active"><a class="collapsible-header">Admin Panel<i class="material-icons chevron">chevron_left</i></a>
             <div class="collapsible-body">
               <ul>
                 <li><a href="../users.php" class="waves-effect">All Users<i class="material-icons">person</i></a></li>
                 <li><a href="../masterschedule.php" class="waves-effect active">Schedule<i class="material-icons">event</i></a></li>
                 <li><a href="../studentholds.php" class="waves-effect">Student Holds<i class="material-icons">warning</i></a></li>
                 </ul>
               </div>
             </li>
             <ul class="collapsible collapsible-accordion">
               <li class="bold waves-effect"><a class="collapsible-header">Student Records<i class="material-icons chevron">chevron_left</i></a>
                 <div class="collapsible-body">
                   <ul>
                     <li><a href="../searchstudent.php" class="waves-effect">Search Student<i class="material-icons">search</i></a></li>
                     <li><a href="../viewschedule.php?id=<?php echo $_SESSION["studentID"]; ?>" class="waves-effect">View Schedule<i class="material-icons">event</i></a></li>
                     <li><a href="../viewdegreeaudit.php?id=<?php echo $_SESSION["studentID"]; ?>" class="waves-effect">View Degree Audit<i class="material-icons">dvr</i></a></li>
                     <li><a href="../grades.php?id=<?php echo $_SESSION["studentID"]; ?>" class="waves-effect">Grades<i class="material-icons">grading</i></a></li>
                     <li><a href="../transcript.php?id=<?php echo $_SESSION["studentID"]; ?>" class="waves-effect">Transcript<i class="material-icons">file_copy</i></a></li>
                     <li><a href="../changemm.php?id=<?php echo $_SESSION["studentID"]; ?>" class="waves-effect">Change Major/Minor<i class="material-icons">edit</i></a></li>
                     <li><a href="../register.php?id=<?php echo $_SESSION["studentID"]; ?>" class="waves-effect">Add Course<i class="material-icons">add</i></a></li>
                   </ul>
                 </div>
               </li>
             </ul>
             <li class="bold waves-effect"><a class="collapsible-header">Faculty<i class="material-icons chevron">chevron_left</i></a>
               <div class="collapsible-body">
                 <ul>
                   <li><a href="../searchfaculty.php?id=<?php echo $_SESSION["facultyID"]; ?>" class="waves-effect">Search Faculty<i class="material-icons">search</i></a></li>
                   <li><a href="../viewcourses.php?id=<?php echo $_SESSION["facultyID"]; ?>" class="waves-effect">View Courses<i class="material-icons">dvr</i></a></li>
                   </ul>
                 </div>
               </li>
           <li class="bold waves-effect"><a class="collapsible-header">Account<i class="material-icons chevron">chevron_left</i></a>
             <div class="collapsible-body">
               <ul>
                 <li><a href="../profile.php" class="waves-effect"><?php echo $_SESSION["name"];?><i class="material-icons">person</i></a></li>
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
       <div class="section container">
         <div class="row">
           <div class="col s12 m12">
             <span class="settings-title">Edit Class <?php echo $id;?></span>
             <p>Here you can edit a class</p>
           </div>
           <div class="row">
             <div class="col s12 m12">
               <div class="settings-group">
                 <form method="POST">
                   <div id="new">
                     <div class="collapsible-header">
                       <div class="col s12 m12">
                         <div class="col s4 m12">
                           <p><i>Class Information</i></p>
                         </div>
                         <div class="input-field col s8">
                           <select name="newcourseid" id="newcourseid">
                             <?php
                             $sql = ("SELECT * FROM course INNER JOIN class ON class.courseID = course.courseID WHERE class.CRN = :CRN");
                             $statement = $connect->prepare($sql);
                             $statement->execute([':CRN' => $id]);
                             while($row =$statement->fetch(PDO::FETCH_ASSOC)){
                                 echo '<option value ="'.$row["courseID"].'">'.$row["courseTitle"].'  - '.$row["courseID"].'</option>';
                             }
                              ?>
                           </select>
                           <label for="newcourseid">Course</label>
                         </div>
                         <div class="input-field col s2">
                           <select name="newprofessor" id ="newprofessor">
                             <option>--</option>
                             <?php
                               $sql = ("SELECT * FROM user INNER JOIN faculty ON user.userID = faculty.userID WHERE user.userType ='Faculty' ORDER BY user.lastName ASC");
                               $statement = $connect->prepare($sql);
                               $statement->execute();
                               while($row =$statement->fetch(PDO::FETCH_ASSOC)){
                                 if($row["firstName"] !="" && $row["lastName"]!== "")
                                 {
                                   echo '<option value ="'.$row["facultyID"].'">'.$row["lastName"].', '.$row["firstName"].'</option>';
                                 }
                               }
                             ?>
                           </select>
                           <label for="newprofessor">Professor</label>
                         </div>
                         <div class="input-field col s2">
                           <input id="newsection" type="number" name="newsection" class="validate">
                           <label for="newsection">Section #</label>
                        </div>
                        <div class="input-field col s4">
                          <select name="newroom" id ="newroom">
                            <option>--</option>
                            <?php
                              $sql = ("SELECT * FROM room INNER JOIN building WHERE room.buildingID = building.buildingID");
                              $statement = $connect->prepare($sql);
                              $statement->execute();
                              while($row =$statement->fetch(PDO::FETCH_ASSOC))
                              {
                                  echo '<option value ="'.$row["roomID"].'">'.$row["roomNumber"].' - '.$row["buildingName"].'</option>';
                              }
                            ?>
                          </select>
                          <label for="newroom">Room</label>
                        </div>
                        <div class="input-field col s4">
                          <select name="newtime" id ="newtime">
                            <option>--</option>
                            <?php
                              $sql = ("SELECT * FROM period");
                              $statement = $connect->prepare($sql);
                              $statement->execute();
                              while($row =$statement->fetch(PDO::FETCH_ASSOC))
                              {
                                  echo '<option value ="'.$row["periodID"].'"> Start: '.$row["startTime"].' End: '.$row["endTime"].'</option>';
                              }
                            ?>
                          </select>
                          <label for="newtime">Time Slot</label>
                        </div>
                        <div class="input-field col s2" disabled>
                          <select name="newday" id ="newday">
                            <option>--</option>
                            <?php
                              $sql = ("SELECT * FROM day");
                              $statement = $connect->prepare($sql);
                              $statement->execute();
                              while($row =$statement->fetch(PDO::FETCH_ASSOC))
                              {
                                  echo '<option value ="'.$row["dayID"].'">'.$row["weekday"].'</option>';
                              }
                            ?>
                          </select>
                          <label for="newday">Day</label>
                        </div>
                        <div class="input-field col s2">
                          <input id="newseats" type="number" name="newseats" class="validate">
                          <label for="newseats">Seats Available</label>
                        </div>
                       </div>
                     </div>

                   </div>
              </div>
              <button class="btn waves-effect waves-light grey darken-1" type="submit" name="action">Update
                 <i class="material-icons right">edit</i>
               </button>
               </form>
            </div>
         </div>
       </div>
     </main>
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
