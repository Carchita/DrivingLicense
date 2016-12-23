<?php

require_once('../includes/initialize.php');
if(!isset($_SESSION['user'])) {
	header("Location: home.php");
}



// if ($_SESSION['Submitted']!=TRUE) {
//     header("Location: uploaddocs.php");
// }

$email = $_SESSION['user'];
$sql = "SELECT * FROM LoginDetails WHERE Email = '$email';";
$result =  mysqli_query($conn,$sql);
$userRow = mysqli_fetch_array($result);

$sqlapp = "SELECT * FROM Applications WHERE Email = '$email';";
$appRow = mysqli_fetch_array(mysqli_query($conn, $sqlapp));
$email = $appRow['Email'];
$uniqID = $appRow['ApplicationID'];

if ($appRow['Status']=="Saved") {
    header("Location: newapplication.php");
}

$sqldoc = "SELECT * FROM FileUploads WHERE Email = '$email';";
$docRow = mysqli_fetch_array(mysqli_query($conn, $sqldoc));



?>



<!-- Top content -->
<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Status</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>
    <body>
        <div class="anks">
            <img src="../assets/img/backgrounds/plain.jpg" class="bg">

           <?php include_once(LIB_PATH.DS."layouts/navbar.php"); ?>

     		<div class="top-content inner-bg">
                <div style="padding-bottom: 170px">
                    <div class="container">
                        <div class="row">
                            	
                            <!-- <h1 style="color: #fff"><strong>Final</strong> Submit</h1> -->

                            <div class="col-sm-8 col-sm-offset-2 text">
                                <h1>Application<strong> Status</strong></h1>
                                <br><br><br>
                                <div class="description">
                                    <span class="li-text">Your Application with ID <b><?php echo $appRow['ApplicationID']; ?></b> has been submitted succesfully.<br><br></span>
                                    <p><h4>
                                        <?php 
                                            echo $appRow['Status'];
                                        ?>
                                    </h4></p>
                                    <img alt="testing" src=<?php echo "barcode.php?codetype=Code128a&size=30&text=".$appRow['ApplicationID']."&print=true" ?> />  
                                </div>
                            </div>
                        </div>
                     </div>
                 </div>
             </div>
        </div>

        <?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>


    </body>

</html>


