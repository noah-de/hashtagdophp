<?php

	setcookie("student_id", "", time() - 3600);
	header("Location: ../login/");

?>