<?php
require_once('../includes/initialize.php');
if(!isset($_SESSION['user'])) {
	header("Location: ../home.php");
}





$email = $_SESSION['user'];
$sqllogin = "SELECT * FROM LoginDetails WHERE Email = '$email';";
$result =  mysqli_query($conn,$sqllogin);
$userRow = mysqli_fetch_array($result);
$firstname = $userRow['FirstName'];
$lastname = $userRow['LastName'];

$sqlapp = "SELECT * FROM Applications WHERE Email = '$email';";
$appRow = mysqli_fetch_array(mysqli_query($conn, $sqlapp));



if ($appRow['Status']=="Submitted Succesfully - Decision Pending") {
	header("Location: status.php");
}

if (isset($appRow["ApplicationID"])) {
	$uniqID = $appRow["ApplicationID"];
	$userRow['LastName'] = $appRow['LastName'];
	$userRow['FirstName'] = $appRow['FirstName'];
	$userRow['Email'] = $appRow['Email'];
	$_SESSION['AppStatus']="Saved";

} else {
	$chars=array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	$random_key = array_rand($chars, 1);
	$uniqID = strtoupper(uniqid($chars[$random_key]));
	$sqladdID = "INSERT INTO Applications (ApplicationID, Email) VALUES ('$uniqID', '$email');";
	if(!mysqli_query($conn, $sqladdID)) {
		echo mysqli_error($conn);
	}

}



if(isset($_POST['formsubmit'])) {
	
	// recheck whether the user has filed up an application
	/*$query = "SELECT Status FROM Applications WHERE Email = '{$email}' ;";
	$result = mysqli_query($conn, $result);
	if(!$result){
		die("Error above personal details");
	} else {
		if(mysqli_num_rows($result) !=0 ){
			header("Location: index.php");
		}
	}*/

	//Personal Details
	$formfirstname = mysqli_real_escape_string($conn, $_POST['form-first-name']);
	$formlastname = mysqli_real_escape_string($conn, $_POST['form-last-name']);
	$formdob = $_POST['form-dob'];
	$formfathersname = mysqli_real_escape_string($conn, $_POST['form-father-name']);
	$formbloodgroup = mysqli_real_escape_string($conn, $_POST['form-blood-group']);
	$formadhaar = mysqli_real_escape_string($conn, $_POST['form-adhaar']);
	$formeduqua = mysqli_real_escape_string($conn, $_POST['form-edu-qua']);
	$formeidenmarks = mysqli_real_escape_string($conn, $_POST['form-iden-marks']);
	//Contact Details
	$formemail = $email;
	$formmobile = $_POST['form-mob'];
	$formtelephone = $_POST['form-telephone'];
	$formtempstreet = mysqli_real_escape_string($conn, $_POST['form-temp-add-street']);
	$formtempcity = mysqli_real_escape_string($conn, $_POST['form-temp-add-city']);
	$formtempstate = mysqli_real_escape_string($conn, $_POST['form-temp-add-state']);
	$formtemppin = mysqli_real_escape_string($conn, $_POST['form-temp-add-pin']);
	$formperstreet = mysqli_real_escape_string($conn, $_POST['form-per-add-street']);
	$formpercity = mysqli_real_escape_string($conn, $_POST['form-per-add-city']);
	$formperstate = mysqli_real_escape_string($conn, $_POST['form-per-add-state']);
	$formperpin = mysqli_real_escape_string($conn, $_POST['form-per-add-pin']);
	//License Details
	$formefflicense = $_POST['form-eff-license'];
	$formeffvalid = $_POST['form-eff-validity'];
	$formprevlicense = $_POST['form-prev-license'];
	$formprevnumber = $_POST['form-prev-learner-add'];
	$formdisqlicense = $_POST['form-disq-license'];
	$formdisqreason = $_POST['form-disq-license-add'];
	$formapplyfor = $_POST['form-apply-license'];
	$formnearestRTO = $_POST['form-nearest-RTO'];
	$status = "Saved";




	$sqladd = "UPDATE Applications SET TimeStamp=now(),user_update_time = now(), FirstName='$formfirstname', LastName='$formlastname', DateOfBirth='$formdob',FathersName='$formfathersname', BloodGroup='$formbloodgroup', AdhaarNumber='$formadhaar', EducationalQualifications='$formeduqua', IdentificationMarks='$formeidenmarks', Email='$email', Mobile='$formmobile', Telephone='$formtelephone', TempStreet='$formtempstreet', TempCity='$formtempcity', TempState='$formtempstate', TempPincode='$formtemppin', PerStreet='$formperstreet', PerCity='$formpercity', PerState='$formperstate', PerPincode='$formperpin', EffectiveLicense='$formefflicense', EffectiveLicenseValidity='$formeffvalid', PreviousLicense='$formprevlicense', PreviousLicenseNumber='$formprevnumber', visiting_rto = '$formnearestRTO', EverDisqualified='$formdisqlicense', DisqualificationReason='$formdisqreason', ApplyForLicense='$formapplyfor', Status='$status', SlotStatus='No', attempt = '0' WHERE ApplicationID='$uniqID' ;" or die(mysql_error($conn));

	mysqli_query($conn, $sqladd);
	// if (mysqli_query($conn, $sqladd)) {
	// 	echo "Submitted!";
	// } else {
	// 	echo mysqli_error($conn);
	// }

	header("Location: uploaddocs.php");	

}

?>







<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>New Application</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>
    <body>
	    <div class="anks">	
	    	<img src="../assets/img/backgrounds/plain.jpg" class="bg">
			<!-- Top menu -->
			<nav class="navbar navbar-inverse navbar-no-bg" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#top-navbar-1">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="index.html">Driving License Application</a>
					</div>
					<!-- Collect the nav links, forms, and other content for toggling -->
					<div class="collapse navbar-collapse" id="top-navbar-1">
						<ul class="nav navbar-nav navbar-right">
							<li>
								<span class="li-text">
									<strong>Application ID : <?php echo $uniqID; ?></strong>&nbsp; &nbsp; &nbsp; Welcome, <?php echo $userRow['FirstName'] ; ?>
								</span> 
								&nbsp; &nbsp; &nbsp; <a href="logout.php?logout"><strong>Logout</strong></a> 
								<span class="li-text">
								
								</span> 
								
							</li>
						</ul>
					</div>
				</div>
			</nav>

	        <!-- Top content -->
	        <div class="top-content">
	        	
	            <div class="inner-bg">
	                <div class="container">
	                    <div class="row">
	                        <div class="col-sm-8 col-sm-offset-2 text">
	                            <h1>Driving License <strong>Application</strong></h1>
	                            <div class="description">
	                            	<p>
		                            	Fill the below multi-step application form. The form can also be resumed and edited later.
	                            	</p>
	                            </div>
	                        </div>
	                    </div>
	                    <div class="row">
	                        <div class="col-sm-6 col-sm-offset-3 form-box">
	                        	
	                        	<form role="form" action="" method="POST" class="registration-form" action="uploaddocs.php">
	                        		
	                        		<fieldset>
			                        	<div class="form-top">
			                        		<div class="form-top-left">
			                        			<h3>Step 1 / 3</h3>
			                            		<p>Personal Details:</p>
			                        		</div>
			                        		<div class="form-top-right">
			                        			<i class="fa fa-user"></i>
			                        		</div>
			                            </div>
			                            <div class="form-bottom">
					                    	<div class="form-group">
					                    		<label for="form-first-name">First Name</label>
					                        	<input type="text" name="form-first-name" placeholder="Firstname" class="form-first-name form-control" id="form-first-name" value="<?php echo $userRow['FirstName']; ?>">
					                        </div>
					        
					                        <div class="form-group">
					                        	<label for="form-last-name">Last Name</label>
					                        	<input type="text" name="form-last-name" placeholder="Lastname" class="form-last-name form-control" id="form-last-name" value="<?php echo $userRow['LastName']; ?>">
					                        </div>
					                        <div class="form-group">
					                    		<label for="form-dob">Date of Birth</label>
					                        	<input type="date" name="form-dob" placeholder="Date of Birth" class="form-dob form-control" id="form-dob" value="<?php echo $appRow['DateOfBirth']; ?>">
					                        </div>
	                                        <div class="form-group">
	                                            <label for="form-father-name">Father's Name</label>
	                                            <input type="text" name="form-father-name" placeholder="Father's Name" class="form-last-name form-control" id="form-father-name" value="<?php echo $appRow['FathersName']; ?>">
	                                        </div>
					                        <div class="form-group">
	                                            <label for="form-blood-group">Blood Group</label>
	                                            <input type="text" name="form-blood-group" placeholder="Blood Group" class="form-blood-group form-control" maxlength="3" id="form-blood-group" value="<?php echo $appRow['BloodGroup']; ?>">
	                                        </div>

	                                         <div class="form-group">
	                                            <label for="form-adhaar">Adhaar Number</label>
	                                            <input type="text" name="form-adhaar" placeholder="Adhaar No." class="form-blood-group form-control" id="form-adhaar" value="<?php echo $appRow['AdhaarNumber']; ?>">
	                                        </div>

	                                        <div class="form-group">
	                                            <label for="form-edu-qua">Educational Qualifications</label>
	                                            <select name="form-edu-qua" class="form-edu-qua form-control" id="form-edu-qua">
	                                            	<option <?php if($appRow['EducationalQualifications']=="12th Pass") {echo "selected";}  ?>>12th Pass</option>
													<option <?php if($appRow['EducationalQualifications']=="Agricultural Sciences") {echo "selected";}  ?>>Agricultural Sciences</option>
													<option <?php if($appRow['EducationalQualifications']=="Architecture") {echo "selected";}  ?>>Architecture</option>
													<option <?php if($appRow['EducationalQualifications']=="B.E<") {echo "selected";}  ?>>B.E</option>
													<option <?php if($appRow['EducationalQualifications']=="B.Ed") {echo "selected";}  ?>>B.Ed</option>
													<option <?php if($appRow['EducationalQualifications']=="B.Sc") {echo "selected";}  ?>>B.Sc</option>
													<option <?php if($appRow['EducationalQualifications']=="B.Tech") {echo "selected";}  ?>>B.Tech</option>
													<option>BA</option>
													<option>Bachelor in Optometry</option>
													<option>Bachelor in Psychology</option>
													<option>Bachelor of Ayurvedic Medicine and Surgery – BAMS</option>
													<option>Bachelor of Fire Engineering</option>
													<option>Bachelor of Homoeopathic Medicine and Surgery (BHMS)</option>
													<option>Bachelor of Law</option>
													<option>BCA</option>
													<option>BSW</option>
													<option>CA</option>
													<option>CAIIB</option>
													<option>Chemical/Refinery and Petrochemical Engineering</option>
													<option>Computer Programming</option>
													<option>Degree in Aeronautical Engineering</option>
													<option>Degree in Biotechnology</option>
													<option>Degree in Chemistry</option>
													<option>Degree in Fishery Science</option>
													<option>Degree in Guitar</option>
													<option>Degree in Harmonium</option>
													<option>Degree in Home Science</option>
													<option>Degree in Library Science</option>
													<option>Degree in Mandolin</option>
													<option>Degree in Nutrition</option>
													<option>Degree in Physiotherapy</option>
													<option>Degree in Synthesizer</option>
													<option>Dental Studies</option>
													<option>Diploma in Agriculture</option>
													<option>Diploma in Catering</option>
													<option>Diploma in Civil Engineering</option>
													<option>Diploma in Conservation</option>
													<option>Diploma in Electrical Communication</option>
													<option>Diploma in Electronic Communication</option>
													<option>Diploma in Engineering</option>
													<option>Diploma in Engineering</option>
													<option>Diploma in Film and Video Editing</option>
													<option>Diploma in Finance and Accounts</option>
													<option>Diploma in Mechanical or Electrical Engineering</option>
													<option>Diploma in Nursing</option>
													<option>Diploma in Surveying</option>
													<option>Diploma in Telecommunication</option>
													<option>Diploma in Thermal Power Plant Engineering</option>
													<option>Diploma in TV/Radio Production</option>
													<option>DM</option>
													<option>DNB</option>
													<option>Electrical Engineering</option>
													<option>Graduate</option>
													<option>Hindi</option>
													<option>ICAI</option>
													<option>ICWA</option>
													<option>ITI</option>
													<option>LLB</option>
													<option>M. Phil in Physical Education</option>
													<option>M.B.B.S</option>
													<option>M.Ch</option>
												</select>
	                                        </div>

	                                        <div class="form-group">
					                        	<label for="form-about-yourself">Identification Marks</label>
					                        	<textarea name="form-iden-marks" placeholder="Identification Marks..." 
					                        				class="form-iden-marks form-control" id="form-iden-marks"><?php echo $appRow['IdentificationMarks']; ?></textarea>
					                        </div>
					                        <button type="button" id="save1" name="save1" class="btn btn-next">Next</button>
					                    </div>
				                    </fieldset>
				                    
				                    <fieldset>
			                        	<div class="form-top">
			                        		<div class="form-top-left">
			                        			<h3>Step 2 / 3</h3>
			                            		<p>Contact Details :  </p>
			                        		</div>
			                        		<div class="form-top-right">
			                        			<i class="fa fa-phone"></i>
			                        		</div>
			                            </div>
			                            <div class="form-bottom">

			                            	<div class="form-group">
					                    		<label for="form-email">Email</label>
					                        	<input disabled type="email" name="form-email" placeholder="Email" class="form-email form-control" id="form-email" value="<?php echo $userRow['Email'];?>">
					                        </div>

					                        <div class="form-group">
					                    		<label for="form-mob">Mobile</label>
					                    		<div class="form-inline">
						                    		<input type="text" style="width: 80px" name="county-code" value="+91" disabled class="form-control">
						                        	<input type="text" style="width: 135px" name="form-mob" placeholder="" class="form-mob form-control" id="form-mob" maxlength="11" value="<?php echo $appRow['Mobile']; ?> ">
					                        	</div>
					                        </div>

					                        <div class="form-group">
					                    		<label for="form-telephone">Telephone</label>
					                        	<input type="number" style="width: 212px" name="form-telephone" placeholder="Telephone" class="form-tele form-control" id="form-tele" value="<?php echo $appRow['Telephone']; ?>" >
					                        </div>

					                        <div class="form-group">
					                        	<label for="form-temp-address">Temporary Address</label>
					                        	<textarea name="form-temp-add-street" placeholder="Street Address" class="form-temp-address form-control" id="form-temp-add-street"><?php echo $appRow['TempStreet']; ?></textarea>
					                        	<input type="text" name="form-temp-add-city" placeholder="City" class="form-control" id=
					                        	"form-temp-add-city" value="<?php echo $appRow['TempCity']; ?>">
					                        	<input type="text" name="form-temp-add-state" placeholder="State" class="form-control" id="form-temp-add-state" list="states" value="<?php echo $appRow['TempState']; ?>">
					                        	<datalist id="states">
					                        		<option value="Andhra Pradesh"/>
													<option value="Arunachal Pradesh"/>
													<option value="Assam"/>
													<option value="Bihar"/>
													<option value="Chhattisgarh"/>
													<option value="Goa"/>
													<option value="Gujarat"/>
													<option value="Haryana"/>
													<option value="Himachal Pradesh"/>
													<option value="Jammu and Kashmir"/>
													<option value="Jharkhand"/>
													<option value="Karnataka"/>
													<option value="Kerala"/>
													<option value="Madhya Pradesh"/>
													<option value="Maharashtra"/>
													<option value="Manipur"/>
													<option value="Meghalaya"/>
													<option value="Mizoram"/>
													<option value="Nagaland"/>
													<option value="Odisha"/>
													<option value="Punjab"/>
													<option value="Rajasthan"/>
													<option value="Sikkim"/>
													<option value="Tamil Nadu"/>
													<option value="Telangana"/>
													<option value="Tripura"/>
													<option value="Uttar Pradesh"/>
													<option value="Uttarakhand"/>
													<option value="West Bengal"/>
													<option value="Andaman and Nicobar"/>
													<option value="Chandigarh"/>
													<option value="Dadra and Nagar Haveli"/>
													<option value="Daman and Diu"/>
													<option value="Delhi"/>
													<option value="Lakshadweep"/>
													<option value="Pondicherry"/>
					                        	</datalist>
					                        	<input type="number" name="form-temp-add-pin" placeholder="Pincode" class="form-temp-address form-control" id="form-temp-add-pin" value="<?php echo $appRow['TempPincode']; ?>">
					                        </div>


					                        <div class="form-group">
					                    		<label for="form-add-check"><input type="checkbox" name="form-add-check" class="form-add" onclick="FillAddress()" id="form-add-check"> Tick if Pemanent Address is same.</label>
					                        	
					                        </div>


					                        <div class="form-group">
					                        	<label for="form-per-address">Permanent Address</label>
					                        	<textarea name="form-per-add-street" placeholder="Street Address" class="form-per-address form-control" id="form-per-add-street"><?php echo $appRow['PerStreet']; ?></textarea>
					                        	<input type="text" name="form-per-add-city" placeholder="City" class="form-control" id=
					                        	"form-per-add-city" value="<?php echo $appRow['PerCity']; ?>">
					                        	<input type="text" name="form-per-add-state" placeholder="State" class="form-control" id=
					                        	"form-per-add-state" list="states" value="<?php echo $appRow['PerState']; ?>">
					                        	<datalist id="states">
					                        		<option value="Andhra Pradesh"/>
													<option value="Arunachal Pradesh"/>
													<option value="Assam"/>
													<option value="Bihar"/>
													<option value="Chhattisgarh"/>
													<option value="Goa"/>
													<option value="Gujarat"/>
													<option value="Haryana"/>
													<option value="Himachal Pradesh"/>
													<option value="Jammu and Kashmir"/>
													<option value="Jharkhand"/>
													<option value="Karnataka"/>
													<option value="Kerala"/>
													<option value="Madhya Pradesh"/>
													<option value="Maharashtra"/>
													<option value="Manipur"/>
													<option value="Meghalaya"/>
													<option value="Mizoram"/>
													<option value="Nagaland"/>
													<option value="Odisha"/>
													<option value="Punjab"/>
													<option value="Rajasthan"/>
													<option value="Sikkim"/>
													<option value="Tamil Nadu"/>
													<option value="Telangana"/>
													<option value="Tripura"/>
													<option value="Uttar Pradesh"/>
													<option value="Uttarakhand"/>
													<option value="West Bengal"/>
													<option value="Andaman and Nicobar"/>
													<option value="Chandigarh"/>
													<option value="Dadra and Nagar Haveli"/>
													<option value="Daman and Diu"/>
													<option value="Delhi"/>
													<option value="Lakshadweep"/>
													<option value="Pondicherry"/>
					                        	</datalist>
					                        	<input type="number" name="form-per-add-pin" placeholder="Pincode" class="form-per-address form-control" id="form-per-add-pin" value="<?php echo $appRow['PerPincode']; ?>">
					                        </div>
					                        <button type="button" class="btn btn-previous">Previous</button>
					                        <button type="button" class="btn btn-next">Next</button>
					                    </div>
				                    </fieldset>
				                    
				                    <fieldset>
			                        	<div class="form-top">
			                        		<div class="form-top-left">
			                        			<h3>Step 3 / 3</h3>
			                            		<p>License Details :</p>
			                        		</div>
			                        		<div class="form-top-right">
			                        			<i class="fa fa-car"></i>
			                        		</div>
			                            </div>
			                            <div class="form-bottom">
			                            	<div class="form-group">
					                    		<label for="form-nearest-RTO">At which RTO do you want to apply? </label>
					                        	<select id="form-nearest-RTO" name="form-nearest-RTO" class="form-control" onchange="showtextfield(this.options[this.selectedIndex].value)" >
					                        		<option value="no">No</option>
					                        		<option <?php if($appRow['EffectiveLicense']=='pvd') {echo "selected";}  ?>>pvd</option>
					                        		<option <?php if($appRow['EffectiveLicense']=='pvs') {echo "selected";}  ?>>pvs</option>
					                        	</select>
					                        </div>
					                    	<div class="form-group">
					                    		<label for="form-eff-license">Do you an effective driving License ?</label>
					                        	<select id="form-eff-license" name="form-eff-license" class="form-control" onchange="showtextfield(this.options[this.selectedIndex].value)" >
					                        		<option value="no">No</option>
					                        		<option <?php if($appRow['EffectiveLicense']=='Motor Cycle') {echo "selected";}  ?>>Motor Cycle</option>
					                        		<option <?php if($appRow['EffectiveLicense']=='Light Motor Vehicle') {echo "selected";}  ?>>Light Motor Vehicle</option>
					                        		<option <?php if($appRow['EffectiveLicense']=='Medium Passenger Motor Vehicle') {echo "selected";}  ?>>Medium Passenger Motor Vehicle</option>
					                        		<option <?php if($appRow['EffectiveLicense']=='Medium Goods Vehicle') {echo "selected";}  ?>>Medium Goods Vehicle</option>
					                        	</select>
					                        </div>

					               

					                        <div id="addfield-eff-license" name="addfield-eff-license" class="form-group">
					                        	
					                        </div>


					                        <div class="form-group">
					                    		<label for="form-disq-license">Have you previously held any Learner's Driving License ?</label><br>
					                        	<label class="control-label"><input type="radio" style="margin-top: -1" id="prev-yes" class="form-control radio-inline" value="Yes" <?php if($appRow['PreviousLicense']=="Yes") {echo "checked";}  ?> name="form-prev-license" onclick="showtextfield3()">Yes &nbsp;</label>
					                        	<label class="control-label"><input type="radio" style="margin-top: -1" id="prev-no" class="form-control radio-inline" value="No"  <?php if($appRow['PreviousLicense']=="No") {echo "checked";}  ?> name="form-prev-license" onclick="showtextfield3()">No &nbsp;</label>
					                        </div>

					                        <div id="addfield-prev-learner">

					                        </div>


					                        <div class="form-group">
					                    		<label for="form-disq-license">Have you been disqualified for holding or obtaining driving licence or learner's licence ?</label>
					                        	<label class="control-label"><input type="radio" style="margin-top: -1" id="disq-yes" class="radio-inline form-control" value="Yes" <?php if($appRow['EverDisqualified']=="Yes") {echo "checked";}  ?> name="form-disq-license" onclick="showtextfield2()">Yes &nbsp;</label>
					                        	<label class="control-label"><input type="radio" style="margin-top: -1" id="disq-no" class="radio-inline form-control" value="No" <?php if($appRow['EverDisqualified']=="No") {echo "checked";}  ?> name="form-disq-license" onclick="showtextfield2()">No &nbsp;</label>
					                        </div>

					                        <div id="addfield-disq-license">

					                        </div>

					                        <div class="form-group">
					                    		<label for="form-apply-license">Apply License For</label>
					                        	<select id="form-apply-license" name="form-apply-license" class="form-control">
					                        		<option <?php if($appRow['ApplyForLicense']=='Motor Cycle') {echo "selected";}  ?>>Motor Cycle</option>
					                        		<option <?php if($appRow['ApplyForLicense']=='Light Motor Vehicle') {echo "selected";}  ?>>Light Motor Vehicle</option>
					                        		<option <?php if($appRow['ApplyForLicense']=='Medium Passenger Motor Vehicle') {echo "selected";}  ?>>Medium Passenger Motor Vehicle</option>
					                        		<option <?php if($appRow['ApplyForLicense']=='Medium Goods Vehicle') {echo "selected";}  ?>>Medium Goods Vehicle</option>
					                        	</select>
					                        </div>

					                
					                        <button type="button" class="btn btn-previous">Previous</button>
					                        <button name='formsubmit' type="submit" class="btn">Save & Continue</button>
					                    </div>
				                    </fieldset>
			                    
			                    </form>
			                    
	                        </div>
	                    </div>
	                </div>
	            </div>
	            
	        </div>
	    </div>

        <?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>


        <script>
        	function FillAddress() {
			  if(document.getElementById("form-add-check").checked == true) {
			    document.getElementById("form-per-add-street").value = document.getElementById("form-temp-add-street").value;
			    document.getElementById("form-per-add-state").value = document.getElementById("form-temp-add-state").value;
			    document.getElementById("form-per-add-city").value = document.getElementById("form-temp-add-city").value;
			    document.getElementById("form-per-add-pin").value = document.getElementById("form-temp-add-pin").value;
			  }
			}

			
			function showtextfield2() {
				  if(document.getElementById('disq-yes').checked==true)document.getElementById('addfield-disq-license').innerHTML='<label for="form-disq-license-add">Reason for Disqualification</label><textarea name="form-disq-license-add" placeholder="Reason" class="form-eff-details form-control" id="form-disq-details-add"><?php echo $appRow['DisqualificationReason']; ?></textarea>';
				  else if(document.getElementById('disq-no').checked==true)document.getElementById('addfield-disq-license').innerHTML='';
				}


			function showtextfield(name) {
				  if(name!='no')document.getElementById('addfield-eff-license').innerHTML='<label for="form-eff-validity">Validity Till</label><input type="date" name="form-eff-validity" class="form-eff-details form-control" id="form-eff-valid" value="<?php echo $appRow['EffectiveLicenseValidity']; ?>">';
				  else document.getElementById('addfield-eff-license').innerHTML='';
				}


			function showtextfield3() {
				  if(document.getElementById('prev-yes').checked==true)document.getElementById('addfield-prev-learner').innerHTML='<label for="form-prev-learner-add">Learner License Number</label><input type="text" name="form-prev-learner-add" placeholder="License Number" class="form-eff-details form-control" id="form-prev-number-add" value="<?php echo $appRow['PreviousLicenseNumber']; ?>">';
				  else if(document.getElementById('prev-no').checked==true)document.getElementById('addfield-prev-learner').innerHTML='';
				}

			function onloadAdd() {
				showtextfield2();
				showtextfield3();
			}

			window.onload = onloadAdd;
			

        </script>
        
     

    </body>

</html>