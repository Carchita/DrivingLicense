<?php
require_once('../includes/initialize.php');

if(!isset($_SESSION['admin'])) {
	header("Location: ../home.php");
}

date_default_timezone_set("Asia/Kolkata");

$rtoname=$_GET['rto_office'];
$email = $_SESSION['admin'];
$sql = "SELECT * FROM AdminLoginDetails WHERE Email = '$email';";
$result =  mysqli_query($conn,$sql);
$userRow = mysqli_fetch_array($result);

$sqlapp = "SELECT * FROM Applications WHERE Email = '$email' and visiting_rto='{$rtoname}';";
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
                            <div class="col-sm-12 text">
                                <h1><strong>Driving License Applications</strong></h1>
                                <div class="top-big-link">
                                   <table class="table">
                                        <tr>
                                            <th style="text-align: center;">S.No</th>
                                            <th style="text-align: center;">Applied date</td>
                                            <th style="text-align: center;">TimeStamp</td>
                                            <th style="text-align: center;">Application ID</th>
                                            <th style="text-align: center;">Full name</th>
                                            <th style="text-align: center;">Email</th>
                                            <?php if(isset(!$rtoname)) { ?><th style="text-align: center;">Preferred RTO</th><?php }; ?>
                                            <th style="text-align: center;">Status</th>
                                        </tr>
                                        <?php
                                            $sqlAdminList = "SELECT visiting_rto,TimeStamp,user_update_time,FirstName,LastName, ApplicationID, Email, Status FROM Applications ORDER BY TimeStamp DESC;";
                                            $adminListResult = mysqli_query($conn, $sqlAdminList);
                                            $counter = 1;
                                            if (mysqli_num_rows($adminListResult) > 0) {

                                                while ($appRow = mysqli_fetch_array($adminListResult)) {
                                                    if ($appRow['Status']!="Approved"){
                                                        $adminStatus = "Not Approved";
                                                    } if ($appRow['Status']=="Approved") {
                                                        $adminStatus = "Approved";
                                                    } if ($appRow['Status']=="Rejected") {
                                                        $adminStatus = "Rejected";
                                                    } 

                                                    $query = "SELECT SignatureName,PhotographName from fileuploads WHERE ApplicationID='{$appRow['ApplicationID']}' ; ";
                                                    $result = mysqli_query($conn, $query);
                                                    $filelist = mysqli_fetch_array($result);

                                                    echo "
                                                        <tr>
                                                            <td>".$counter."</td>
                                                            <td>".$appRow['user_update_time']."</td>
                                                            <td>".$appRow['TimeStamp']."</td>
                                                            <td><a target='_blank' href='adminformview.php?id=".$appRow['ApplicationID']."&signfile=".$filelist['SignatureName']."&picfile=".$filelist['PhotographName']."'><b>".$appRow['ApplicationID']."</b></a></td>
                                                            <td>".ucfirst($appRow['FirstName'])." ".ucfirst($appRow['LastName'])."</td>
                                                            <td>".$appRow['Email']."</td>";
                                                    if(isset(!$rtoname)) {
                                                        "<td><a href='rtoadmin_applicants.php?rto_office=".$appRow['visiting_rto']."' >".ucfirst($appRow['visiting_rto'])."</td>";
                                                    }
                                                    echo "<td><a href='documentscheck.php?id=".$appRow['ApplicationID']."'><b>".$adminStatus."</b></a></td>


                                                    ";
                                                    $counter++;
                                                }

                                            }
                                        

                                        ?>

                                   </table>



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