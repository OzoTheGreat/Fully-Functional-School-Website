<?php
  require "../db.php";
  session_start();
    $query = 'SELECT user.*, login.userID, login.username FROM `login`INNER JOIN user ON user.userID ='.$_SESSION["id"].' WHERE login.userID = user.userID';
    $statement = $connect->prepare($query);
    $statement->execute();
    $result = $statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION["name"] = $result["firstName"].' '.$result["lastName"];
    $query ='SELECT * FROM student WHERE student.userID = '.$_SESSION["id"].'';
    $statement = $connect->prepare($query);
    $statement->execute();
    $result1 =$statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION["studentID"] = $result1["studentID"];
    $query ='SELECT user.firstName, user.lastName FROM advisor INNER JOIN faculty ON advisor.facultyID = faculty.facultyID INNER JOIN user ON faculty.userID = user.userID WHERE advisor.studentID = "'.$_SESSION["studentID"].'"';
    $statement = $connect->prepare($query);
    $statement->execute();
    $result2 =$statement->fetch(PDO::FETCH_ASSOC);
    $_SESSION["advisor"] =$result2["firstName"].' '.$result2["lastName"];
    $query1 ='SELECT * FROM course INNER JOIN studenthistory ON course.courseID = studenthistory.courseID WHERE studenthistory.studentID ="'.$_SESSION["studentID"].'"';
    $statement1 = $connect->prepare($query1);
    $statement1->execute();
    $arrayOfGradeLatters= ["A","A-","B+","B","B-","C+","C","C-","D+","D","F"];
    $arrayOfGradeValues= [4.0,3.7,3.3,3.0,2.7,2.3,2.0,1.7,1.3,1.0,0.0];
    $counter =0;
    $gradeadder=0.00;
    $_SESSION["hold"]=false;
    $_SESSION["credits"]=0;
    while($results = $statement1->fetch(PDO::FETCH_ASSOC))
    {
      $grades[] = $results["grade"];
      $counter +=1;

    }
    for ($i =0; $i <$counter;$i++)
    {
      $gradeindex = array_search($grades[$i], $arrayOfGradeLatters);
      $gradeadder += floatval($arrayOfGradeValues[$gradeindex]);
      $_SESSION["GPA"] =round(floatval($gradeadder/$counter),2);

    }


  if(!isset($_SESSION["username"])|| $_SESSION["rank"] !='Student'){
      header("location:/panel/log-in.php");

  }?><!DOCTYPE html>
    <html lang="en">
      <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="msapplication-tap-highlight" content="no">
        <meta name="description" content="">
        <title>Profile - Student</title>
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
              <li class="bold waves-effect"><a class="collapsible-header">Coruses<i class="material-icons chevron">chevron_left</i></a>
                <div class="collapsible-body">
                  <ul>
                    <li><a href="viewschedule.php" class="waves-effect">View Schedule<i class="material-icons">event</i></a></li>
                    <li><a href="register.php" class="waves-effect">Register For a Course<i class="material-icons">how_to_reg</i></a></li>
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
              <li class="bold waves-effect active"><a class="collapsible-header">Account<i class="material-icons chevron">chevron_left</i></a>
                <div class="collapsible-body">
                  <ul>
                    <li><a href="#" class="waves-effect active"><?php echo $_SESSION["name"]; ?><i class="material-icons">person</i></a></li>
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
            <?php
              $checkHolds = 'SELECT COUNT(*) FROM studenthold INNER JOIN hold ON studenthold.holdID =hold.holdID WHERE studenthold.studentID ="'.$_SESSION["studentID"].'"';
              $holdstatement = $connect->prepare($checkHolds);
              $holdstatement->execute();
              $holdResults =$holdstatement->fetch(PDO::FETCH_ASSOC);
              if($holdResults["COUNT(*)"]!=0)
              {
                $_SESSION["hold"]=true;
                $getHolds ='SELECT * FROM studenthold INNER JOIN hold ON studenthold.holdID =hold.holdID WHERE studenthold.studentID ="'.$_SESSION["studentID"].'"';
                $getHoldStatement =$connect->prepare($getHolds);
                $getHoldStatement->execute();
                while($getHoldResults=$getHoldStatement->fetch(PDO::FETCH_ASSOC))
                {
                  echo '
                  <div class="setting red white-text">
                    <i class="material-icons left">warning</i>
                    You have Holds on your Account !
                    <div class="switch right">
                      '.$getHoldResults["holdType"].' <i class="black-text"> Effective-'.$getHoldResults["dateHold"].'</i>
                    </div>
                  </div>
                  ';
                }
              }


             ?>
            <div class="setting">
              Account Level

              <div class="switch right">
                <?php echo $_SESSION["rank"];?>
              </div>
            </div>
            <div class="setting">
              Academic Advisor

              <div class="switch right">
                <?php echo $_SESSION["advisor"];?>
              </div>
            </div>
            <div class="setting">
              Name

              <div class="switch right">
                <?php echo $result["firstName"],' ', $result["lastName"];?>
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
                    <label for="username"><?php echo $result["username"];?></label>
                  </div>
                </div>
              </li>
              <li>
                <div class="collapsible-header"><i class="material-icons">place</i>Address</div>
                <div class="collapsible-body"><span><?php echo $result['streetAddress'],', ', $result["city"],', ', $result["state"],', ', $result["postalCode"]?></span></div>
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
