<?php
  require "../db.php";
  session_start();
  if(!isset($_SESSION["username"])|| $_SESSION["rank"] !='Student'){
    header("location:/panel/log-in.php");
  }
  else
  {
    if(isset($_POST["semester"]))
    {
      $_SESSION["selectedSemester"]=$_POST["semester"];
      header("location:scripts/registerForSemester.php");
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
             <li class="bold waves-effect active"><a class="collapsible-header">Coruses<i class="material-icons chevron">chevron_left</i></a>
               <div class="collapsible-body">
                 <ul>
                   <li><a href="viewschedule.php" class="waves-effect">View Schedule<i class="material-icons">event</i></a></li>
                   <li><a href="register.php" class="waves-effect active">Register For a Course<i class="material-icons">how_to_reg</i></a></li>
                   </ul>
                 </div>
               </li>
             </ul>
             <ul class="collapsible collapsible-accordion">
               <li class="bold waves-effect"><a class="collapsible-header">Records<i class="material-icons chevron">chevron_left</i></a>
                 <div class="collapsible-body">
                   <ul>
                     <li><a href="viewdegreeaudit.php" class="waves-effect">View Degree Audit<i class="material-icons">dvr</i></a></li>
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
         <div class="nav-wrapper"><a href="#" class="brand-logo">Register For a Course</a><a href="#" data-target="sidenav-left" class="sidenav-trigger"><i class="material-icons">menu</i></a>
           <ul id="nav-mobile" class="right">
           </ul><a href="#!" data-target="sidenav-left" class="sidenav-trigger left"><i class="material-icons black-text">menu</i></a>
         </div>
       </nav>
       <main>
         <div class="container">
           <div class="row">
             <div class="col s12">
               <div class="col s12">
                 <h4>Register For a Course</h4>
                 <span><p>Here you can register for a course.</p></span>
               <div class="center col s12">
                 <h4>Select a Semester</h4>
                 <form method="POST">
                   <div class="col s6">
                     <span>Semester</span>
                     <select id="semester" name="semester">
                       <option value="FALL21">Fall 21</option>
                       <option value="SPRING22">Spring 22</option>
                     </select>
                     <label for="semester">Semester</label>
                   </div>
                   <div class="col s6">
                     <button class="btn waves-effect waves-light red darken-1" type="submit" name="action">Change
                        <i class="material-icons right">pin</i>
                      </button>
                   </div>
                 </form>
                </div>
                <div class="center col s12">
                </br>
                  <span><p>
                           <li class="center">You will <i class="red-text">NOT</i> be able to register for a course if the semester has passed.</li>
                           <li class="center">You will <i class="red-text">NOT</i> be able to register for a course if you have time conflicts with your current scheduling.</li>
                           <li class="center">You will <i class="red-text">NOT</i> be able to register for a course if you have a hold on your account.</li>
                           <li class="center">You will <i class="red-text">NOT</i> be able to register for a course if the registeration limit has passed. Only under CERTAIN conditions may you contact an Admin and they will be able to provide registeration for you after the registeration date.</li></p></span>
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
