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

function checkbox_boolean_helper ($value) {
  return ($value == "on") ? 1 : 0;
}


$update_person_query_string_beg = "UPDATE person SET";
$update_person_query_string_end = " WHERE student_id = '" . $cookie_studentID . "';";
$update_person_query_string_cols_vals = "";

$update_privacy_query_string_beg = "UPDATE privacy SET";
$update_privacy_query_string_end = " WHERE student_id = '" . $cookie_studentID . "';";
$update_privacy_query_string_cols_vals = "";


// var_dump($student);
// $test_query_string = "SELECT * FROM privacy WHERE student_id = '" . $cookie_studentID . "';";
// $test_prepare_query = pg_query($db, $user_info_query_string);
// $test_result = pg_fetch_assoc($user_info_prepare_query);

foreach ($_POST as $key=>$value) {
  $orig_value = $student->getter_by_name($key);
  $form_value = $value;

  // if ($form_value == "on") {
  //   $form_value = checkbox_boolean_helper($form_value);
  // }

  $cond_not_prof_pic = ($key != "profile_pic");
  $cond_not_save = ($key != "save");
  $cond_not_same = ($orig_value != $form_value);
  $will_be_added = ($cond_not_prof_pic && $cond_not_save && $cond_not_same);

  /*if ($key == "preferred_name_privacy") {
    echo "\$key: " . $key . "<br>";
    echo "\$form_value: " . $form_value . "<br>";
    echo "\$orig_value: " . $orig_value . "<br>";
  }*/

  if ($will_be_added) {
    $student->setter_by_name($key, $form_value);
    // echo "\$key: " . $key . "<br>";
    // echo "\$form_value: " . $form_value . "<br>";
    // echo "\$orig_value: " . $orig_value . "<br>";
    $privacy_str_pos = strpos($key, "_privacy");

    if (is_numeric($privacy_str_pos)) {
      $key = substr($key, 0, $privacy_str_pos);
      // echo "\$key: " . $key . "<br>";
      // echo "\$form_value: " . $form_value . "<br>";
      // echo "\$orig_value: " . $orig_value . "<br>";
      $update_privacy_query_string_cols_vals .= " " . $key . " = '" . $form_value . "',";
    }
    else {
      if ((($key == "preferred_name") || ($key == "alt_email")) && (empty($form_value) || !isset($form_value))) {
        $update_person_query_string_cols_vals .= " " . $key . " = NULL";
      }
      else {
        $update_person_query_string_cols_vals .= " " . $key . " = '" . $form_value . "',";      
      }
    }
  }
  // else if (!$cond_not_prof_pic) {

  // }
}

// var_dump($student);


if ($update_person_query_string_cols_vals !== "") {
  $update_person_query_string_cols_vals = rtrim($update_person_query_string_cols_vals, ",");

  $update_person_query_string = $update_person_query_string_beg . $update_person_query_string_cols_vals . $update_person_query_string_end;
  // echo $update_person_query_string;
  $update_person_query = pg_query($db, $update_person_query_string);
}
if ($update_privacy_query_string_cols_vals !== "") {
  $update_privacy_query_string_cols_vals = rtrim($update_privacy_query_string_cols_vals, ",");

  $update_privacy_query_string = $update_privacy_query_string_beg . $update_privacy_query_string_cols_vals . $update_privacy_query_string_end;
  // echo $update_privacy_query_string;
  $update_privacy_query = pg_query($db, $update_privacy_query_string);
}


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
      <a class="navbar-brand" href="../">
        <img src="../images/westmont.png" height="30" alt="">
      </a>
       <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link" href="https://www.westmont.edu/about">ABOUT</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://www.westmont.edu/academics">ACADEMICS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://www.westmont.edu/admissions-aid">ADMISSIONS & AID</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://www.westmont.edu/student-life">STUDENT LIFE</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://www.westmont.edu/giving">GIVING</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://athletics.westmont.edu/index.aspx">ATHLETICS</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="../login/">LOGIN</a>
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
            echo "<a class=\"dropdown-item\" href=\"../logout/\">Logout</a>";
          echo "</div>";
          echo "</li>";
          }
          ?>
        </ul>
      </div>
    </nav>
    <br>
    <div class="container profile_content" id="static_content">
      <?php
      if ($is_user) {
        echo "<button type=\"button\" class=\"btn btn-outline-info btn-sm\" id=\"edit\">Edit</button>";
        // show everything, as long as it has a value
      }
      else {
        echo "no edit";
        // show only if privacy is checked and has value


      }
      ?>
      <ul>
        <li>name: <?php echo $student->getFirstname() . " " . $student->getLastname(); ?></li>
        <li>preferred name: <?php echo (!empty($student->getPreferredName())) ? $student->getPreferredName() : ""; ?></li>
        <li><img src="../images/<?php echo $student->getProfilePicURL(); ?>"></li>
        <li>dorm: <?php echo $student->getDorm(); ?></li>
        <li>email: <a <?php echo "href=\"mailto:" . $student->getEmail() . "\""; ?>><?php echo $student->getEmail(); ?></a></li>
        <li>year: <?php echo $student->getYear(); ?></li>
        <li>mailbox: <?php echo $student->getMSNum(); ?></li>
        <li>phone number: <a class="static_phone_num" <?php echo "href=\"tel:" . $student->getPhoneNum() . "\""; ?>><?php echo $student->getPhoneNum(); ?></a></li>
        <li>roommates:
          <ul>
            <?php
              $getRoommatesInfo = $student->getRoommatesInfo();
              foreach ($getRoommatesInfo as $roommate) {
                echo "<li>";
                echo "<img src=\"../images/" . $roommate['profile_pic_url'] . "\">";
                echo "<p>" . $roommate['firstname'] . " " . $roommate['lastname'] . "</p>";
                echo "<p><a href=\"./?sid=" . $roommate['student_id'] . "\">Profile</a>";
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
      <form method="POST" <?php echo "action=\"./?sid=" . $cookie_studentID . "\""; ?>>
        <input type="submit" name="save" value="Save" class="btn btn-info btn-sm" id="save">
        <button type="button" class="btn btn-secondary btn-sm" id="cancel">Cancel</button>
        <!-- <button type="button" class="btn btn-info btn-sm" id="save">Save</button> -->
        <div class="form-row">
          <div class="col form-group">
            <label for="preferred_name">preferred name</label>
            <input type="text" class="form-control" id="preferred_name" aria-describedby="preferred_name-desc" name="preferred_name" placeholder="McLovin" <?php echo "value=\"" . $student->getPreferredName() . "\""; ?>>
            <small id="preferred_name-desc" class="form-text text-muted">Name you would prefer to go by.</small>
          </div>
          <div class="col">
            <div class="custom-control custom-switch">
              <input type="hidden" name="preferred_name_privacy" value="0">
              <input type="checkbox" class="custom-control-input privacy" value="1" name="preferred_name_privacy" id="preferred_name_privacy" <?php echo ($student->getPreferredNamePrivacy()) ? "checked" : ""; ?>>
              <label class="custom-control-label privacy" for="preferred_name_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
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
              <input type="hidden" name="phone_num_privacy" value="0">
              <input type="checkbox" class="custom-control-input privacy" value="1" name="phone_num_privacy" id="phone_num_privacy" <?php echo ($student->getPhoneNumPrivacy()) ? "checked" : ""; ?>>
              <label class="custom-control-label privacy" for="phone_num_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col form-group">
            <label for="alt_email">Alternate email address</label>
            <input type="email" class="form-control" name="alt_email" id="alt_email" placeholder="noobmaster69@aol.com" <?php echo "value=\"" . $student->getAltEmail() . "\""; ?>>
          </div>
          <div class="col">
            <div class="custom-control custom-switch">
              <input type="hidden" name="alt_email_privacy" value="0">
              <input type="checkbox" class="custom-control-input privacy" value="1" name="alt_email_privacy" id="alt_email_privacy" <?php echo ($student->getAltEmailPrivacy()) ? "checked" : ""; ?>>
              <label class="custom-control-label privacy" for="alt_email_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
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
              <input type="hidden" name="profile_pic_privacy" value="0">
              <input type="checkbox" class="custom-control-input privacy" value="1" name="profile_pic_privacy" id="profile_pic_privacy" <?php echo ($student->getProfilePicPrivacy()) ? "checked" : ""; ?>>
              <label class="custom-control-label privacy" for="profile_pic_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col">name: <?php echo $student->getFirstname() . " " . $student->getLastname(); ?></div>
          <div class="col form-group">
            <div class="custom-control custom-switch">
              <input type="hidden" name="name_privacy" value="0">
              <input type="checkbox" class="custom-control-input privacy" value="1" name="name_privacy" id="name_privacy" <?php echo ($student->getNamePrivacy()) ? "checked" : ""; ?>>
              <label class="custom-control-label privacy" for="name_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col">year: <?php echo $student->getYear(); ?></div>
          <div class="col form-group">
            <div class="custom-control custom-switch">
              <input type="hidden" name="year_privacy" value="0">
              <input type="checkbox" class="custom-control-input privacy" value="1" name="year_privacy" id="year_privacy" <?php echo ($student->getYearPrivacy()) ? "checked" : ""; ?>>
              <label class="custom-control-label privacy" for="year_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col">email: <?php echo $student->getEmail(); ?></div>
          <div class="col form-group">
            <div class="custom-control custom-switch">
              <input type="hidden" name="email_privacy" value="0">
              <input type="checkbox" class="custom-control-input privacy" value="1" name="email_privacy" id="email_privacy" <?php echo ($student->getEmailPrivacy()) ? "checked" : ""; ?>>
              <label class="custom-control-label privacy" for="email_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col">MS#: <?php echo $student->getMSNum(); ?></div>
          <div class="col form-group">
            <div class="custom-control custom-switch">
              <input type="hidden" name="ms_num_privacy" value="0">
              <input type="checkbox" class="custom-control-input privacy" value="1" name="ms_num_privacy" id="ms_num_privacy" <?php echo ($student->getMSNumPrivacy()) ? "checked" : ""; ?>>
              <label class="custom-control-label privacy" for="ms_num_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col">Searched num: <?php echo $student->getSearchedNum(); ?></div>
          <div class="col form-group">
            <div class="custom-control custom-switch">
              <input type="hidden" name="searched_num_privacy" value="0">
              <input type="checkbox" class="custom-control-input privacy" value="1" name="searched_num_privacy" id="searched_num_privacy" <?php echo ($student->getSearchedNumPrivacy()) ? "checked" : ""; ?>>
              <label class="custom-control-label privacy" for="searched_num_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col">Allow to be searched by roommates</div>
          <div class="col form-group">
            <div class="custom-control custom-switch">
              <input type="hidden" name="roommates_privacy" value="0">
              <input type="checkbox" class="custom-control-input privacy" value="1" name="roommates_privacy" id="roommates_privacy" <?php echo ($student->getRoommatesPrivacy()) ? "checked" : ""; ?>>
              <label class="custom-control-label privacy" for="roommates_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
            </div>
          </div>
        </div>
        <div class="form-row">
          <div class="col">
            <p>dorm: <?php echo $student->getDorm(); ?></p>
            <p>room num: <?php echo $student->getRoomNum(); ?></p>
          </div>
          <div class="col form-group">
            <div class="custom-control custom-switch">
              <input type="hidden" name="dorm_privacy" value="0">
              <input type="checkbox" class="custom-control-input privacy" value="1" name="dorm_privacy" id="dorm_privacy" <?php echo ($student->getDormPrivacy()) ? "checked" : ""; ?>>
              <label class="custom-control-label privacy" for="dorm_privacy" data-toggle="tooltip" data-placement="right"><i class="fas fa-question-circle fa-sm"></i></label>
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