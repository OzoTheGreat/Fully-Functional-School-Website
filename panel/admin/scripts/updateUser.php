<?php
session_start();
require '../../db.php';
$id = $_GET['id'];
$sql = 'SELECT login.username,login.password,user.firstName, user.lastName, user.DOB, user.streetAddress, user.city, user.state, user.postalCode, user.phoneNumber FROM login , user WHERE login.userID =:id AND user.userID=:id';
$statement = $connect->prepare($sql);
$statement->execute([':id' => $id ]);
$person = $statement->fetch(PDO::FETCH_OBJ);
if (isset ($_POST['email'])  && isset($_POST['password']) && isset ($_POST['firstname'])  && isset($_POST['lastname']) && isset ($_POST['DOB'])  && isset($_POST['street']) && isset ($_POST['city'])  && isset($_POST['state']) && isset ($_POST['zip'])  && isset($_POST['phone'])){
  $email = $_POST['email'];
  $password = $_POST['password'];
  $firstname = $_POST['firstname'];
  $lastname = $_POST['lastname'];
  $DOB = $_POST['DOB'];
  $street = $_POST['street'];
  $city = $_POST['city'];
  $state = $_POST['state'];
  $zip = $_POST['zip'];
  $phone = $_POST['phone'];

  $sql = 'UPDATE login SET login.username=:email, login.password=:password WHERE login.userID=:id';
  $statement = $connect->prepare($sql);
  if ($statement->execute([':email' => $email, ':password' => $password, ':id' =>$id])) {
    $sql ='UPDATE user SET user.firstName=:firstname, user.lastName=:lastname, user.DOB=:DOB,user.streetAddress=:street,user.city=:city,user.state=:state,user.postalCode=:zip,user.phoneNumber=:phone WHERE user.userID =:id';
    $statement = $connect->prepare($sql);
    if ($statement->execute([':firstname'=> $firstname,':lastname'=> $lastname,':DOB'=> $DOB,':street'=> $street,':city'=> $city,':state'=> $state,':zip'=> $zip,':phone'=> $phone, ':id'=>$id]))
    {
      header("Location: ../users.php");
    }
  }
}
if(isset($_SESSION["username"])&& $_SESSION["rank"] =='Admin'){
  print'
 <!DOCTYPE html>
 <html lang="en">
   <head>
     <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="msapplication-tap-highlight" content="no">
     <meta name="description" content="">
     <title>Edit User - Admin</title>
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
                 <li><a href="../users.php" class="waves-effect active">All Users<i class="material-icons">person</i></a></li>
                 <li><a href="../masterschedule.php" class="waves-effect">Schedule<i class="material-icons">event</i></a></li>
                 <li><a href="../studentholds.php" class="waves-effect">Student Holds<i class="material-icons">warning</i></a></li>
                 </ul>
               </div>
             </li>
             <ul class="collapsible collapsible-accordion">
               <li class="bold waves-effect"><a class="collapsible-header">Student Records<i class="material-icons chevron">chevron_left</i></a>
                 <div class="collapsible-body">
                   <ul>
                     <li><a href="../searchstudent.php" class="waves-effect">Search Student<i class="material-icons">search</i></a></li>
                     <li><a href="../viewschedule.php?id='.$_SESSION["studentID"].'" class="waves-effect">View Schedule<i class="material-icons">event</i></a></li>
                     <li><a href="../viewdegreeaudit.php?id='.$_SESSION["studentID"].'" class="waves-effect">View Degree Audit<i class="material-icons">dvr</i></a></li>
                     <li><a href="../grades.php?id='.$_SESSION["studentID"].'" class="waves-effect">Grades<i class="material-icons">grading</i></a></li>
                     <li><a href="../transcript.php?id='.$_SESSION["studentID"].'" class="waves-effect">Transcript<i class="material-icons">file_copy</i></a></li>
                     <li><a href="../changemm.php?id='.$_SESSION["studentID"].'" class="waves-effect">Change Major/Minor<i class="material-icons">edit</i></a></li>
                     <li><a href="../register.php?id='.$_SESSION["studentID"].'" class="waves-effect">Add Course<i class="material-icons">add</i></a></li>
                   </ul>
                 </div>
               </li>
             </ul>
             <li class="bold waves-effect"><a class="collapsible-header">Faculty<i class="material-icons chevron">chevron_left</i></a>
               <div class="collapsible-body">
                 <ul>
                   <li><a href="../searchfaculty.php?id='.$_SESSION["facultyID"].'" class="waves-effect">Search Faculty<i class="material-icons">search</i></a></li>
                   <li><a href="../viewcourses.php?id='.$_SESSION["facultyID"].'" class="waves-effect">View Courses<i class="material-icons">dvr</i></a></li>
                   </ul>
                 </div>
               </li>
           <li class="bold waves-effect"><a class="collapsible-header">Account<i class="material-icons chevron">chevron_left</i></a>
             <div class="collapsible-body">
               <ul>
                 <li><a href="../profile.php" class="waves-effect">'.$_SESSION["name"].'<i class="material-icons">person</i></a></li>
                 <li><a href="../logout.php" class="waves-effect">Log Out<i class="material-icons">logout</i></a></li>
                 </ul>
               </div>
             </li>
           </ul>
         </li>
       </ul>
     </header>
     <nav class="navbar nav-extended no-padding">
       <div class="nav-wrapper"><a href="#" class="brand-logo">Edit User</a><a href="#" data-target="sidenav-left" class="sidenav-trigger"><i class="material-icons">menu</i></a>
         <ul id="nav-mobile" class="right">
         </ul><a href="#!" data-target="sidenav-left" class="sidenav-trigger left"><i class="material-icons black-text">menu</i></a>
       </div>
     </nav>
     <main>
       <div class="section container">
         <div class="row">
           <div class="col s12 m12">
             <span class="settings-title">Edit User - '.$person->firstName. ' ' .$person->lastName.'</span>
           </div>
         </div>
         <div class="row">
           <div class="col s12 m12">
             <div class="settings-group">
                   <div class="collapsible-header">
                     <div class="col s12 m12">
                       <div class="col s4 m12">
                         <p class="flow-text"><i class="flow-text">Basic Information</i></p>
                       </div>
                       <form method="POST">
                       <div class="input-field col s6">
                         <input id="email" type="text" value="'.$person->username.'" name="email" class="validate">
                         <label for="email">Email</label>
                       </div>
                       <div class="input-field col s6">
                         <input id="password" type="text" value="'.$person->password.'" name="password" class="validate">
                         <label for="password">Passowrd</label>
                       </div>
                       <div class="input-field col s4">
                         <input id="firstname" type="text"value="'.$person->firstName.'" name="firstname" class="validate">
                         <label for="firstname">First Name</label>
                       </div>
                       <div class="input-field col s4">
                         <input id="lastname" type="text"value="'.$person->lastName.'" name="lastname" class="validate">
                         <label for="lastname">Last Name</label>
                       </div>
                       <div class="input-field col s4">
                         <input id="DOB" type="text"value="'.$person->DOB.'" name="DOB" class="validate">
                         <label for="DOB">Date of Birth (MM/DD/YYYY)</label>
                       </div>
                     </div>
                   </div>
                   <div class="collapsible-header">
                     <div class="col s12 m12">
                       <div class="col s4 m12">
                         <p><i>Address</i></p>
                       </div>
                       <div class="input-field col s8">
                         <input id="street" type="text"value="'.$person->streetAddress.'" name="street" class="validate">
                         <label for="street">Address</label>
                       </div>
                       <div class="input-field col s4">
                         <input id="city" type="text"value="'.$person->city.'" name="city" class="validate">
                         <label for="city">City</label>
                       </div>
                       <div class="input-field col s4">
                         <input id="state" type="text" value="'.$person->state.'" name="state"class="validate">
                         <label for="state">State</label>
                       </div>
                       <div class="input-field col s4">
                         <input id="zip" type="text" value="'.$person->postalCode.'" name="zip"class="validate">
                         <label for="zip">Zip Code</label>
                       </div>
                       <div class="input-field col s4">
                         <input id="phone" type="text" value="'.$person->phoneNumber.'" name="phone"class="validate">
                         <label for="phone">Phone</label>
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
';
}else{
  header("location:/panel/log-in.php");
}
