<?php 

	require_once('../includes/initialize.php');
	if(!isset($_SESSION['user'])) {
		header("Location: ../home.php");
	}

	$loc = $_GET['location'];
	$dat = $_GET['date'];
	$Slot = $_GET['slot'];

	$query = "SELECT count(email) FROM slotbooking WHERE RTO = '{$loc}' and slot = '{$Slot}' and date = '{$dat}'; ";
	$result = mysqli_query($conn, $query);
	if(!$result){
		echo mysqli_num_rows($result);
		die("wrng retrieving at basic1");
	} else {
		$slot1 = mysqli_fetch_array($result);
		$x =  $slot1['count(email)'];
		if($x == 20) {
			echo "No free slots are available in this session ";
		} else if ($x < 19) {
			echo "There are ".(20-$x)." free slots availble";
		} else if($x == 19){
			echo "There is ".(20-$x)." free slot availble";
		} else if($x >20) {
			echo "Over slot implementation.. report to admin!!!";
		}
	}	


	//echo "check done";

?>