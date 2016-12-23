<?php 
	require_once('../includes/initialize.php');
	if(!isset($_SESSION['admin'])) {
		header("Location: ../home.php");
	}

	

	if(isset($_POST['Upload_ques'])) {
		$ques_id = mysqli_real_escape_string($conn, strtolower(trim($_POST['q_id'])));	
		$question = mysqli_real_escape_string($conn, strtolower(trim($_POST['Question'])));
		$option1 = mysqli_real_escape_string($conn, strtolower(trim($_POST['Option-1'])));
		$option2 = mysqli_real_escape_string($conn, strtolower(trim($_POST['Option-2'])));
		$option3 = mysqli_real_escape_string($conn, strtolower(trim($_POST['Option-3'])));
		$option4 = mysqli_real_escape_string($conn, strtolower(trim($_POST['Option-4'])));
		$correct_option = mysqli_real_escape_string($conn, strtolower(trim($_POST['Option-1'])));

		$message = "";
		if(isset($_FILES['file_upload'])) {
			$file = $_FILES['file_upload'];
			$file_name = $file['name'];
			$file_type = $file['type'];
			$file_size = $file['size'];	
			$tmp_path = $file['tmp_name'];
			$target_path = SITE_ROOT.DS."assets/img/onlinetest_pics/".$file['name'] ;
			if(move_uploaded_file($tmp_path,$target_path)) {
				$query = "SELECT id FROM onlinetest_pics WHERE question = '{$question}' ; ";
				$result = mysqli_query($conn, $query);
				if(!$result) {
					die("ERROR: ".mysqli_error($conn));
				} else if(mysqli_num_rows($result)== 0) {
					$query = "INSERT into onlinetest_pics (filename, type, size,question) VALUES ('{$file_name}', '{$file_type}', '{$file_size}', '{$question}') ; " ;
					$result = mysqli_query($conn, $query);
					if(!$result) {
						die("ERROR: ".mysqli_error($conn));
					}
				} else {
					$query = "UPDATE onlinetest_pics SET filename = '{$file_name}', type = '{$file_type}', size = '{$file_size}' WHERE question = '{$question}' ; ";
					$result = mysqli_query($conn, $query);
					if(!$result) {
						die("couldn't upload pics as per the requested query ".mysqli_error($conn));
					} 
				}
				$message .= "Pic is uploaded into the database!!";
			}
		}

		if(isset($file)){
			$photo_file = " photos = 'yes' ";
		} else {
			$photo_file = "";
		}
		$query = "UPDATE onlinetest SET question = '{$question}' , option1 = '{$option1}', option2 = '{$option2}', option3 = '{$option3}' , option4 = '{$option4}', correct_option = '{$correct_option}', ".$photo_file." WHERE id = '{$ques_id}'; ";
		$result = mysqli_query($conn , $query);
		if(!$result) {
			die("couldn't update the requested query ".mysqli_error($conn));
		} else {
			$_SESSION['message'] = "Question is updated into the database!!";
		}
		if(isset($_FILES['file_upload'])) {
			$file = $_FILES['file_upload'];
			$file_name = $file['name'];
			$file_type = $file['type'];
			$file_size = $file['size'];	
			$tmp_path = $file['tmp_name'];
			$target_path = SITE_ROOT.DS."assets/img/onlinetest_pics/".$file['name'] ;
			if(move_uploaded_file($tmp_path,$target_path)) {
				$query = "UPDATE onlinetest_pics SET filename = '{$file_name}', type = '{$file_type}', size = '{$file_size}', question = '{$question}' WHERE question = '{$question}' ; ";
				$result = mysqli_query($conn, $query);
				if(!$result) {
					die("couldn't upload pics as per the requested query ".mysqli_error($conn));
				} else {
					$_SESSION['message'] .= "Pic is uploaded into the database!!";
					header("Location: admin_ques.php");
				}
			}
		}
	}

	$ques_id = $_GET['question'];
	$Check = $_GET['check'];

	if($Check == 1) {
			
		$query = "SELECT * FROM onlinetest WHERE id = '{$ques_id}' ; ";
		$result = mysqli_query($conn, $query);
		if(!$result){
			die("No such Question exists!!!");
		} else if(mysqli_num_rows($result) == 0){
			die("zero found");
		} else {
			$q_details = mysqli_fetch_array($result);
			if($q_details['photos'] == 'yes'){
				$query = "SELECT filename from onlinetest_pics WHERE question = '{$q_details['question']}' ; " ;
				$result = mysqli_query($conn, $query);
				if(!$result) {
					die("error at bringing pics details");
				} else {
					$fn = mysqli_fetch_array($result);
				}
			}
		?>
		<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
		<title>Admin | Update questions</title>
		<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
		<link rel="stylesheet" href="../assets/css/dashboard.css">
		<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>
			<body>
				<div class="anks">
					<img src="../assets/img/backgrounds/plain.jpg" class="bg">
					<?php include_once(LIB_PATH.DS.'layouts/navbar.php'); ?>
					<div class="container  inner-bg" >
						<div class="header">
								<h1>Upload the questions Below </h1>
							</div>
						<div class="page-content">
							<?php if(isset($message)) { echo $message; }; ?>	
							<div class="upload_content">
								<form action="ques_check_admin.php" enctype="multipart/form-data" method="post">
									<input type="hidden" name="q_id" value="<?php echo $_GET['question'] ?>">
				 					<div class="cont-horizon">
			        					<div class="form-a-right">Question: </div>
			        					<div class="form-a-left">
		 									<textarea name="Question" style="">
		 										<?php echo $q_details['question']; ?>
		 									</textarea>
		 								</div>	
				 					</div>
				 					<div class="cont-horizon">
						        		<div class="form-a-right">Correct answer: </div>
						        		<div class="form-a-left">
				 							<input type="text" name="Option-1" value="<?php echo $q_details['option1'] ?>">
				 						</div>	
				 					</div>
				 					<div class="cont-horizon">
						        		<div class="form-a-right">Other answer: </div>
						        		<div class="form-a-left">
				 							<input type="text" name="Option-2" value="<?php echo $q_details['option2'] ?>">
				 						</div>	
				 					</div>
				 					<div class="cont-horizon">
						        		<div class="form-a-right">Other answer: </div>
						        		<div class="form-a-left">
				 							<input type="text" name="Option-3" value="<?php echo $q_details['option3'] ?>">
				 						</div>	
				 					</div>
				 					<div class="cont-horizon">
						        		<div class="form-a-right">Other answer: </div>
						        		<div class="form-a-left">
				 							<input type="text" name="Option-4" value="<?php echo $q_details['option4'] ?>">
				 						</div>	
				 					</div>
				 					<div class="cont-horizon">
						        		<div class="form-a-right">Other answer: </div>
						        		<div class="form-a-left">
				 							<input type="file" name="file_upload" value="<?php if($q_details['photos'] == 'yes'){ echo $fn ; }; ?>">
				 						</div>	
				 					</div>
				 					<div>
				 						<input type="submit" name="Upload_ques" value="holaaa">
				 					</div>
								</form>
							</div>
						</div>	
					</div>	
				</div>
				<?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>
			</body>
		</html>	
		<?php
		};

	}
	
	if($Check == 2){
		$question = $_GET['question'] ;

		$query = "SELECT filename from onlinetest_pics WHERE question = '{$question}' ; " ;
		$result = mysqli_query($conn, $query);
		
		$filename = mysqli_fetch_array($result)['filename'];

		//deleting the data from onlinetest_pics, from images folder and from online test
		$query = "DELETE from onlinetest_pics WHERE question = '{$question}' ; ";
		$result = mysqli_query($conn, $query);
		unlink(SITE_ROOT.DS."assets/img/onlinetest_pics/".$filename);
		$query = "DELETE from onlinetest WHERE id='{$ques_id}' ; " ;
		$result = mysqli_query($conn, $query);
		if(!$result || mysqli_num_rows($result) == 0) {
			die('there isnt any question');
		} else {
			$_SESSION['message'] .= "Question is removed from the database!!";
			header("Location: admin_ques.php");
		}

	}
?>