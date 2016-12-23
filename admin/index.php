<?php
require_once('../includes/initialize.php');

if(!isset($_SESSION['admin'])) {
	header("Location: ../home.php");
}

date_default_timezone_set("Asia/Kolkata");


$email = $_SESSION['admin'];
$sql = "SELECT * FROM AdminLoginDetails WHERE Email = '$email';";
$result =  mysqli_query($conn,$sql);
$userRow = mysqli_fetch_array($result);

$sqlapp = "SELECT * FROM Applications WHERE Email = '$email';";
$appRow = mysqli_fetch_array(mysqli_query($conn, $sqlapp));


?>





<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Admin | applicants</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>

    <body onload="ButtonsEdit()">
        <div class="anks">    
            <img src="../assets/img/backgrounds/plain.jpg" class="bg">
            <?php include_once(LIB_PATH.DS.'layouts/navbar.php') ?>

            <!-- Top content -->
            <div class="top-content">
            	
                <div class="inner-bg" >
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 text">
                                <h1><strong>Driving License</strong> Admin Dashboard</h1>
                                <h3><a href="admin_applicants.php">Applicantions</a></h3>
                                <h3><a href="admin_ques.php">Online Test Questions</a></h3>
                                <h3><a href="admin_rtos_view.php">View All RTOs</a></h3>
                                <h3><a href=""></a></h3>
                            </div>

                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>

    </body>


</html>