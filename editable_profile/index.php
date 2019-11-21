<?php

require('../Person.php');

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
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light westmont">
      <a class="navbar-brand" href="#">
        <img src="../images/westmont.png" height="30" alt="">
      </a>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a color="white" class="nav-link" href="#"><font color="#FFFFFF">ABOUT</font></a>
          </li>
          <li class="nav-item">
            <a  color="white" class="nav-link" href="#"><font color="#FFFFFF">ACADEMICS</font></a>
          </li>
          <li class="nav-item">
            <a color="white" class="nav-link" href="#"><font color="#FFFFFF">ADMISSIONS & AID</font></a>
          </li>
          <li class="nav-item">
            <a color="white" class="nav-link" href="#"><font color="#FFFFFF">STUDENT LIFE</font></a>
          </li>
          <li class="nav-item">
            <a color="white" class="nav-link" href="#"><font color="#FFFFFF">GIVING</font></a>
          </li>
          <li class="nav-item">
            <a color="white" class="nav-link" href="#"><font color="#FFFFFF">ATHLETICS</font></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../login/index.php"><font color="#FFFFFF">LOGIN</font></a>
          </li>
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
        <!-- todo: check if student allows info to be seen -->
        <li>name: <?php echo $student->getFirstname() . " " . $student->getLastname(); ?></li>
        <!-- <li><img src="../images/<?php echo $student->getProfilePicURL(); ?>"></li> -->
        <!-- <li>img: <?php //echo $img src=../images/ . " " . $student->getProfilePicURL(); ?> ></li> -->
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
                  echo "<p><a href=\"http://localhost:8080/profile/?sid=" . $roommate['student_id'] . "\">Profile</a>";
                  echo "</li>";
                }
              ?>
            </ul>
          </li>
        </ul>
      </div>
  </body>
</html>
