<?php 
require_once('includes/initialize.php');
if(isset($_SESSION['user'])) {
	header("Location: ".SITE_ROOT.DS."user/dashboard.php");
}


if(isset($_POST['submit'])) {
	$firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
	$lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$pass = md5($_POST['password']);

	$check = "SELECT * FROM LoginDetails WHERE Email='$email'";
	$checkResult = mysqli_query($conn, $check);
	$checkRow = mysqli_fetch_array($checkResult);

	if ($checkRow['Email']!=$email) {
		$sql  = "INSERT INTO LoginDetails (FirstName, LastName, Email, Password) VALUES ('$firstname', '$lastname', '$email', '$pass');";
		if(mysqli_query($conn, $sql)) { ?>
			<h4 style="color: white">Succesfully Registered !</h4>
			<?php
		} else { ?>
			<script>alert("Ooops, There was some error.")</script>
			<?php
		}
	} else { ?>
			<script>alert("The Username already exists.")</script>
			<?php
	}

}

?>


<style>
	body:before {
	  content: "";
	  display: block;
	  position: fixed;
	  left: 0;
	  top: 0;
	  width: 100%;
	  height: 100%;
	  z-index: -10;
	  background: url(photos/2452.jpg) no-repeat center center;
	  -webkit-background-size: cover;
	  -moz-background-size: cover;
	  -o-background-size: cover;
	  background-size: cover;
	}
</style>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Admin | Register</title>

       

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
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="assets/ico/apple-touch-icon-144-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="assets/ico/apple-touch-icon-114-precomposed.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="assets/ico/apple-touch-icon-72-precomposed.png">
        <link rel="apple-touch-icon-precomposed" href="assets/ico/apple-touch-icon-57-precomposed.png">

    </head>
    <body>
    	<img src="assets/img/backgrounds/1.jpg" class="bg"> 

        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-7 text">
                            <h1><strong>New User</strong> Registration Form</h1>
                            <div class="description">
                            	<p>
	                            	Fill in the form to get registed at our site so that the the process for the application for Driving License can be started.
                            	</p>
                            </div>
                            <div class="top-big-link">
                            	<p> Already Registered ?</p>
                            	<a class="btn btn-link-1" href="home.php">Log In</a>
                            </div>
                        </div>
                        <div class="col-sm-5 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Sign up now</h3>
                            		<p>Fill in the form below to register:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-pencil"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form name="Login" role="form" method="POST" class="registration-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-first-name">First name</label>
			                        	<input type="text" name="firstname" placeholder="First Name" class="form-first-name form-control" id="form-first-name">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-last-name">Last name</label>
			                        	<input type="text" name="lastname" placeholder="Last Name" class="form-last-name form-control" id="form-last-name">
			                        </div>
			         
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-email">Email</label>
			                        	<input type="email" name="email" placeholder="Email" class="form-email form-control" id="form-email">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">Password</label>
			                        	<input type="password" name="password" placeholder="Password" class="form-password form-control" id="form-password">
			                        </div>
			                        <button id="loginButton" name="submit" type="submit" class="btn">Sign me up!</button>
			                    </form>
		                    </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
 		

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
    <label for="InputFirstname">First Name</label>
    <input name="firstname" type="Name" class="form-control" id="exampleInputEmail1" placeholder="First Name">
  </div>
    <div class="form-group">
    <label for="InputLastname">Last Name</label>
    <input name="lastname" type="Name" class="form-control" id="exampleInputEmail1" placeholder="Last Name">
  </div>
  <div class="form-group">
    <label for="InputEmain">Email</label>
    <input name="email" type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
  </div>
  <div class="form-group">
    <label for="InputPassword1">Password</label>
    <input name="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
  </div>
  <button name="submit" type="submit" class="btn btn-default">Create</button>
</form>
</div>
</div>


</body>
</html>
-->