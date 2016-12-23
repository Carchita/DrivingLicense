<?php 
require_once('includes/initialize.php');

if(isset($_SESSION['user'])==TRUE) {
        header("Location: user/dashboard.php");
} else if(isset($_SESSION['admin'])) {
    header("Location: admin/index.php");
}

if(isset($_POST['submit'])) {

	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pass = mysqli_real_escape_string($conn, $_POST['password']);
	$mdpass = md5($pass);
	$sql  = "SELECT * FROM AdminLoginDetails WHERE Email='$email'";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_array($result);
	$upass = $row['Password'];

	if ($upass == $mdpass) {
		$_SESSION['admin'] = $row['Email'];
        $_SESSION['FirstName'] = $row['FirstName'];
		header("Location: admin/index.php");

	} else {
		?>
		<script>alert("Email or Password is not correct.")</script>
		<?php
	}

}


mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin | Login</title>
       

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
 <!-- CSS -->
        
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/font-awesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="assets/css/form-elements.css">
        <link rel="stylesheet" href="assets/css/style.css">

         <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="assets/ico/favicon.png">

    </head>
    <body>
        <img src="assets/img/backgrounds/1.jpg" class="bg"> 
        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><strong>Driving License</strong> Administrator Login</h1>
                            <div class="description">
                            	<p>
	                            	Please Login in below.
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Admin Login</h3>
                            		<p>Enter your admin username and password to log on:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-key"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" method="POST" class="login-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-email">Email</label>
			                        	<input type="email" name="email" placeholder="Email..." class="form-email form-control" id="form-email">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="password" placeholder="Password..." class="form-password form-control" id="form-password">
			                        </div>
			                        <button name="submit" type="submit" class="btn">Sign in</button>
			                        <!-- New User ? <a href="register.php">Sign Up</a> -->
			                    </form>
		                    </div>
                        </div>
                    </div>
                    <!--
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 social-login">
                        	<h3>New User ? <a href="register.php">Sign Up</a></h3>
                         	<div class="social-login-buttons">
	                        	<a class="btn btn-link-1 btn-link-1-facebook" href="#">
	                        		<i class="fa fa-facebook"></i> Facebook
	                        	</a>
	                        	<a class="btn btn-link-1 btn-link-1-twitter" href="#">
	                        		<i class="fa fa-twitter"></i> Twitter
	                        	</a>
	                        	<a class="btn btn-link-1 btn-link-1-google-plus" href="#">
	                        		<i class="fa fa-google-plus"></i> Google Plus
	                        	</a>
                        	</div>
                        	
                        </div>
                    </div>
                 	-->
                </div>
            </div>
            
        </div>
        <!-- Javascript -->
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/scripts.js"></script>
        <script src="assets/js/retina-1.1.0.min.js"></script>
        
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>

<!--
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>

	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

<br> <br> <br>

<div class="container">
	<div class="col-md-4">
		<form name="Login" method="POST">
			  <div class="form-group">
				    <label for="InputEmail">Email</label>
				    <input name="email" type="email" class="form-control" id="InputEmail1" placeholder="Email">
			  </div>
			  <div class="form-group">
				    <label for="InputPassword">Password</label>
				    <input name="password" type="password" class="form-control" id="InputPassword" placeholder="Password">
			  </div>
			  <button name="submit" type="submit" class="btn btn-default">Submit</button>
			  <a href="register.php">New User</a>
		</form>
	</div>
</div>


</body>
</html>
-->