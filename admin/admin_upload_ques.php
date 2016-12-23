<?php

require_once('../includes/initialize.php');
	if(!isset($_SESSION['admin'])) {
		header('Location: ../home.php');
	}	

	if(isset($_POST['Upload_ques'])) {
		$section = mysqli_real_escape_string($conn, strtolower(trim($_POST['Section'])));
		$question = mysqli_real_escape_string($conn, strtolower(trim($_POST['Question'])));
		$option1 = mysqli_real_escape_string($conn, strtolower(trim($_POST['Option-1'])));
		$option2 = mysqli_real_escape_string($conn, strtolower(trim($_POST['Option-2'])));
		$option3 = mysqli_real_escape_string($conn, strtolower(trim($_POST['Option-3'])));
		$option4 = mysqli_real_escape_string($conn, strtolower(trim($_POST['Option-4'])));
		$correct_option = mysqli_real_escape_string($conn, strtolower(trim($_POST['Option-1'])));

		
		$query = "SELECT * FROM testtopics WHERE topic = '{$section}' ; ";	
		$res = mysqli_query($conn , $query);
		if(mysqli_num_rows($res) == 0) {
			$query = "INSERT into testtopics (topic) VALUES ( '{$section}' ) ;";
			$re = mysqli_query($conn , $query);
			if(!$re) {
				die("U r a dead meat baby !!!");
			}
		}

		if(isset($_POST['file_upload'])) { $photo = yes ;} else { $photo = NULL ;};
		$query = "INSERT into onlinetest ( section , question, option1, option2, option3, option4, correct_option, photos) VALUES ( '{$section}' , '{$question}' , '{$option1}' , '{$option2}' , '{$option3}' , '{$option4}' , '{$correct_option}' , '{$photo}') ; ";
		$result = mysqli_query($conn , $query);
		if(!$result) {
			die("couldn't upload the requested query ".mysqli_error($conn));
		} else {
			$message = "Question is uploaded into the database!!  ";
		}
		if(isset($_FILES['file_upload'])) {
			$file = $_FILES['file_upload'];
			$file_name = $file['name'];
			$file_type = $file['type'];
			$file_size = $file['size'];	
			$tmp_path = $file['tmp_name'];
			$target_path = SITE_ROOT.DS."assets/img/onlinetest_pics/".$file['name'] ;
			if(move_uploaded_file($tmp_path,$target_path)) {
				$query = "INSERT INTO onlinetest_pics ( filename, type, size, question ) VALUES ( '{$file_name}' , '{$file_type}' , '{$file_size}' , '{$question}' ) ; ";
				$result = mysqli_query($conn, $query);
				if(!$result) {
					die("couldn't upload pics as per the requested query ".mysqli_error($conn));
				} else {
					$message += "Pic is uploaded into the database!!";
				}
			}
		}
	}
?>
<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Admin | Upload questions</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>
	<body>
		<div class="anks">
			<img src="../assets/img/backgrounds/plain.jpg" class="bg">
			<?php include_once(LIB_PATH.DS.'layouts/navbar.php'); ?>
			<div class="container inner-bg" >
				<div class="header" style="text-align:center; font-size: 25px;">
					<span>Upload the questions Below </span>
				</div>
				<?php if(isset($message)) { echo $message; }; ?>	
				<div class="page-content ">
					<form action="admin_upload_ques.php" enctype="multipart/form-data" method="post">
						<div class="cont-horizon">
			        		<div class="form-a-right">Section: </div>
			        		<div class="form-a-left"> 
								<select name="Section" style="font-color: black;">
									<option value="" selected> </option>
									<option value="section-1" > Section-1</option>
									<option value="section-2">Section-2</option>
									<option value="section-3">Section-3</option>
									<option value="section-4">Section-4</option>
									<option value="section-5">Section-5</option>
								</select>
							</div>		
	 					</div>
	 					<div class="cont-horizon">
			        		<div class="form-a-right">Question: </div>
			        		<div class="form-a-left">
		 						<textarea name="Question" style="" height="100px"></textarea>
							</div>	
	 					</div>
	 					<div class="cont-horizon">
			        		<div class="form-a-right">Correct answer: </div>
			        		<div class="form-a-left">
	 							<input type="text" name="Option-1">
	 						</div>	
	 					</div>
	 					<div class="cont-horizon">
			        		<div class="form-a-right">Other options: </div>
			        		<div class="form-a-left">
	 							<input type="text" name="Option-2" value="">
	 						</div>	
	 					</div>
	 					<div class="cont-horizon">
			        		<div class="form-a-right">Other options: </div>
			        		<div class="form-a-left">
	 							<input type="text" name="Option-3">
	 						</div>	
	 					</div>
	 					<div class="cont-horizon">
			        		<div class="form-a-right">Other options: </div>
			        		<div class="form-a-left">
	 							<input type="text" name="Option-4" value="">
	 						</div>	
	 					</div>
	 					<div class="cont-horizon">
			        		<div class="form-a-right">Upload picture (if any): </div>
			        		<div class="form-a-left">
	 							<input type="file" name="file_upload" \>
	 						</div>	
	 					</div>
	 					<div class="cont-horizon">
			        		<div class="form-a-right"></div>
			        		<div class="form-a-left">
		 						<input type="submit" name="Upload_ques">
		 					</div>	
	 					</div>
					</form>
				</div>
			</div>	
		</div>
	</body>
</html>