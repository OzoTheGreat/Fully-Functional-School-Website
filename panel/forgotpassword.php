<?php
  session_start();
  require 'db.php';

  if(isset($_POST["email"]))
  {
    $email = $_POST["email"];
    $sql = 'SELECT * FROM login INNER JOIN user ON login.userID =user.userID WHERE login.username ="'.$email.'"';
    $statement = $connect->prepare($sql);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);
    $fetchName =$row["firstName"].' '.$row["lastName"];
    $fetchEmail =$row["username"];
    $fetchPassword =$row["password"];
    if($email ==$fetchEmail)
    {
      $to ='lly70256@zwoho.com';
      $from ='From: lly70256@zwoho.com';
      $subject ='Password Reset For XYZ University';
      $message ='Hello '.$fetchName.', </br> It seems you have forgotten your password for XYZ University.Your password is: '.$fetchPassword.'';
      mail($to,$subject,$message,$from);
    }
    else
    {
      echo 'invalid userid';
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
     <title>Forgot Passowrd</title>
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
       <div class="navbar-fixed">
         <nav class="navbar white">
           <div class="nav-wrapper"><a href="#!" class="brand-logo grey-text text-darken-4">Forgot Password</a>
             <ul id="nav-mobile" class="right">
               <li class="hide-on-med-and-down"><a href="https://themes.materializecss.com/products/admin"></a></li>
             </ul><a href="#!" data-target="sidenav-left" class="sidenav-trigger left"><i class="material-icons black-text">menu</i></a>
           </div>
         </nav>
       </div>
       <ul id="sidenav-left" class="sidenav sidenav-fixed teal lighten-1">
         <li><a href="../index.html" class="logo-container">XYZ University<i class="material-icons left">spa</i></a></li>
         <li class="no-padding">
           <ul class="collapsible collapsible-accordion">
             <li class="bold waves-effect"><a class="collapsible-header">Courses<i class="material-icons chevron">chevron_left</i></a>
               <div class="collapsible-body">
                 <ul>
                   <li><a href="courses.php" class="waves-effect">Courses<i class="material-icons">school</i></a></li>
                   <li><a href="masterschedule.php" class="waves-effect">Master Schedule<i class="material-icons">event</i></a></li>
                 </ul>
               </div>
             </li>
             <li class="bold waves-effect"><a class="collapsible-header">Calendar<i class="material-icons chevron">chevron_left</i></a>
               <div class="collapsible-body">
                 <ul>
                   <li><a href="academiccal.php" class="waves-effect">Calendar<i class="material-icons">date_range</i></a></li>
                   <li><a href="timewindow.php" class="waves-effect">Time Windows<i class="material-icons">date_range</i></a></li>
                 </ul>
               </div>
             </li>
               <li class="bold waves-effect"><a class="collapsible-header">Major/Minors<i class="material-icons chevron">chevron_left</i></a>
                 <div class="collapsible-body">
                   <ul>
                     <li><a href="majors.php" class="waves-effect">Majors<i class="material-icons">school</i></a></li>
                     <li><a href="minors.php" class="waves-effect">Minors<i class="material-icons">history_edu</i></a></li>
                   </ul>
                 </div>
               </li>
               <li class="bold waves-effect"><a class="collapsible-header">Department/Building<i class="material-icons chevron">chevron_left</i></a>
                 <div class="collapsible-body">
                   <ul>
                     <li><a href="departments.php" class="waves-effect">Departments<i class="material-icons">groups</i></a></li>
                     <li><a href="buildings.php" class="waves-effect">Buildings<i class="material-icons">apartment</i></a></li>
                   </ul>
                 </div>
               </li>
             </li>
             <li class="bold waves-effect active"><a class="collapsible-header">Account<i class="material-icons chevron">chevron_left</i></a>
               <div class="collapsible-body">
                 <ul>
                   <li><a href="log-in.php" class="waves-effect active">Log In<i class="material-icons">person</i></a></li>
                 </ul>
               </div>
             </li>
           </ul>
         </li>
       </ul>
     </header>
     <main>
       <div class="container">
         <div class="row">
           <div class="col s12">
             <div class="center">
             </br>
             </br>
             </br>
             </br>
             </br>
             </br>
             </br>
             </br>
             </br>
               <span>If you have forgotten your password, fill out the form below to have instructions sent to your email</span>
               <form method="POST">
                 <div class="input-field col s6 offset-s3">
                   <input id="email" type="email" name="email" class="validate">
                   <label for="email">Email</label>
                   <button class="btn waves-effect waves-light teal darken-1" type="submit" name="action">Reset
                      <i class="material-icons right"></i>
                    </button>
                 </div>
               </form>
             </div>
           </div>
          </div>
        </div>


     </main>
         <!-- Scripts -->
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
         <script src="js/page-scripts/table-custom-elements.js"></script>
         <script src="js/init.js"></script>
       </body>
     </html>
