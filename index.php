<?php
  // if (!isset($_COOKIE['studentID'])) {
  //   header("Location: ./login/index.php");
  // }
  $db_con['host'] = "10.30.49.96";
  $db_con['port'] = "5432";
  $db_con['user'] = "dophp";
  $db_con['password'] = "Nalkerstet!";
  $db_con['dbname'] = "stalkernet";
  $conn_string = "host=" . $db_con['host'] . " port=" . $db_con['port'] . " user=" . $db_con['user'] . " password=" . $db_con['password'] . " dbname=" . $db_con['dbname'];
  $db = pg_connect($conn_string);

  echo $conn_string;

  // $cookie_studentID = $_COOKIE['studentID'];
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
    <link rel="stylesheet" type="text/css" href="./css/styles.css">
  </head>
  <body>
    <div class="container">
    	
    </div>
	</body>
</html>