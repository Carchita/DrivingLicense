<?php

require_once('../includes/initialize.php');

if(!isset($_SESSION['admin'])) {
	echo 'no admin';
	header("Location: ../home.php");
}
else if(isset($_SESSION['admin'])) {
	header("Location: dashboard.php");
	echo ' admin';
}

if(isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['admin']);
	header("Location: ../home.php");
	echo 'logout admin';
}
mysqli_close($conn);
?>