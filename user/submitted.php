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

// if ($appRow['Status']=="Submitted Succesfully - Decision Pending") {
//     header("Location: status.php");
// }

$sqldoc = "SELECT * FROM FileUploads WHERE Email = '$email';";
$docRow = mysqli_fetch_array(mysqli_query($conn, $sqldoc));

if (isset($_POST['finalSubmit'])) {
    $_SESSION['Submitted'] = TRUE;
    $sqlfinalSubmit = "UPDATE Applications SET Status='Submitted Succesfully - Decision Pending' WHERE ApplicationID='$uniqID';";
    mysqli_query($conn, $sqlfinalSubmit);
    header("Location: status.php");
}


?>



<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Submission</title>
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
                            <div class="col-sm-12 text" style="padding-top: 40px" >
                            <div style="color: #fff">
                            	<span class="li-text">Your Application with ID <b><?php echo $appRow['ApplicationID']; ?></b> has been saved and the Documents have been uploaded succesfully.<br><br>Read the following Terms and Conditions and Submit the application. </span><b><br>...<br>...<br>...<br>...<br></b>
                                <!-- <h1 style="color: #fff"><strong>Final</strong> Submit</h1> -->

                                <input type="checkbox" name="termsCheck" id="termsCheck" onchange="enableButton()"><label for="termsCheck">&nbsp; I Agree to the Terms and Conditions.</label><br>
                                <form method="POST">
                                <button name='finalSubmit' onclick="FinalSubmit();" type="submit" disabled class="btn btn-success" style="background-color: #4cae4c" style="border-color: #4cae4c" id="finalSubmit">Final Submit</button>
                                </form>
                            </div>
                            </div>
                        </div>
                     </div>
                 </div>
             </div>
        </div> 

       <?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>

        <script>
            
            function enableButton() {
                if (document.getElementById('termsCheck').checked) {
                    document.getElementById('finalSubmit').disabled = false;
                }
                else {
                    document.getElementById('finalSubmit').disabled = true;
                }
                
            }


        </script>

    </body>

</html>


