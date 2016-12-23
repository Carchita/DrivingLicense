<?php
require_once('../includes/initialize.php');
if(!isset($_SESSION['user'])) {
	header("Location: ../home.php");
}

date_default_timezone_set("Asia/Kolkata");


$email = $_SESSION['user'];
$sql = "SELECT * FROM LoginDetails WHERE Email = '$email';";
$result =  mysqli_query($conn,$sql);
$userRow = mysqli_fetch_array($result);

$sqlapp = "SELECT ApplicationID,Status,SlotStatus FROM Applications WHERE Email = '$email';";
$appRow = mysqli_fetch_array(mysqli_query($conn, $sqlapp));

if (isset($appRow["ApplicationID"])) {
    ?>
    <script>
    function ButtonsEdit() {
        document.getElementById('NewApplication').disabled = true; 
        document.getElementById('ResumeApplication').disabled = false;
        ButtonsEdit2();
    }
    </script>
    <?php
}

if ($appRow['Status']=="Submitted Succesfully - Decision Pending" OR $appRow['Status']=="Approved" OR $appRow['Status']=="Rejected") {
    ?>
    <script>
    function ButtonsEdit2() {
        document.getElementById('ResumeApplication').disabled = true; 
        document.getElementById('StatusApplication').disabled = false; 
        ButtonsEdit3();
    }
    </script>
    <?php
    
};

$query = "SELECT date, slot from slotbooking WHERE email='$email' ;";
$res = mysqli_query($conn, $query);
$slotlist = mysqli_fetch_array($res);

$now = date('Y-m-d');
echo $now;
?>




<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Dashboard</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>

    <body onload="ButtonsEdit()">
        <div class="anks">
            <img src="../assets/img/backgrounds/plain.jpg" class="bg">
    		<?php include_once(LIB_PATH.DS."layouts/navbar.php"); ?>

            <!-- Top content -->
            <div class="top-content">
            	
                <div class="inner-bg" >
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12 text">
                                <h1><strong>Driving License</strong> Application Form</h1>
                                <div class="top-big-link">
                                    <button id="NewApplication" onclick="location.href='newapplication.php'" type="button" class="btn btn-primary" style="background-color: #4CAF50">Apply for License Now</button>
                                    <button id="ResumeApplication" onclick="location.href='newapplication.php'" type="button" disabled="true" class="btn btn-primary">Resume Application</button>
                                    <button id="StatusApplication" onclick="location.href='status.php'" type="button" disabled="true" class="btn btn-warning" style="background-color: #f0ad4e">Check Status</button>
                                    <?php if($appRow['Status']=="Approved"&&$appRow['SlotStatus']=="No") {   ?>
                                    <button id="SlotBooking" onclick="location.href='SlotBooking.php'" type="button" class="btn btn-primary" style="background-color: #4CAF50">Book your slot here</button>
                                    <?php };
                                        if($appRow['SlotStatus']=="Yes"&&$now==$slotlist['date']) {  ?>
                                    <button id="OnlineTest" onclick="location.href='OnlineTest.php'" type="button" class="btn btn-primary" style="background-color: #f0ad4e">Start Online Test</button>        

                                           <?php } ?>
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