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

$search_columns = "student_id, firstname, lastname, dorm, searched_num, profile_pic_url";

$lowercase_basic_search_query = strtolower($basic_search_query);
$reg_search_query_string = "SELECT $search_columns FROM person WHERE '" . $lowercase_basic_search_query . "' LIKE LOWER('%' || firstname || '%') OR '" . $lowercase_basic_search_query . "' LIKE LOWER('%' || lastname || '%') OR '" . $lowercase_basic_search_query . "' LIKE LOWER('%' || preferred_name || '%');"; // this query gets more and more fucked every commit
$reg_search_query = pg_query($db, $reg_search_query_string);
// pg_fetch_all moved to bottom

function create_incrementer_query_str ($student_ids) {
	$query_beg = "UPDATE person SET searched_num = searched_num + 1 WHERE student_id = '";
	$query_glue= "' OR student_id = '";
	$query_end = "';";

	$glued_student_ids = implode($query_glue, $student_ids);

	$query_whole = $query_beg . $glued_student_ids . $query_end;

	return $query_whole;
}

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * TODO:													   *
 * 	 parse out adv search form and write corresponding queries *
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

/*
 *
 * Get all 
 * 
 */

if (!empty($_POST['show-all']) && isset($_POST['show-all'])) {
  $query_string = "SELECT $search_columns FROM person ORDER BY lastname, firstname DESC;";
  $prepare_query = pg_query($db, $query_string);
  $show_all_results = pg_fetch_all($prepare_query);
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
  <a class="navbar-brand" href="./"><img src="./images/westmont.png" height="30" alt=""></a>
   <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="https://www.westmont.edu/about">About</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://www.westmont.edu/academics">Academics</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://www.westmont.edu/admissions-aid">Admissions & Aid</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://www.westmont.edu/student-life">Student Life</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://www.westmont.edu/giving">Giving</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="https://athletics.westmont.edu/index.aspx">Athletics</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="./login/">Login</a>
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
    <h1>Welcome to Westmont Student Finder!</h1>
    <h2> Find Your Community Below </h2>
  </div>
</div>

<br>

<div class="container">
	<div class="row">
		<div class="col-md-10">
			<ul class="nav nav-tabs" id="searches_tabs" role="tablist">
			  <li class="nav-item">
			    <a class="nav-link active" id="reg-tab" data-toggle="tab" href="#reg" role="tab" aria-controls="reg" aria-selected="true">Basic Search</a>
			  </li>
			  <li class="nav-item">
			    <a class="nav-link" id="adv-tab" data-toggle="tab" href="#adv" role="tab" aria-controls="adv" aria-selected="false">Advanced Search</a>
			  </li>
			</ul>
			<div class="tab-content" id="searches_content">
			  <div class="tab-pane fade show active" id="reg" role="tabpanel" aria-labelledby="reg-tab">
			  		<form method="POST" action="./" name="show-all-form" id="show-all-form"><input type="hidden" name="show-all" value="show-all"><!-- <input type="submit" name="show-all-submit" value="show-all-submit" id="show-all-submit"> --></form>
					  <div class="row" id="reg_search_cont">
					    <div class="col-md-12">
					      <form method="POST" action="./" name="reg">
					        <div class="input-group mb-3">
					        	<div class="input-group-prepend">
					            <button class="btn btn-outline-secondary" tabindex="-1" id="show-all-btn" form="show-all-form">Show all</button>
					          </div>
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
					</div>
					<div class="tab-pane fade" id="adv" role="tabpanel" aria-labelledby="adv-tab">
			  	<!-- <div class="container" id="adv_search_cont"> -->
						<div class="row" id="adv_search_cont">
					    <div class="col-md-12">
					      <form method="POST" action="./" name="reg">
					    		<div class="form-row">
								    <div class="col form-group">
								    	<label for="adv_firstname">First name</label>
									    <input type="text" class="form-control" id="adv_firstname" name="adv_firstname" placeholder="Jane">
								    </div>
								    <div class="col form-group">
								    	<label for="adv_lastname">Last name</label>
									    <input type="text" class="form-control" id="adv_lastname" name="adv_lastname" placeholder="Doe">
								    </div>
								  </div>
								  <div class="form-row">
								    <div class="col form-group">
								    	<label for="adv_dorm">Dorm</label>
									    <select class="form-control" id="adv_dorm" name="adv_dorm">
									    	<option selected="selected" disabled>Pick a dorm</option>
									    	<option value="Clark">Clark</option>
									    	<option value="Page">Page</option>
									    	<option value="Emerson">Emerson</option>
									    	<option value="Armington">Armington</option>
									    	<option value="Van Kampen">Van Kampen</option>
									    	<option value="GLC">GLC</option>
									    </select>
								    </div>
								    <div class="col form-group">
								    	<label for="adv_section">Building</label>
									    <select class="form-control" id="adv_section" name="adv_section"><option selected="selected" disabled>First select a dorm</option></select>
								    </div>
								  </div>
								  <div class="form-row">
								    <div class="col form-group">
								  		<label for="adv_roommates">Roommates with</label>
									    <input type="text" class="form-control" id="adv_roommates" name="adv_roommates" placeholder="Gayle Bebee">
							  		</div>
								  </div>
								  <div class="form-row">
								    <div class="col form-group">
								  		<input type="submit" value="Search" name="adv_submit" class="btn btn-primary btn-lg btn-block" id="adv_submit">
							  		</div>
								  </div>
				    		</form>
					    </div>
					  </div>
					</div>
			  </div>
		  </div>
		</div>
	</div>

<br>

<div class="container">
  <ul class="list-group-flush row" id="results">
    <?php
		$search_results = pg_fetch_all($reg_search_query);

		// var_dump($search_results);
      if (!empty($search_results) || !empty($show_all_results)) {
      	if ((!empty($show_all_results)) && (count($show_all_results) > 0)) {
      		$search_results = $show_all_results;
      	}

      	$results_ids = array_column($search_results, 'student_id');
		$increment_results_query_string = create_incrementer_query_str($results_ids);
		$increment_results_query = pg_query($increment_results_query_string);

		$breaker_counter = 0;

        foreach ($search_results as $student) {
        	$wholename = $student['firstname'] . " " . $student['lastname'];
        	$searched_num = $student['searched_num'] + 1; // to reflect this search

          echo "<li class=\"card col-md-3 result\">";
          echo "<span class=\"trim rounded-circle align-items-center\"><img src=\"./images/" . $student['profile_pic_url'] . "\" class=\"card-image-top\" alt=\"" . $wholename . "\"></span>";
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

          $breaker_counter++;
          if (($breaker_counter % 3) == 0) {
          	echo "<div class=\"w-100\"></div>";
          }
        }
      }
      else if ((empty($_POST['show-all']) || !isset($_POST['show-all'])) && !(empty($_POST['submit']) || !isset($_POST['submit']))) {
      	echo "<p>No results were found.</p>";
      }
      /* if ($previous_page < $current_page) {
        echo "<a href=\"?page=" . $page - 1 . "\">&lt;Page " . $page - 1 . "</a>";
      }
      if ($next_page > $previous_page) {
       echo "<a href=\"?page=" . $page . "\">Page " . $page . "&gt;</a>";
      } */
    ?>
  </ul>
</div>
<!-- <br>
<nav aria-label="...">
  <ul class="pagination">
    <li class="page-item disabled">
      <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Previous</a>
    </li>
    <li class="page-item active" aria-current="page">
      <a class="page-link" href="#">1 <span class="sr-only">(current)</span></a>
    </li>
    <li class="page-item"><a class="page-link" href="#">2</a></li>
    <li class="page-item"><a class="page-link" href="#">3</a></li>
    <li class="page-item">
      <a class="page-link" href="#">Next</a>
    </li>
  </ul>
</nav> -->
</body>
</html>
<?php
	pg_close($db);
?>