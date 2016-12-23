        <?php

require_once('../includes/initialize.php');
if(!isset($_SESSION['admin'])) {
	header("Location: ../home.php");
}


 $email = $_SESSION['admin'];
 $sql = "SELECT * FROM AdminLoginDetails WHERE Email = '$email';";
 $result =  mysqli_query($conn,$sql);
 $userRow = mysqli_fetch_array($result);

// $sqlapp = "SELECT * FROM Applications WHERE Email = '$email';";
// $appRow = mysqli_fetch_array(mysqli_query($conn, $sqlapp));
// $email = $appRow['Email'];
$uniqID = $_GET['id'];

// if ($appRow['Status']=="Submitted Succesfully - Decision Pending") {
//     header("Location: status.php");
// }

$sqldoc = "SELECT * FROM FileUploads WHERE ApplicationID = '$uniqID';";
$docRow = mysqli_fetch_array(mysqli_query($conn, $sqldoc));

// if (isset($docRow)) {
//     header("Location: review.php");
// }

if (isset($_POST['approved'])) {
    $sqlApprove = "UPDATE Applications SET Status='Approved' WHERE ApplicationID='$uniqID'; ";
    mysqli_query($conn, $sqlApprove);
    header("Location: admin_applicants.php");
}

if (isset($_POST['rejected'])) {
    $sqlApprove = "UPDATE Applications SET Status='Rejected' WHERE ApplicationID='$uniqID'; ";
    mysqli_query($conn, $sqlApprove);
    header("Location: admin_applicants.php");
    
}

?>

<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Admin | Documents check</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>

    <body>
        <div class="anks">
            <img src="../assets/img/backgrounds/plain.jpg" class="bg">
            <?php include_once(LIB_PATH.DS.'layouts/navbar.php'); ?>
            
            <div class="top-content">
                <div style="padding-bottom: 170px">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 text" style="padding-top: 40px" >
                            <div style="color: #fff">
                            	<!-- <span class="li-text">Your Application ID is <b><?php echo $appRow['ApplicationID']; ?></b>. To Review or Edit the Application Click <a href="newapplication.php" style="color: yellow"><b>here</b></a></span> -->
                                <h1 style="color: #fff"><strong>Upload</strong> Documents</h1>
                            </div>
                            </div>
                        </div>

                            <br>

                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3 form-box">
                                <form role="form" method="POST" class="registration-form">
                                        <div class="form-top">
                                            <div class="form-top-left">
                                                <h3> The Following Documents were uploaded</h3>
                                            </div>
                                            <div class="form-top-right">
                                                <i class="fa fa-file"></i>
                                            </div>
                                        </div>
                                        <div class="form-bottom">
                                            <div class="form-group form-inline" style="text-align: center;">
                                                <a target="_blank" href="documentsimageview.php?id=<?php echo $uniqID."&file=".$docRow['PhotographName'];  ?>">Photograph</a>
                                            </div>
                            
                                            <div class="form-group form-inline" style="text-align: center;">
                                                <a target="_blank" href="documentsimageview.php?id=<?php echo $uniqID."&file=".$docRow['SignatureName']; ?>">Signature</a>
                                            </div>

                                            <div class="form-group form-inline" style="text-align: center;">
                                                <a target="_blank" href="documentsimageview.php?id=<?php echo $uniqID."&file=".$docRow['IDProofName']; ?>">ID Proof</a>
                                            </div>

                                            <div class="form-group form-inline" style="text-align: center;">
                                                <a target="_blank" href="documentsimageview.php?id=<?php echo $uniqID."&file=".$docRow['AddProofName'];?>">Address Proof</a>
                                            </div>
                                            <div align="center">
                                                <button name="approved" type='submit' id="approved" class="btn">Approve Application</button>
                                                <button name="rejected" type="submit" id="reject" class="btn btn-danger">Reject Application</button>
                                            </div> 
                                        </div>
                                    </form>
                                    


                            </div>

                            
                        </div>
                    </div>
                
                </div>
            </div>
        </div>

        <?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>
        <script src="assets/js/retina-1.1.0.min.js"></script>
        

    </body>

</html>