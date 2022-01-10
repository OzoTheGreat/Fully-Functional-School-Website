<?php
  require '../../db.php';
  session_start();
  if(isset($_SESSION["username"])&& $_SESSION["rank"] =='Admin')
  {
    $_SESSION["created"]=FALSE;
    if(isset($_POST["adminemail"]) && isset($_POST["adminpassword"]) && isset($_POST["adminfirstname"])&& isset($_POST["adminlastname"]) && isset($_POST["adminDOB"]) && isset($_POST["adminstreet"])&& isset($_POST["admincity"]) && isset($_POST["adminstate"]) && isset($_POST["adminzip"])&& isset($_POST["adminphone"]))
    {
    $adminemail =$_POST["adminemail"];
    $adminpassword =$_POST["adminpassword"];
    $adminfirstname =$_POST["adminfirstname"];
    $adminlastname =$_POST["adminlastname"];
    $adminDOB =$_POST["adminDOB"];
    $adminstreet =$_POST["adminstreet"];
    $admincity =$_POST["admincity"];
    $adminstate =$_POST["adminstate"];
    $adminzip =$_POST["adminzip"];
    $adminphone =$_POST["adminphone"];
    $id = '90010'.rand(5110,9999);
    $id=(int)$id;
    $usertype ="Admin";
    $sql = 'INSERT INTO user (user.userID,user.firstName,user.lastName,user.DOB,user.streetAddress,user.city,user.state,user.postalCode,user.phoneNumber,user.userType) VALUES(:id, :adminfirstname, :adminlastname, :adminDOB, :adminstreet, :admincity, :adminstate, :adminzip, :adminphone, :usertype)';
    $statement= $connect->prepare($sql);
    if ($statement->execute([':id'=>$id,':adminfirstname'=>$adminfirstname,':adminlastname'=> $adminlastname,':adminDOB'=>$adminDOB,':adminstreet'=>$adminstreet,':admincity'=>$admincity,':adminstate'=>$adminstate,':adminzip'=>$adminzip,':adminphone'=>$adminphone,':usertype'=>$usertype]))
    {
      $sql ='INSERT INTO login (login.userID,login.username,login.password,login.userType) VALUES(:id,:adminemail,:adminpassword,:usertype)';
      $statement= $connect->prepare($sql);
      if ($statement->execute([':id'=>$id,':adminemail'=>$adminemail,':adminpassword'=>$adminpassword,':usertype'=>$usertype]))
      {
        $_SESSION["created"]=TRUE;
        header("Location: ../users.php");
      }
    }
  }if(isset($_POST["studentemail"]) && isset($_POST["studentpassword"]) && isset($_POST["studentfirstname"])&& isset($_POST["studentlastname"]) && isset($_POST["studentDOB"]) && isset($_POST["studentstreet"])&& isset($_POST["studentcity"]) && isset($_POST["studentstate"]) && isset($_POST["studentzip"])&& isset($_POST["studentphone"]))
  {
    $studentemail =$_POST["studentemail"];
    $studentpassword =$_POST["studentpassword"];
    $studentfirstname =$_POST["studentfirstname"];
    $studentlastname =$_POST["studentlastname"];
    $studentDOB =$_POST["studentDOB"];
    $studentstreet =$_POST["studentstreet"];
    $studentcity =$_POST["studentcity"];
    $studentstate =$_POST["studentstate"];
    $studentzip =(int)$_POST["studentzip"];
    $studentphone =$_POST["studentphone"];
    $id = '90010'.rand(5110,9999);
    $id =(int)$id;
    $usertype ="Student";
    $sql = 'INSERT INTO user (user.userID,user.firstName,user.lastName,user.DOB,user.streetAddress,user.city,user.state,user.postalCode,user.phoneNumber,user.userType) VALUES(:id, :studentfirstname, :studentlastname, :studentDOB, :studentstreet, :studentcity, :studentstate, :studentzip, :studentphone, :usertype)';
    $statement= $connect->prepare($sql);
    if ($statement->execute([':id'=>$id,':studentfirstname'=>$studentfirstname,':studentlastname'=> $studentlastname,':studentDOB'=>$studentDOB,':studentstreet'=>$studentstreet,':studentcity'=>$studentcity,':studentstate'=>$studentstate,':studentzip'=>$studentzip,':studentphone'=>$studentphone,':usertype'=>$usertype]))
    {
      $sql ='INSERT INTO login (login.userID,login.username,login.password,login.userType) VALUES(:id,:studentemail,:studentpassword,:usertype)';
      $statement= $connect->prepare($sql);
      if ($statement->execute([':id'=>$id,':studentemail'=>$studentemail,':studentpassword'=>$studentpassword,':usertype'=>$usertype]))
      {
        $_SESSION["created"]=TRUE;
        header("Location: ../users.php");
      }
    }

  }if(isset($_POST["facultyemail"]) && isset($_POST["facultypassword"]) && isset($_POST["facultyfirstname"])&& isset($_POST["facultylastname"]) && isset($_POST["facultyDOB"]) && isset($_POST["facultystreet"])&& isset($_POST["facultycity"]) && isset($_POST["facultystate"]) && isset($_POST["facultyzip"])&& isset($_POST["facultyphone"]))
  {
    $facultyemail =$_POST["facultyemail"];
    $facultypassword =$_POST["facultypassword"];
    $facultyfirstname =$_POST["facultyfirstname"];
    $facultylastname =$_POST["facultylastname"];
    $facultyDOB =$_POST["facultyDOB"];
    $facultystreet =$_POST["facultystreet"];
    $facultycity =$_POST["facultycity"];
    $facultystate =$_POST["facultystate"];
    $facultyzip =$_POST["facultyzip"];
    $facultyphone =$_POST["facultyphone"];
    $id = '90010'.rand(5110,9999);
    $usertype ="Faculty";
    $sql = 'INSERT INTO user (user.userID,user.firstName,user.lastName,user.DOB,user.streetAddress,user.city,user.state,user.postalCode,user.phoneNumber,user.userType) VALUES(:id, :facultyfirstname, :facultylastname, :facultyDOB, :facultystreet, :facultycity, :facultystate, :facultyzip, :facultyphone, :usertype)';
    $statement= $connect->prepare($sql);
    if ($statement->execute([':id'=>$id,':facultyfirstname'=>$facultyfirstname,':facultylastname'=> $facultylastname,':facultyDOB'=>$facultyDOB,':facultystreet'=>$facultystreet,':facultycity'=>$facultycity,':facultystate'=>$facultystate,':facultyzip'=>$facultyzip,':facultyphone'=>$facultyphone,':usertype'=>$usertype]))
    {
      $sql ='INSERT INTO login (login.userID,login.username,login.password,login.userType) VALUES(:id,:facultyemail,:facultypassword,:usertype)';
      $statement= $connect->prepare($sql);
      if ($statement->execute([':id'=>$id,':facultyemail'=>$facultyemail,':facultypassword'=>$facultypassword,':usertype'=>$usertype]))
      {
        $_SESSION["created"]=TRUE;
        header("Location: ../users.php");
      }
    }
  }if(isset($_POST["researcheremail"]) && isset($_POST["researcherpassword"]) && isset($_POST["researcherfirstname"])&& isset($_POST["researcherlastname"]) && isset($_POST["researcherDOB"]) && isset($_POST["researcherstreet"])&& isset($_POST["researchercity"]) && isset($_POST["researcherstate"]) && isset($_POST["researcherzip"])&& isset($_POST["researcherphone"]))
  {
    $researcheremail =$_POST["researcheremail"];
    $researcherpassword =$_POST["researcherpassword"];
    $researcherfirstname =$_POST["researcherfirstname"];
    $researcherlastname =$_POST["researcherlastname"];
    $researcherDOB =$_POST["researcherDOB"];
    $researcherstreet =$_POST["researcherstreet"];
    $researchercity =$_POST["researchercity"];
    $researcherstate =$_POST["researcherstate"];
    $researcherzip =$_POST["researcherzip"];
    $researcherphone =$_POST["researcherphone"];
    $id = '90010'.rand(5110,9999);
    $usertype ="Researcher";
    $sql = 'INSERT INTO user (user.userID,user.firstName,user.lastName,user.DOB,user.streetAddress,user.city,user.state,user.postalCode,user.phoneNumber,user.userType) VALUES(:id, :researcherfirstname, :researcherlastname, :researcherDOB, :researcherstreet, :researchercity, :researcherstate, :researcherzip, :researcherphone, :usertype)';
    $statement= $connect->prepare($sql);
    if ($statement->execute([':id'=>$id,':researcherfirstname'=>$researcherfirstname,':researcherlastname'=> $researcherlastname,':researcherDOB'=>$researcherDOB,':researcherstreet'=>$researcherstreet,':researchercity'=>$researchercity,':researcherstate'=>$researcherstate,':researcherzip'=>$researcherzip,':researcherphone'=>$researcherphone,':usertype'=>$usertype]))
    {
      $sql ='INSERT INTO login (login.userID,login.username,login.password,login.userType) VALUES(:id,:researcheremail,:researcherpassword,:usertype)';
      $statement= $connect->prepare($sql);
      if ($statement->execute([':id'=>$id,':researcheremail'=>$researcheremail,':researcherpassword'=>$researcherpassword,':usertype'=>$usertype]))
      {
        $_SESSION["created"]=TRUE;
        header("Location: ../users.php");
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
    <title>Create User - Admin</title>
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
                  <li><a href="searchfaculty.php?id=<?php echo $_SESSION["facultyID"]; ?>" class="waves-effect">Search Faculty<i class="material-icons">search</i></a></li>
                  <li><a href="viewcourses.php?id=<?php echo $_SESSION["facultyID"]; ?>" class="waves-effect">View Courses<i class="material-icons">dvr</i></a></li>
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
    <nav class="navbar nav-extended no-padding">
      <div class="nav-wrapper"><a href="#" class="brand-logo">Create a User</a><a href="#" data-target="sidenav-left" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul id="nav-mobile" class="right">
        </ul><a href="#!" data-target="sidenav-left" class="sidenav-trigger left"><i class="material-icons black-text">menu</i></a>
      </div>
    </nav>
    <main>
      <div class="section container">
        <div class="row">
          <div class="col s12 m12">
            <span class="settings-title">Create a User</span>
          </div>
        </div>
        <div class="row">
          <div class="col s12 m12">
            <div class="settings-group">
              <form method="POST">
              <div class="nav-content">
                <ul class="tabs grey lighten-3">
                  <li class="tab"><a href="#admin"class="grey-text">Admin</a></li>
                  <li class="tab"><a href="#faculty"class="orange-text darken-2">Faculty</a></li>
                  <li class="tab"><a href="#researcher"class="green-text darken-2">Researcher</a></li>
                  <li class="tab"><a href="#student"class="red-text">Student</a></li>
                </ul>
              </div>
              <div id ="admin">
                  <div class="collapsible-header">
                    <div class="col s12 m12">
                      <div class="col s4 m12">
                        <p class="flow-text"><i class="flow-text">Basic Information</i></p>
                      </div>
                      <div class="input-field col s6">
                        <input id="adminemail" type="text" name="adminemail" class="validate">
                        <label for="adminemail">Email</label>
                      </div>
                      <div class="input-field col s6">
                        <input id="adminpassword" type="text" name="adminpassword" class="validate">
                        <label for="adminpassword">Passowrd</label>
                      </div>
                      <div class="input-field col s4">
                        <input id="adminfirstname" type="text" name="adminfirstname" class="validate">
                        <label for="adminfirstname">First Name</label>
                      </div>
                      <div class="input-field col s4">
                        <input id="adminlastname" type="text" name="adminlastname" class="validate">
                        <label for="adminlastname">Last Name</label>
                      </div>
                      <div class="input-field col s4">
                        <input id="adminDOB" type="date" name="adminDOB" class="validate">
                        <label for="adminDOB">Date of Birth (MM/DD/YYYY)</label>
                      </div>
                    </div>
                  </div>
                  <div class="collapsible-header">
                    <div class="col s12 m12">
                      <div class="col s4 m12">
                        <p><i>Address</i></p>
                      </div>
                      <div class="input-field col s8">
                        <input id="adminstreet" type="text" name="adminstreet" class="validate">
                        <label for="adminstreet">Address</label>
                      </div>
                      <div class="input-field col s4">
                        <input id="admincity" type="text" name="admincity" class="validate">
                        <label for="admincity">City</label>
                      </div>
                      <div class="input-field col s4">
                        <input id="adminstate" type="text" name="adminstate"class="validate">
                        <label for="adminstate">State</label>
                      </div>
                      <div class="input-field col s4">
                        <input id="adminzip" type="number" name="adminzip"class="validate">
                        <label for="adminzip">Zip Code</label>
                      </div>
                      <div class="input-field col s4">
                        <input id="adminphone" type="tel" name="adminphone"class="validate">
                        <label for="phone">Phone</label>
                      </div>
                    </div>
                  </div>
                </div>
                <div id ="faculty">
                    <div class="collapsible-header">
                      <div class="col s12 m12">
                        <div class="col s4 m12">
                          <p class="flow-text"><i class="flow-text">Basic Information</i></p>
                        </div>
                        <div class="input-field col s6">
                          <input id="facultyemail" type="text" name="facultyemail" class="validate">
                          <label for="facultyemail">Email</label>
                        </div>
                        <div class="input-field col s6">
                          <input id="facultypassword" type="text" name="facultypassword" class="validate">
                          <label for="facultypassword">Passowrd</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="facultyfirstname" type="text" name="facultyfirstname" class="validate">
                          <label for="facultyfirstname">First Name</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="facultylastname" type="text" name="facultylastname" class="validate">
                          <label for="facultylastname">Last Name</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="facultyDOB" type="date" name="facultyDOB" class="validate">
                          <label for="facultyDOB">Date of Birth (MM/DD/YYYY)</label>
                        </div>
                      </div>
                    </div>
                    <div class="collapsible-header">
                      <div class="col s12 m12">
                        <div class="col s4 m12">
                          <p><i>Address</i></p>
                        </div>
                        <div class="input-field col s8">
                          <input id="facultystreet" type="text" name="facultystreet" class="validate">
                          <label for="facultystreet">Address</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="facultycity" type="text" name="facultycity" class="validate">
                          <label for="facultycity">City</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="facultystate" type="text" name="facultystate"class="validate">
                          <label for="facultystate">State</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="facultyzip" type="number" name="facultyzip"class="validate">
                          <label for="facultyzip">Zip Code</label>
                        </div>
                        <div class="input-field col s4">
                          <input id="facultyphone" type="tel" name="facultyphone"class="validate">
                          <label for="facultyphone">Phone</label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div id ="researcher">
                      <div class="collapsible-header">
                        <div class="col s12 m12">
                          <div class="col s4 m12">
                            <p class="flow-text"><i class="flow-text">Basic Information</i></p>
                          </div>
                          <div class="input-field col s6">
                            <input id="researcheremail" type="text" name="researcheremail" class="validate">
                            <label for="researcheremail">Email</label>
                          </div>
                          <div class="input-field col s6">
                            <input id="researcherpassword" type="text" name="researcherpassword" class="validate">
                            <label for="researcherpassword">Passowrd</label>
                          </div>
                          <div class="input-field col s4">
                            <input id="researcherfirstname" type="text" name="researcherfirstname" class="validate">
                            <label for="researcherfirstname">First Name</label>
                          </div>
                          <div class="input-field col s4">
                            <input id="researcherlastname" type="text" name="researcherlastname" class="validate">
                            <label for="researcherlastname">Last Name</label>
                          </div>
                          <div class="input-field col s4">
                            <input id="researcherDOB" type="date" name="researcherDOB" class="validate">
                            <label for="researcherDOB">Date of Birth (MM/DD/YYYY)</label>
                          </div>
                        </div>
                      </div>
                      <div class="collapsible-header">
                        <div class="col s12 m12">
                          <div class="col s4 m12">
                            <p><i>Address</i></p>
                          </div>
                          <div class="input-field col s8">
                            <input id="researcherstreet" type="text" name="researcherstreet" class="validate">
                            <label for="researcherstreet">Address</label>
                          </div>
                          <div class="input-field col s4">
                            <input id="researchercity" type="text" name="researchercity" class="validate">
                            <label for="researchercity">City</label>
                          </div>
                          <div class="input-field col s4">
                            <input id="researcherstate" type="text" name="researcherstate"class="validate">
                            <label for="researcherstate">State</label>
                          </div>
                          <div class="input-field col s4">
                            <input id="researcherzip" type="number" name="researcherzip"class="validate">
                            <label for="researcherzip">Zip Code</label>
                          </div>
                          <div class="input-field col s4">
                            <input id="researcherphone" type="tel" name="researcherphone"class="validate">
                            <label for="researcherphone">Phone</label>
                          </div>
                        </div>
                      </div>
                    </div>
                  <div id ="student">
                      <div class="collapsible-header">
                        <div class="col s12 m12">
                          <div class="col s4 m12">
                            <p class="flow-text"><i class="flow-text">Basic Information</i></p>
                          </div>
                          <div class="input-field col s6">
                            <input id="studentemail" type="text" name="studentemail" class="validate">
                            <label for="studentemail">Email</label>
                          </div>
                          <div class="input-field col s6">
                            <input id="studentpassword" type="text" name="studentpassword" class="validate">
                            <label for="studentpassword">Passowrd</label>
                          </div>
                          <div class="input-field col s4">
                            <input id="studentfirstname" type="text" name="studentfirstname" class="validate">
                            <label for="studentfirstname">First Name</label>
                          </div>
                          <div class="input-field col s4">
                            <input id="studentlastname" type="text" name="studentlastname" class="validate">
                            <label for="studentlastname">Last Name</label>
                          </div>
                          <div class="input-field col s4">
                            <input id="studentDOB" type="date"name="studentDOB" class="validate">
                            <label for="studentDOB">Date of Birth (MM/DD/YYYY)</label>
                          </div>
                        </div>
                      </div>
                      <div class="collapsible-header">
                        <div class="col s12 m12">
                          <div class="col s4 m12">
                            <p><i>Address</i></p>
                          </div>
                          <div class="input-field col s8">
                            <input id="studentstreet" type="text"name="studentstreet" class="validate">
                            <label for="studentstreet">S Address</label>
                          </div>
                          <div class="input-field col s4">
                            <input id="studentcity" type="text" name="studentcity" class="validate">
                            <label for="studentcity">City</label>
                          </div>
                          <div class="input-field col s4">
                            <input id="studentstate" type="text" name="studentstate"class="validate">
                            <label for="studentstate">State</label>
                          </div>
                          <div class="input-field col s4">
                            <input id="studentzip" type="number" name="studentzip"class="validate">
                            <label for="studentzip">Zip Code</label>
                          </div>
                          <div class="input-field col s4">
                            <input id="studentphone" type="tel" name="studentphone"class="validate">
                            <label for="studentphone">Phone</label>
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
