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

$student_id = $_GET['sid'];
$student = new StudentHelper($student_id);
$student->set_all();
$student->set_all_privacy();


/*
 * update handler
 */



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
    <script type="text/javascript" src="./js/script.js"></script>

    <link rel="stylesheet" type="text/css" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../node_modules/@fortawesome/fontawesome-free/css/all.css">
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
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
            echo "<a class=\"dropdown-item\" href=\"./?sid=" . $cookie_studentID . "\">View Profile</a>";
            echo "<a class=\"dropdown-item\" href=\"../logout\">Logout</a>";
          echo "</div>";
          echo "</li>";
          }
          ?>
        </ul>
      </div>
    </nav>
    <div class="container profile_content" id="static_content">
      <ul> 
        <li>
          <?php
          if ($is_user) {
            // echo "<p><a href=\"http://localhost:8080/editable_profile/?sid=" . $roommate['student_id'] . "\">Edit</a>";
            echo "<button type=\"button\" class=\"btn btn-outline-info btn-sm\" id=\"edit\">Edit</button>";
          }
          ?>
        </li>
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
              $getRoommatesInfo = $student->getRoommatesInfo();
              foreach ($getRoommatesInfo as $roommate) {
                echo "<li>";
                echo "<img src=\"../images/" . $roommate['profile_pic_url'] . "\">";
                echo "<p>" . $roommate['firstname'] . " " . $roommate['lastname'] . "</p>";
                echo "<p><a href=\"http://10.30.49.240:8080/profile/?sid=" . $roommate['student_id'] . "\">Profile</a>";
                echo "</li>";
              }
            ?>
          </ul>
        </li>
      </ul>
    </div>
    <!-- 
      -- TODO:
      --   make privacy switches work
      --   link form to php up top and write queries to update
      --   uploading photo is going to be the weirdest
      --     allow in php.ini
      --     php upload physical file to directory
      --     rename file to convention + datetime
      --     update student's db row profile_pic_url
      --   success/error balloon/banner
      --   enhance ui
      --     prepend font-awesome icons to all rows (where applicable)
      --     etc.
      -->
    <div class="container profile_content" id="editable_content">
      <form method="POST" action="./">
        <!-- <input type="submit" name="update" value="Save" class="btn btn-info" id="update"> -->
        <button type="button" class="btn btn-info btn-sm" id="save">Save</button>
        <div class="form-row">
          <div class="col form-group">
            <label for="preferred_name">preferred name</label>
            <input type="text" class="form-control" id="preferred_name" aria-describedby="preferred_name-desc" name="preferred_name" placeholder="McLovin">
            <small id="preferred_name-desc" class="form-text text-muted">Name you would prefer to go by.</small>
          </div>
          <div class="col">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input privacy" name="preferred_name_privacy" id="preferred_name_privacy" checked>
              <label class="custom-control-label" for="preferred_name_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col form-group">
            <label for="phone_num">Phone number</label>
            <input type="tel" class="form-control" id="phone_num" name="phone_num" placeholder="1-805-420-6969" <?php echo "value=\"" . $student->getPhoneNum() . "\""; ?>>
          </div>
          <div class="col">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input privacy" name="phone_num_privacy" id="phone_num_privacy">
              <label class="custom-control-label" for="phone_num_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col form-group">
            <label for="alt_email">Alternate email address</label>
            <input type="email" class="form-control" name="alt_email" id="alt_email" placeholder="noobmaster69@aol.com">
          </div>
          <div class="col">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input privacy" name="alt_email_privacy" id="alt_email_privacy">
              <label class="custom-control-label" for="alt_email_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col form-group">
            <div class="input-group mb-3">
              <div class="custom-file">
                <input type="file" class="custom-file-input" name="profile_pic" id="profile_pic">
                <label class="custom-file-label" for="profile_pic">Choose photo</label>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input privacy" name="profile_pic_privacy" id="profile_pic_privacy">
              <label class="custom-control-label" for="profile_pic_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col">name: <?php echo $student->getFirstname() . " " . $student->getLastname(); ?></div>
          <div class="col form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input privacy" name="name_privacy" id="name_privacy">
              <label class="custom-control-label" for="name_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col">year: <?php echo $student->getYear(); ?></div>
          <div class="col form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input privacy" name="year_privacy" id="year_privacy">
              <label class="custom-control-label" for="year_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col">email: <?php echo $student->getEmail(); ?></div>
          <div class="col form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input privacy" name="email_privacy" id="email_privacy">
              <label class="custom-control-label" for="email_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col">MS#: <?php echo $student->getMSNum(); ?></div>
          <div class="col form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input privacy" name="ms_num_privacy" id="ms_num_privacy">
              <label class="custom-control-label" for="ms_num_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col">Searched num: <?php echo $student->getSearchedNum(); ?></div>
          <div class="col form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input privacy" name="searched_num_privacy" id="searched_num_privacy">
              <label class="custom-control-label" for="searched_num_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col">Allow to be searched by roommates</div>
          <div class="col form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input privacy" name="roommates_privacy" id="roommates_privacy">
              <label class="custom-control-label" for="roommates_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col">dorm: <?php echo $student->getDorm(); ?></div>
          <div class="col">room num: <?php echo $student->getRoomNum(); ?></div>
          <div class="col form-group">
            <div class="custom-control custom-switch">
              <input type="checkbox" class="custom-control-input privacy" name="dorm_privacy" id="dorm_privacy">
              <label class="custom-control-label" for="dorm_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
      </form>
    </div>
  </body>
</html>
<?php
  pg_close($db);
?>