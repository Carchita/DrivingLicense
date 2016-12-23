<?php
require_once('../includes/initialize.php');
if(!isset($_SESSION['user'])) {
	echo 'no user';
	header("Location: ../home.php");
}
else if(isset($_SESSION['user'])) {
	//header("Location: dashboard.php");
	echo ' user';
}

if(isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("Location: ../home.php");
	echo 'logout user';
}
mysqli_close($conn);
?>