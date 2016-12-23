<?php 

	include_once('../includes/initialize.php');
	if(!isset($_SESSION['admin'])) {
		header("Location: ../adminlogin.php");
	}

	if(isset($_POST['Signup_RTO'])) {

		$rto_name = mysqli_escape_string($conn,trim($_POST['RTO_name']));
		$rto_location = mysqli_escape_string($conn,trim($_POST['RTO_location']));
		$username = mysqli_escape_string($conn,trim($_POST['RTO_username']));
		$original_pw = mysqli_escape_string($conn,trim($_POST['RTO_password']));
		$hashed_pw = md5($original_pw);

		$query = "SELECT * FROM rto_signup WHERE username = '{$username}' ; ";
		$result = mysqli_query($conn, $query);
		if(!$result) {
			die("ERROR: ".mysqli_error($conn));
		} else {
			if (mysqli_num_rows($result)!=0) {
				$message= "user already exists";
			} else {

				$query = "INSERT INTO rto_signup (rto_name, rto_location, username, hashed_pw, original_pw ) VALUES ('{$rto_name}', '{$rto_location}', '{$username}', '{$hashed_pw}', '{$original_pw}') ;";
				$result = mysqli_query($conn, $query);
				if(!$result) {
					die("ERROR: " . mysqli_error($conn));
				} else {
					$message = "Successfully created account!"; 
				}
			}
		}
	}
	


?>
<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Admin | applicants</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>

    <body onload="ButtonsEdit()">
        <div class="anks">    
            <img src="../assets/img/backgrounds/plain.jpg" class="bg">
            <?php include_once(LIB_PATH.DS.'layouts/navbar.php') ?>
            <div class="container inner-bg" >
				<div class="header">
					<h1><strong>Create RTO credentials</strong></h1>
				</div>
				<h2><?php echo $message; ?></h2>
				<div class="page-content">
					<form action="admin_rto_signup.php" method="POST">
						<div class="cont-horizon">
							<div class="form-a-right">
								Name of the RTO
							</div>
							<div class="form-a-left">
								<input type="text" name="RTO_name" placeholder="Enter RTO name" value="">
							</div>
						</div>
						<div class="cont-horizon">
							<div class="form-a-right">
								Location of the RTO
							</div>
							<div class="form-a-left">
								<input type="text" name="RTO_location" placeholder="Enter RTO Location" value="">
							</div>
						</div>	
						<div class="cont-horizon">
							<div class="form-a-right">
								Username for RTO
							</div>
							<div class="form-a-left">
								<input type="text" name="RTO_username" placeholder="Enter Username" value="">
							</div>
						</div>
						<div class="cont-horizon">
							<div class="form-a-right">
								Password for RTO
							</div>
							<div class="form-a-left">
								<input id="pw" type="password" name="RTO_password" min="8" placeholder="Enter password" value="">
								<span id="pw_toggle">show</span>
							</div>
						</div>
						<div class="cont-horizon">
							<div class="form-a-right">
								Password for RTO
							</div>
							<div class="form-a-left">
								<input id="rpw" type="password" name="RTO_password" placeholder="Verify password" value="">
								<span id="rpw_toggle">show</span>
							</div>
							
						</div>
						<div id="notify"></div>
						<div class="cont-horizon">
							<div class="form-a-right">	
							</div>
							<div class="form-a-left notify1">
								Password should contain atleast 1 capital, 1 number and minimum of 8 characters long 
							</div>
						</div>
						<div class="cont-horizon">
							<div class="form-a-right">	
							</div>
							<div class="form-a-left">
								<input id="submit" type="submit" name="Signup_RTO" value="Signup Now">
							</div>
						</div>
					</form>	
				</div>	
			</div>	
        </div>
        <?php include_once(LIB_PATH.DS."layouts/js_initialize.php"); ?>
 		<script type="text/javascript">
 			$(document).ready(function(){
 				$("#pw_toggle, #rpw_toggle").click(function(){
 					text = $(this).html();
 					if(text == "show" ){
 						$(this).html("hide");
 						$(this).prev().attr("type","text");
 					} else if(text = "hide") {
 						$(this).html("show");
 						$(this).prev().attr("type","password");
 					};
 				});
 				$("#rpw").keyup(function(){
 					rpw = $(this).val();
 					pw = $("#pw").val();
 					if((rpw == pw) && (rpw!="") && (pw!="") ){
 						$("#notify").html("Passwords matched").css('color','green');
 					} else {
 						$("#notify").html("Passwords didn't match").css('color','red');	
 					}
 					if((pw !="") && (rpw == "")) {
 						$("#notify").html("");
 					}
 				});
 			});
 		</script>
    </body>
</html>
<?php mysqli_close($conn); ?>           



