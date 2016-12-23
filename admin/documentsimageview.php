<?php 

	require_once('../includes/initialize.php');
	if(!isset($_SESSION['admin'])) {
		header("Location: ../home.php");
	}

	$uniqID = $_GET['id'];
	$filename = $_GET['file'];

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<img src="<?php echo "../assets/application images/".$uniqID."/".$filename; ?>" style="height: 600px;">
</body>
</html>
