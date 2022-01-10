<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="description" content="">
    <title>Departments</title>
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
          <div class="nav-wrapper"><a href="#!" class="brand-logo grey-text text-darken-4">Departments</a>
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
              <li class="bold waves-effect active"><a class="collapsible-header">Department/Building<i class="material-icons chevron">chevron_left</i></a>
                <div class="collapsible-body">
                  <ul>
                    <li><a href="departments.php" class="waves-effect active">Departments<i class="material-icons">groups</i></a></li>
                    <li><a href="buildings.php" class="waves-effect">Buildings<i class="material-icons">apartment</i></a></li>
                  </ul>
                </div>
              </li>
            </li>
            <li class="bold waves-effect"><a class="collapsible-header">Account<i class="material-icons chevron">chevron_left</i></a>
              <div class="collapsible-body">
                <ul>
                  <li><a href="log-in.php" class="waves-effect">Log In<i class="material-icons">person</i></a></li>
                </ul>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </header>
    <main>
      <!-- Tables -->
<div class="container">
  <div class="row">
    <div class="col s12">
      <h2 class="section-title">Departments</h2>
        <div id='test2' class='row'>
          <div class='col s12'>
            <div class='card'>
              <table id ='defualt-table' class='row-border' cellspacing='0' width='100%'>
            <thead>
              <tr>
                <th>Department</th>
		<th>Email</th>
		<th>Phone Number</th>
		<th>Manager</th>
		<th>Room Number</th>
		<th>Building</th>
              </tr>
            </thead>
            <?php
            require "db.php";
            try {
                $stmt = $connect->prepare("SELECT dept.department, dept.departmentEmail, dept.departmentPhoneNumber,dept.manager, room.roomID, building.buildingName FROM dept INNER JOIN room ON dept.roomID = room.roomID INNER JOIN building ON building.buildingID = room.buildingID");
                $stmt->execute();
                while($row =$stmt->fetch(PDO::FETCH_ASSOC)){
                            echo '<tr>';
                            echo '<td>' . $row["department"] . '</td>';
                            echo '<td>' . $row["departmentEmail"] . '</td> ';
			    echo '<td>' . $row["departmentPhoneNumber"] . '</td>';
			    echo '<td>' . $row["manager"] . '</td>';
                            echo '<td>' . $row["roomID"] . '</td> ';
			    echo '<td>' . $row["buildingName"] . '</td>';
                            echo '</tr>';
                }
              }catch(PDOException $e) {
                  echo "Error: " . $e->getMessage();
              }

             ?>
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
