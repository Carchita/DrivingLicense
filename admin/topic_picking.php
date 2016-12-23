<?php 
	require_once('../includes/initialize.php');
	if(!isset($_SESSION['admin'])) {
		header("Location: ../home.php");
	}

	// All the questions are stored in the below array set.. To use it uncomment the code!!
	//word wise search component

	/* $q = "SELECT * FROM onlinetest";
	$r = mysql_query($conn, $q);
	if($r){
		die("problem at all ques.");
	} else {
		$all_questions = mysqli_fetch_array($r);
	} */

	// topic-wise search component
	$Topic = $_GET['topic'];

	$query = "SELECT * FROM onlinetest WHERE section = '{$Topic}' ;" ;
	$result = mysqli_query($conn, $query);
	if(!$result) {
		die("NO TOPIC FOUND");	
	} else if (mysqli_num_rows($result) == 0) {
		die("holaa");
	} else {
		$count = 0 ;
		$output = "<tr class=\"admin-table-header\"><th class=\"th1\">S.No</th><th class=\"th2\">Question</th>";
		$output .= "<th class=\"th3\">Choices</th><th class=\"th4\">Modification Tools</th></tr>";
		while($questions = mysqli_fetch_array($result)){
			$count++;	
			
			$output .= "<tr class=\" admin-table-contents\"><td class=\"td1\">".$count;
			$output .= "</td><td class=\"td2\">". $questions['question'];
			if($questions['photos'] == 'yes'){
				$q = "SELECT filename from onlinetest_pics WHERE question = '{$questions['question']}' ; " ;
				$r = mysqli_query($conn, $q);
				if(!$r) {
					die("error at bringing pics details");
				} else {
					$fn = mysqli_fetch_array($r);
				}
				$output .= "<img src=\"../assets/img/onlinetest_pics/".$fn['filename']."\" height=\"200px\" > ";
			}
			$output .= "</td><td class=\"td3\"><ol>";

			$k =0;
			while($k<4){
				$k++;
				$output .= "<li id=\"ans".$k."\">".ucfirst($questions['option'.$k]);
				if($k==1) { 
					$output .= "(Correct Option)"; 
				}; 
				$output .= "</li>" ; 
			}
			$output .= "</ol></td><td class=\"td4\">";
			$output .= "<a id=\"edit_ques\" href=\"ques_check_admin.php?question=".$questions['id']."&check=1\">Edit</a><br>";
			$output .= "<a  id=\"del_ques\" href=\"ques_check_admin.php?question=".$questions['id']."&check=2&question=".$questions['question']."\">Delete</a>";
			$output .= "</td></tr>";
		}
	}

	echo $output;
?>