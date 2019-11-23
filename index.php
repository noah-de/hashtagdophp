<?php
if (!isset($_COOKIE['student_id'])) {
  header("Location: ./login/");
}

$db_con['host'] = "bminer-apps";
$db_con['port'] = "5433";
$db_con['user'] = "dophp";
$db_con['password'] = "Nalkerstet!";
$db_con['dbname'] = "dophp";
$conn_string = "host=" . $db_con['host'] . " port=" . $db_con['port'] . " user=" . $db_con['user'] . " password=" . $db_con['password'] . " dbname=" . $db_con['dbname'];
$db = pg_connect($conn_string);

// echo $conn_string; 

$cookie_studentID = $_COOKIE['student_id'];

$user_info_query_string = "SELECT * FROM person WHERE student_id = '" . $cookie_studentID . "';";
$user_info_prepare_query = pg_query($db, $user_info_query_string);
$user_info_result = pg_fetch_assoc($user_info_prepare_query);

$basic_search_query = $_POST['basic_search_query'];
//$reg_search_query_string = "SELECT firstname, lastname, dorm, profile_pic_url FROM person;"; //postgres command
$reg_search_query_string = "SELECT student_id, firstname, lastname, dorm, searched_num, profile_pic_url FROM person WHERE LOWER('" . $basic_search_query . "') LIKE LOWER('%' || firstname || '%') OR LOWER('" . $basic_search_query . "') LIKE LOWER('%' || lastname || '%');"; // this query gets more and more fucked every commit
$reg_search_query = pg_query($db, $reg_search_query_string);
$search_results = pg_fetch_all($reg_search_query);

function create_incrementer_query_str ($student_ids) {
	$query_beg = "UPDATE person SET searched_num = searched_num + 1 WHERE student_id = '";
	$query_glue= "' OR student_id = '";
	$query_end = "';";

	$glued_student_ids = implode($query_glue, $student_ids);

	$query_whole = $query_beg . $glued_student_ids . $query_end;

	return $query_whole;
}

$results_ids = array_column($search_results, 'student_id');

$increment_results_query_string = create_incrementer_query_str($results_ids);
$increment_results_query = pg_query($increment_results_query_string);
//$search_results = pg_fetch_assoc($reg_search_query); //runs postgres command on db

//var_dump($search_results);

/**
 * Pagination
 * 
 * desc: the janky as hell, works cited– straight outta my ass process that somewhat resembles the functionality of pagination.
 *   when the number of results returned is greater than 10, the first 10 results will be displayed on page 1, remaining results will be displayed on the following pages
 * psql LIMIT query calculated based on
 *   while page_num > 2; LIMIT = (page_num - 1) / 10
 * if results are greater than 10, a page 2 option will be displayed
 *   having no page number query implies ?page=1
 * 
 * vars:
 *   $current_page
 *   $next_page
 *   $previous_page
 *   $page_query
 *   $_GET['page']
 *   $num_results
 */
$current_page = 0;
$next_page = 0;
$previous_page = 0;

if (count($search_results) > 10) {
  $page_query = (isset($_GET['page'])) ? $_GET['page'] : 0;

  if ($page_query == 0) {
    $current_page = 1;
    $next_page = 2;
    $previous_page = 0;
  }
  if ($page_query > 0) {
    $current_page = $page_query;
    $next_page = $page_query + 1;
    $previous_page = $page_query - 1;
  }
  $limited_search_query_string = "SELECT student_id, firstname, lastname, dorm, profile_pic_url FROM person WHERE LOWER('" . $basic_search_query . "') LIKE LOWER('%' || firstname || '%') OR LOWER('" . $basic_search_query . "') LIKE LOWER('%' || lastname || '%');"; // this query gets more and more fucked every commit
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

  <title>Stalkernet</title>

  <script type="text/javascript" src="./node_modules/jquery/dist/jquery.min.js"></script>
  <script type="text/javascript" src="./node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script type="text/javascript" src="./js/script.js"></script>

  <link rel="stylesheet" type="text/css" href="./node_modules/bootstrap/dist/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="./node_modules/@fortawesome/fontawesome-free/css/all.css">
  <link rel="stylesheet" type="text/css" href="./css/styles.css">
</head>

<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light westmont">
  <a class="navbar-brand" href="https://www.westmont.edu">
    <img src="./images/westmont.png" height="30" alt="">
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
      echo "<li class=\"nav-item\" id=\"logged_in_dropdown\">";
        echo "<div class=\"dropdown\">";
		  echo "<a class=\"btn btn-secondary dropdown-toggle\" href=\"#\" role=\"button\" id=\"dropdownMenuLink\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">";
		  echo "Welcome, " . $user_info_result['firstname'];
		  echo "</a>";

		  echo "<div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuLink\">";
		    echo "<a class=\"dropdown-item\" href=\"profile/?sid=" . $cookie_studentID . "\">View Profile</a>";
		    echo "<a class=\"dropdown-item\" href=\"logout\">Logout</a>";
		  echo "</div>";
      echo "</li>";
  	  }
      ?>
    </ul>
  </div>
</nav>

<div class="hero-image">
  <div class="hero-text" align="center">
    <h1>Welcome to Westmont Student Finder</h1>
  </div>
</div>


<br>
<div class="container">
  <div class="row" id="reg_search_cont">
    <div class="col-md-10">
      <form method="POST" action="./index.php">
        <div class="input-group mb-3">
          <input name="basic_search_query" type="text" class="form-control" placeholder="Search..." aria-label="Search for a student" aria-describedby="basic-addon2" 
          <?php 
          echo "value=\"" . $basic_search_query . "\"";
          ?>>
          <div class="input-group-append">
            <input class="btn btn-outline-secondary" type="submit" value="Search" name="submit" id="reg_submit">
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="row" id="adv_search_cont">
    <div class="col-md-10"></div>
  </div>
</div>
<div class="container">
  <ul class="list-group list-group-flush" id="results">
    <?php
      if (empty($search_results)) {
        echo "<p> No results were found. </p>";

      } else {
        foreach ($search_results as $student) {
        	$wholename = $student['firstname'] . " " . $student['lastname'];
        	$searched_num = $student['searched_num'] + 1; // to reflect this searche

          echo "<li class=\"list-group-item card\">";
          echo "<span class=\"trim rounded-circle\"><img src=\"./images/" . $student['profile_pic_url'] . "\" class=\"card-image-top\" alt=\"" . $wholename . "\"></span>";
	          echo "<div class=\"card-body\">";
	          	echo "<h5 class=\"card-title\">" . $wholename . "</h5>";
	        	echo "</div>";
	        	echo "<ul class=\"list-group list-group-flush\">";
	          	echo "<li class=\"list-group-item d-flex align-items-center\"><span class=\"dorm\"><i class=\"fas fa-home fa-lg\"></i> </span> " . $student['dorm'] . "</li>";
	          	echo "<li class=\"list-group-item d-flex justify-content-between align-items-center\">Num times searched" .
	          		"<span class=\"badge badge-pill\" id=\"searched_num\">" . $searched_num . "</span></li>";
	          echo "</ul>";
	          echo "<div class=\"card-body\">";
					    echo "<a href=\"./profile/?sid=" . $student['student_id'] . "\" class=\"card-link\">Profile page</a>";
					  echo "</div>";
          echo "</li>";
        }
      }
      if ($previous_page < $current_page) {
        echo "<a href=\"?page=" . $page - 1 . "\">&lt;Page " . $page - 1 . "</a>";
      }
      if ($next_page > $previous_page) {
       echo "<a href=\"?page=" . $page . "\">Page " . $page . "&gt;</a>";
      }
    ?>
  </ul>
</div>
</body>
</html>
<?php
	pg_close($db);
?>