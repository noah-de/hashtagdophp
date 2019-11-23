<?php

require('../Person.php');

if (!isset($_COOKIE['student_id'])) {
  header("Location: ../login/");
}
else if ($_COOKIE['student_id'] == $_GET['sid']) {
  $is_user = true; // if this is true, this page is the presently logged-in users profile page
}

$cookie_studentID = $_COOKIE['student_id'];

$db_con['host'] = "bminer-apps";
$db_con['port'] = "5433";
$db_con['user'] = "dophp";
$db_con['password'] = "Nalkerstet!";
$db_con['dbname'] = "dophp";
$conn_string = "host=" . $db_con['host'] . " port=" . $db_con['port'] . " user=" . $db_con['user'] . " password=" . $db_con['password'] . " dbname=" . $db_con['dbname'];
$db = pg_connect($conn_string);

$user_info_query_string = "SELECT * FROM person WHERE student_id = '" . $cookie_studentID . "';";
$user_info_prepare_query = pg_query($db, $user_info_query_string);
$user_info_result = pg_fetch_assoc($user_info_prepare_query);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

    <title>Stalkernet</title>

    <script type="text/javascript" src="../node_modules/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript" src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript" src="../js/script.js"></script>

    <link rel="stylesheet" type="text/css" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../node_modules/@fortawesome/fontawesome-free/css/all.css">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light westmont">
      <a class="navbar-brand" href="https://www.westmont.edu">
        <img src="../images/westmont.png" height="30" alt="">
      </a>
       <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="https://www.westmont.edu/about"><font color="#FFFFFF">ABOUT</font></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://www.westmont.edu/academics"><font color="#FFFFFF">ACADEMICS</font></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://www.westmont.edu/admissions-aid"><font color="#FFFFFF">ADMISSIONS & AID</font></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://www.westmont.edu/student-life"><font color="#FFFFFF">STUDENT LIFE</font></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://www.westmont.edu/giving"><font color="#FFFFFF">GIVING</font></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://athletics.westmont.edu/index.aspx"><font color="#FFFFFF">ATHLETICS</font></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="login/"><font color="#FFFFFF">LOGIN</font></a>
          </li>
          <?php
          if (isset($_COOKIE['student_id'])) {
          echo "<li class=\"nav-item\"id=\"logged_in_dropdown\">";
            echo "<div class=\"dropdown\">";
          echo "<a class=\"btn btn-secondary dropdown-toggle\" href=\"#\" role=\"button\" id=\"dropdownMenuLink\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
          echo "Welcome, " . $user_info_result['firstname'];
          echo "</a>";

          echo "<div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuLink\">";
            echo "<a class=\"dropdown-item\" href=\"profile/?sid=" . $cookie_studentID . "\">View Profile</a>";
            echo "<a class=\"dropdown-item\" href=\"../logout\">Logout</a>";
          echo "</div>";
          echo "</li>";
          }
          ?>
        </ul>
      </div>
    </nav>

    <!-- <div class="container">
      <div class="row" id="reg_search_cont">
        <div class="col-md-10">
          <form method="POST" action="./index.php">
            <div class="input-group mb-3">
              <input name="basic_search_query" type="text" class="form-control" placeholder="Search..." aria-label="Search for a student" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button">GO</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="row" id="adv_search_cont">
        <div class="col-md-10"></div>
      </div>
    </div> -->
    <div class="container">
      

      <?php 
        $student_id = $_GET['sid'];
        $student = new StudentHelper($student_id);
        $student->set_all();

        /*if(isset($_COOKIE['student_id'])) {
          if($sid == $_COOKIE['student_id']) {
            //content is editable
            echo 'cookie :------)';
            echo $student->getFirstname();
            echo '<button> biggest dicks </button>'; //button to link to js


          }
        } else {
          //just display info
          echo 'no cookie :------(';
          echo $student->getFirstname();
        }*/
      ?>
        <ul> 
          <li> <?php echo "<p><a href=\"http://localhost:8080/editable_profile/?sid=" . $roommate['student_id'] . "\">Edit</a>"; ?> </li>
          <!-- todo: check if student allows info to be seen -->
          <li>name: <?php echo $student->getFirstname() . " " . $student->getLastname(); ?></li>
          <li><img src="../images/<?php echo $student->getProfilePicURL(); ?>"></li>
          <li>dorm: <?php echo $student->getDorm(); ?></li>
          <li>email: <?php echo $student->getEmail(); ?></li>
          <li>year: <?php echo $student->getYear(); ?></li>
          <li>mailbox: <?php echo $student->getMSNum(); ?></li>
          <li>phone number: <?php echo $student->getPhoneNum(); ?></li>
          <li>roommates:
            <ul>
              <?php
                var_dump($student->setRoommates());
                $getRoommatesInfo = $student->getRoommatesInfo();
                foreach ($getRoommatesInfo as $roommate) {
                  echo "<li>";
                  echo "<img src=\"../images/" . $roommate['profile_pic_url'] . "\">";
                  echo "<p>" . $value['firstname'] . " " . $roommate['lastname'] . "</p>";
                  echo "<p><a href=\"http://10.30.49.240/profile/?sid=" . $roommate['student_id'] . "\">Profile</a>";
                  echo "</li>";
                }
              ?>
            </ul>
          </li>
        </ul>
      </div>
  </body>
</html>
<?php
  pg_close($db);
?>