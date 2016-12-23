<?php
require_once('../includes/initialize.php');
if(!isset($_SESSION['user'])) {
	header("Location: ../home.php");
}
if($_SESSION['AppStatus']!="Saved") {
	header("Location: newapplication.php");
}



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

// if (isset($docRow)) {
//     header("Location: review.php");
// }


//UPLOADING DOCUMENTS...


    if (isset($_POST['upload']) && $_FILES['file-photo']['size']>0) {

        mkdir(SITE_ROOT.DS."assets/application images/".$uniqID);

        $fileNamePhoto = $_FILES['file-photo']['name'];
        $tmpNamePhoto = $_FILES['file-photo']['tmp_name'];
        $fileSizePhoto = $_FILES['file-photo']['size'];
        $fileTypePhoto = $_FILES['file-photo']['type'];
        $target_path = SITE_ROOT.DS."assets/application images/".$uniqID."/".$fileNamePhoto;
        move_uploaded_file($tmpNamePhoto,$target_path);

        $fp = fopen($tmpNamePhoto, 'r');
        $contentPhoto = fread($fp, filesize($tmpNamePhoto));
        $contentPhoto = addslashes($contentPhoto);
        fclose($fp);

        if (!get_magic_quotes_gpc()) {
            $fileNamePhoto = addslashes($fileNamePhoto);
        }

        $fileNameSign = $_FILES['file-sign']['name'];
        $tmpNameSign = $_FILES['file-sign']['tmp_name'];
        $fileSizeSign = $_FILES['file-sign']['size'];
        $fileTypeSign = $_FILES['file-sign']['type'];
        $target_path = SITE_ROOT.DS."assets/application images/".$uniqID."/".$fileNameSign;
        move_uploaded_file($tmpNameSign,$target_path);

        $fp = fopen($tmpNameSign, 'r');
        $contentSign = fread($fp, filesize($tmpNameSign));
        $contentSign = addslashes($contentSign);
        fclose($fp);

        if (!get_magic_quotes_gpc()) {
            $fileNameSign = addslashes($fileNameSign);
        }

        $fileNameID = $_FILES['file-id-proof']['name'];
        $tmpNameID = $_FILES['file-id-proof']['tmp_name'];
        $fileSizeID = $_FILES['file-id-proof']['size'];
        $fileTypeID = $_FILES['file-id-proof']['type'];
        $target_path = SITE_ROOT.DS."assets/application images/".$uniqID."/".$fileNameID;
        move_uploaded_file($tmpNameID,$target_path);

        $fp = fopen($tmpNameID, 'r');
        $contentID = fread($fp, filesize($tmpNameID));
        $contentID = addslashes($contentID);
        fclose($fp);

        if (!get_magic_quotes_gpc()) {
            $fileNameID = addslashes($fileNameID);
        }

        $fileNameAdd = $_FILES['file-add-proof']['name'];
        $tmpNameAdd = $_FILES['file-add-proof']['tmp_name'];
        $fileSizeAdd = $_FILES['file-add-proof']['size'];
        $fileTypeAdd = $_FILES['file-add-proof']['type'];
        $target_path = SITE_ROOT.DS."assets/application images/".$uniqID."/".$fileNameAdd;
        move_uploaded_file($tmpNameAdd,$target_path);

        $fp = fopen($tmpNameAdd, 'r');
        $contentAdd = fread($fp, filesize($tmpNameAdd));
        $contentAdd = addslashes($contentAdd);
        fclose($fp);

        if (!get_magic_quotes_gpc()) {
            $fileNameAdd = addslashes($fileNameAdd);
        }


        if (isset($docRow['ID'])) {

            $uploadQueryUpdate = "UPDATE FileUploads SET PhotographName='$fileNamePhoto', PhotographType='$fileTypePhoto', PhotographSize='$fileSizePhoto', PhotographContent='$contentPhoto', SignatureName='$fileNameSign', SignatureType='$fileTypeSign', SignatureSize='$fileSizeSign', SignatureContent='$contentSign', IDProofName='$fileNameID', IDProofType='$fileTypeID', IDProofSize='$fileSizeID', IDProofContent='$contentID', AddProofName='$fileNameAdd', AddProofType='$fileTypeAdd', AddProofSize='$fileSizeAdd', AddProofContent='$contentAdd' WHERE ApplicationID='$uniqID';";

            mysqli_query($conn, $uploadQueryUpdate);
        }



        else {

            $uploadQuery = "INSERT INTO FileUploads (ApplicationID, Email, PhotographName, PhotographType, PhotographSize, PhotographContent, SignatureName, SignatureType, SignatureSize, SignatureContent, IDProofName, IDProofType, IDProofSize, IDProofContent, AddProofName, AddProofType, AddProofSize, AddProofContent) VALUES ('$uniqID', '$email', '$fileNamePhoto', '$fileTypePhoto', '$fileSizePhoto', '$contentPhoto', '$fileNameSign', '$fileTypeSign', '$fileSizeSign', '$contentSign', '$fileNameID', '$fileTypeID', '$fileSizeID', '$contentID', '$fileNameAdd', '$fileTypeAdd', '$fileSizeAdd', '$contentAdd') ;";

            $res = mysqli_query($conn, $uploadQuery);
            if(!$res){
                die(mysqli_error($conn));
            }
        }

        $_SESSION['uploads'] = 1;

        header("Location: submitted.php");
    }

?>
<!-- Top content -->
<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Upload Documents</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>
    <body>
        <div class="anks">
            <img src="../assets/img/backgrounds/plain.jpg" class="bg">
            <?php include_once(LIB_PATH.DS.'layouts/navbar.php'); ?>
            <div class="top-content inner-bg">
                <div style="padding-bottom: 170px">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 text" style="padding-top: 40px" >
                            <div style="color: #fff">
                            	<span class="li-text">Your Application ID is <b><?php echo $appRow['ApplicationID']; ?></b>. To Review or Edit the Application Click <a href="newapplication.php" style="color: yellow"><b>here</b></a></span>
                                <h1 style="color: #fff"><strong>Upload</strong> Documents</h1>
                            </div>
                            </div>
                        </div>

                            <br>

                        <div class="row">
                            <div class="col-sm-6 col-sm-offset-3 form-box">
                                <form role="form" action="uploaddocs.php" method="POST" enctype="multipart/form-data" class="registration-form">
                                        <div class="form-top">
                                            <div class="form-top-left">
                                                <h3> The Following Documents are required to be uploaded</h3>
                                            </div>
                                            <div class="form-top-right">
                                                <i class="fa fa-file"></i>
                                            </div>
                                        </div>
                                        <input type="hidden" name="MAX_FILE_SIZE" value="1000000">
                                        <div class="form-bottom">
                                            <div class="form-group form-inline">
                                                <label for="file-photo" class="upload-label">Photograph</label>
                                                <input type="file" name="file-photo" placeholder="Photograph" class="form-control" id="file-photo">
                                            </div>
                            
                                            <div class="form-group form-inline">
                                                <label for="file-sign" class="upload-label">Signature</label>
                                                <input type="file" name="file-sign" placeholder="Signature" class="form-control" id="file-sign">
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="file-id-proof" class="upload-label">ID Proof</label>
                                                <input type="file" name="file-id-proof" class="form-control" id="file-id-proof">
                                            </div>

                                            <div class="form-group form-inline">
                                                <label for="file-id-proof" class="upload-label">Address Proof</label>
                                                <input type="file" name="file-add-proof" class="form-control" id="file-add-proof">
                                            </div>
                                            <button name="upload" type="submit" id="upload" class="btn">Upload</button>
                                            
                                        </div>
                                </form>
                            </div>
                        </div>
                    </div>
                
                </div>
            </div>
        </div>
        <?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>
    </body>

</html>