<?php

if (isset($_COOKIE['student_id'])) {
  header("Location: ..");
}

$login_error = "";
if (isset($_POST['username']) && isset($_POST['password'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  $db_con['host'] = "bminer-apps";
  $db_con['port'] = "5433";
  $db_con['user'] = "dophp";
  $db_con['password'] = "Nalkerstet!";
  $db_con['dbname'] = "dophp";
  $conn_string = "host=" . $db_con['host'] . " port=" . $db_con['port'] . " user=" . $db_con['user'] . " password=" . $db_con['password'] . " dbname=" . $db_con['dbname'];
  $db = pg_connect($conn_string);


  $salt = "!wEstm0nt@";
  $salted_password = $password . $salt;
  $hashed_password = hash("sha256", $salted_password);

  $query_string = "SELECT * FROM login WHERE username='" . $username . "';";
  $prepare_query = pg_query($db, $query_string);
  $result = pg_fetch_assoc($prepare_query);

  $cookie_lifetime = 1200; // 20 minutes in seconds; 20 * 60

  if (empty($result)) {
    $login_error = "Username does not exist.";
  }
  else {
    if ($result['password'] === $hashed_password) {
      setcookie('student_id', $result['student_id'], time() + $cookie_lifetime, "/");
      header("Location: ..");
    }
    else {
      $login_error = "Incorrect password.";
    }
  }
}
/*else if (!isset($_POST['username']) || empty($_POST['username'])) {
  $login_error = "No username entered";
}
else if (!isset($_POST['password']) || empty($_POST['password'])) {
  $login_error = "No password entered";
}*/


?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script type="text/javascript" src="../node_modules/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="../node_modules/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
<!-- <script type="text/javascript" src="./js/script.js"></script> -->

<link rel="stylesheet" type="text/css" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="./css/styles.css">
</head>
<body>


<div class="bg-img">
  <form action="./" method="post" class="container">

    <h1>Login</h1>

    <?php
    if (!empty($login_error)) {
      echo "<div class=\"alert alert-danger\" role=\"alert\">";
      echo $login_error;
      echo "</div>";
    }
    ?>

    <label for="email"><b>Username</b></label>
    <input type="text" placeholder="Username" class="username" name="username" <?php echo "value=\"" . $username . "\"" ?> required autofocus>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Password" class="password" name="password" required>

    <input type="submit" class="btn submit" value="Login" name="submit" id="login_button">
  </form>
</div>
</body>
</html>