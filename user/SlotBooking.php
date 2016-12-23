<?php 
	require_once('../includes/initialize.php');
	if(!isset($_SESSION['user'])) {
		 header('Location: ../home.php');
	}	

	$email = $_SESSION['user'];

	//retreiving the timestamp to put deadline on slotbooking
	$query = "SELECT TimeStamp FROM Applications WHERE Email = '{$email}' ; ";
	$result = mysqli_query($conn, $query);
	if(!$result) {
		die("Zero entries of applicant found");
	} else {
		$timestamp = mysqli_fetch_array($result);
		$approved_date=strtotime($timestamp['TimeStamp']);
		$slot_enddate = strtotime("+15 days",$approved_date);
		$current_date = strtotime(date('Y-m-d h:m:s'));
		$now = date('Y-m-d h:m:s');
	}

	if(isset($_POST['Book_Slot'])) {
		$location = trim($_POST['Location']);
		$slot = trim($_POST['Slot']);
		$date = trim($_POST['Date']);

		if(strtotime($date) <= $slot_enddate) {
			//checking  again whether the slot is free
			$query = "SELECT count(email) FROM SlotBooking WHERE RTO = '{$location}' and slot = '{$slot}' and $date = '{$date}' ;";
			$result = mysqli_query($conn, $query);
			if(!$result){
				die("Slots are booked.. Can't book anymore");
			} else {
				$count = mysqli_fetch_array($result)['count(email)'];
			}

			// Booking the slot 
			$query = "INSERT into SlotBooking (RTO, slot, date, email,timestamp ) VALUES ('{$location}' , '{$slot}', '{$date}', '{$email}', '{$now}' ); ";
			$result = mysqli_query($conn, $query);
			if(!$result){
				die("Problem booking the slot");
			} else {
				$query = "UPDATE Applications SET SlotStatus = 'Yes' WHERE Email = '{$email}' ;";
				$result = mysqli_query($conn, $query);
				if($result){
					header("Location: index.php");
				}
			}
		}

		
	}

	



?>
<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Slot Booking</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<link rel="stylesheet" href="../assets/css/dashboard.css">
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>
	<body>
		<div class="center">
			<img src="../assets/img/backgrounds/plain.jpg" class="bg">
			<?php include_once(LIB_PATH.DS.'layouts/navbar.php'); ?>
			<div class="container inner-bg">
				<?php if(!($current_date <= $slot_enddate)) { ?>
				<div class="header">
					<span>
						Your Online test  End date is finished. Try applying after 15 days.
					</span>
				</div>	
				<?php } else { ?>	
				<div class="header">
					<span>
						<b>Slot Booking</b>
					</span>
				</div>
				<div class="page-content">
					<form action="SlotBooking.php" method="post">
						<div id="instr" class="row pad-el">
							<div class="col-md-12">
								Select the location and the corresponding slot for your online test from the given options. 
							</div>
						</div>
						<div class="">
							<div class="location cont-horizon" >
								<div class=" form-a-right">Location: </div> 
								<div class=" form-a-left">
									<select id="location" name="Location">
										<option value=""></option>
										<option value="A">A</option>
										<option value="B">B</option>
										<option value="C">C</option>
									</select>
								</div> 
							</div>
							<div class="date cont-horizon" style="display:none;">
								<div class=" form-a-right">Date: </div> 
								<div class=" form-a-left">
									<select id="date" name="Date">
										<option value=""></option>
										<?php 	$tmp_date = $current_date;
												while($tmp_date <= $slot_enddate) {
													$date_options = date("d-m-Y", $tmp_date);	?>
										<option value="<?php echo $date_options ?>"><?php echo $date_options; ?> </option>	
										<?php 		$tmp_date = strtotime("+1 day",$tmp_date); }; ?>	
									</select>
								</div>
							</div>
							<div class="slot cont-horizon" style="display:none;">
								<div class="form-a-right">Slots: </div> 
								<div class="form-a-left">
									<select id="slot" name="Slot">
										<option value=""></option>
										<option value="1">morning</option>
										<option value="2">Evening</option>
									</select>
								</div>
							</div>
							<div id="notify" style="padding:20px ">

							</div>
							<input type="submit" class="app-sub" name="Book_Slot" value="Book now" >
						</div>
					</form>
				</div>
				<?php }; ?>
			</div>
		</div>	
		<?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>	
		<script type="text/javascript">
			$(document).ready(function() {
				
				
				$("#location").change(function(){
					
					val1 = $("#location option:selected").attr('value');
					if(val1 !== ""){
						$(".date").css("display","flex");
					} else {
						$(".date").css("display","none");
					} 
					$(".slot").css("display","none" );
					$("#date option, #slot option").prop('selected', false);
					$("input[type='submit']").prop('disabled', true );
					document.getElementById("notify").innerHTML="";
				});
				$("#date").change(function(){
					val2 = $("#date option:selected").attr('value');
					if(val2 !== ""){
						$(".slot").css("display","flex" );
					} else {
						$(".slot").css("display","none" );
					} 
					$("#slot option").prop('selected', false);
					$("input[type='submit']").prop('disabled', true );
					document.getElementById("notify").innerHTML="";
				});


				$("input[type='submit']").prop('disabled', true );

				$("#slot").change(function(){
					val3 = $("#slot option:selected").attr('value');
					if(val3 !== ""){
						callback = slotCheck(val1, val2, val3);
						$("input[type='submit']").prop('disabled', false );
					} else {
						document.getElementById("notify").innerHTML = "Select the slot";
						$("input[type='submit']").prop('disabled',true);
					}
				});
				
			
				function slotCheck(val1, val2, val3) {
		    		if((val1.length== 0) && (val2.length != 0) && (val3.length != 0)) {
						document.getElementById("notify").innerHTML = "Slot availability checking.. ";
						return;
					} else {
						var xmlhttp = new XMLHttpRequest();
						xmlhttp.onreadystatechange = function() {
							if(xmlhttp.readyState==4 && xmlhttp.status==200) {
								document.getElementById("notify").innerHTML = xmlhttp.responseText;
							};
						};
						xmlhttp.open("GET","slot_check.php?location=" + val1 + "&date=" + val2+"&slot="+val3,true );
						xmlhttp.send();
					};	
				};
			});

		</script>
	</body>
</html>	