<?php
	include_once('../includes/initialize.php');
	if(!isset($_SESSION['admin'])) {
		header("Location: ../adminlogin.php");
	}
	
	$rto_id = $_GET['id'];
	$query = "SELECT * FROM RTO_offices WHERE id='{$rto_id}'; ";
	$result = mysqli_query($conn, $query);
	if(!$result) {
		die("ERROR: " .mysqli_error($conn));
	} else {
		$rto_array = mysqli_fetch_array($result);
		$query = "SELECT * FROM RTO_office_".$rto_array['Name_of_the_RTO']."_".$rto_array['Location_of_the_RTO']." WHERE Name_of_the_RTO = '{$rto_array['Name_of_the_RTO']}' ;";
		$result = mysqli_query($conn, $query);
		if(!$result) {
			die("ERROR1: ".mysqli_error($conn));
		} else {
			$count = 1;
			while ($x = mysqli_fetch_array($result)) {
				$rto_employee[$count]['Designation'] = $x['Designation'];
				$rto_employee[$count]['Date_of_joining'] = $x['Date_of_joining'];
				$rto_employee[$count]['Name_of_the_person'] = $x['Name_of_the_person']; 
				$count++;
			};
		}
	}

	if(isset($_POST['Update_RTO'])) {
		$count = 1; 
		$RTO_name = mysqli_real_escape_string($conn,trim($_POST['RTO_Name']));
		$RTO_location = mysqli_real_escape_string($conn,trim($_POST['RTO_Location']));
		$RTO_name_location = $RTO_name."_".$RTO_location;
		$concerned_person = mysqli_real_escape_string($conn,trim($_POST['Head']));
		$old_total = mysqli_real_escape_string($conn,trim($_POST['old_total'])); 
		$Employees_total = mysqli_real_escape_string($conn,trim($_POST['total_employees'])); 
		while($count<=$Employees_total){
			if((isset($_POST['designation'.$count]) && $_POST['designation'.$count] !== "") && (isset($_POST['empolyee'.$count]) && $_POST['empolyee'.$count] !== "") && (isset($_POST['doj'.$count]) && $_POST['doj'.$count] !== "")) {
				$employee[$count]['designation'] = mysqli_real_escape_string($conn,trim($_POST['designation'.$count]));
				$employee[$count]['joining_date'] = $_POST['doj'.$count];
				$employee[$count]['person_name'] = mysqli_real_escape_string($conn,trim($_POST['empolyee'.$count]));
				
			};
			$count++;
		};
		$Applications_capacity = mysqli_real_escape_string($conn,trim($_POST['applications_capacity']));
		$Total_vehicles = mysqli_real_escape_string($conn,trim($_POST['total_vehicles']));
		$Total_systems = mysqli_real_escape_string($conn,trim($_POST['total_systems']));

		//Updating the RTO_offices
		$query = "UPDATE RTO_offices SET Name_of_the_RTO = '{$RTO_name}', Location_of_the_RTO = '{$RTO_location}', concerned_person = '{$concerned_person}', total_employees = '{$Employees_total}', applications_capacity = '{$Applications_capacity}', total_vehicles = '{$Total_vehicles}', total_systems = '{$Total_systems}' WHERE id = {$rto_id}  ;" ;
		$result = mysqli_query($conn, $query);
		if(!$result) {
			die("ERROR: ". mysqli_error($conn));
		} else {

			//Updating the rto employees data 
			$count2 = 1;
			while($count2 <= $Employees_total) {
				if($old_total<=$Employees_total){
					if($count2 <= $old_total) {
						$query ="UPDATE RTO_office_".$RTO_name_location." SET Name_of_the_RTO = '{$RTO_name}', Designation = '{$employee[$count2]['designation']}', Date_of_joining = '{$employee[$count2]['joining_date']}', Name_of_the_person = '{$employee[$count2]['person_name']}' WHERE id = '{$count2}' ";
						$result = mysqli_query($conn, $query); 
						if(!$result) {
							die("ERROR: " .mysqli_error($conn));
						} else {
							$count2++;
						}
					} else {
						$query = "INSERT INTO RTO_office_".$RTO_name_location ;
						$query .= " (Name_of_the_RTO, Designation , Date_of_joining, Name_of_the_person) VALUES ( '{$RTO_name}', '".$employee[$count2]['designation'];
						$query .= "', '".$employee[$count2]['joining_date'] ;
						$query .= "', '".$employee[$count2]['person_name'] ;
						$query .= "') ; " ;	

						$result = mysqli_query($conn, $query);
						if(!$result){
							die("ERROR:  ". mysqli_error($conn));
						} else {
							$count2++;
						}	
					}
				} 	
				$count2++;
			};

			if(($old_total > $Employees_total) && ($count2 > $Employees_total)) {
				while($count2 < $old_total) {
					$query = "DELETE FROM RTO_office_".$RTO_name_location." WHERE Name_of_the_RTO = '{$RTO_name}' and Designation = '{$employee[$count2]['designation']}' and Date_of_joining = '{$employee[$count2]['joining_date']}' and Name_of_the_person = '{$employee[$count2]['person_name']}' ; ";   
					$result = mysqli_query($conn, $query); 
					if(!$result) {
						die("ERROR: " .mysqli_error($conn));
					} else {
						$count2++;
					}
				}	
			}

			
			unset($_POST);
			$_SESSION['message'] = "Success updating at ".$RTO_name_location;
			header("Location: index.php");
		}

	}
?>
<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Admin | Edd RTO</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<link rel="stylesheet" href="../assets/css/dashboard.css">
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>

	<body>
		<img src="../assets/img/backgrounds/plain.jpg" class="bg">
		<?php include_once(LIB_PATH.DS.'layouts/navbar.php') ?>
		<div class="container inner-bg" >
			<div class="header">
				<h1><strong>EDIT THE RTO</strong></h1>
				
			</div>
			<div class="page-content">
				<form action="edit_RTO.php?id=<?php echo $rto_id; ?>" method="POST">	
					<div class="cont-horizon">
						<div class="form-a-right">
							Name of the RTO
						</div>
						<div class="form-a-left">
							<input type="text" name="RTO_Name" placeholder="Enter RTO name" value="<?php echo $rto_array['Name_of_the_RTO']; ?>">
						</div>
					</div>
					<div class="cont-horizon">
						<div class="form-a-right">
							Location of the RTO
						</div>
						<div class="form-a-left">
							<input type="text" name="RTO_Location" placeholder="Enter RTO Location" value="<?php echo $rto_array['Location_of_the_RTO']; ?>">
						</div>
					</div>
					<div class="cont-horizon">
						<div class="form-a-right">
							Head of the RTO
						</div>
						<div class="form-a-left">
							<input type="text" name="Head" placeholder="Enter Head of RTO" value="<?php echo $rto_array['concerned_person']; ?>">
						</div>
					</div>
					<div class="cont-horizon">
						<div class="form-a-right">
							Add Employees of the RTO
						</div>
						<div class="form-a-left">
							<input id="old_total" type="hidden" name="old_total" value="<?php echo $rto_array['total_employees']; ?>">
							<input id="total_employees" type="hidden" name="total_employees" placeholder="Enter total employees" value="<?php echo $rto_array['total_employees']; ?>">
							<div id="employees">
								<table id="employees-table">
									<tr>
										<th>Designantion</th>
										<th>Name of the Person</th>
										<th>Date of Joining</th>
									</tr>
									<?php 	$count = 1; 
											while($count <= $rto_array['total_employees'] ) {?>
									<tr id="employee<?php echo $count; ?>">
										<td><input type="text" name="designation<?php echo $count; ?>" placeholder="Enter designation" value="<?php echo $rto_employee[$count]['Designation']; ?>" ></td>
										<td><input type="text" name="empolyee<?php echo $count; ?>" placeholder="Enter name" value="<?php echo $rto_employee[$count]['Name_of_the_person']; ?>" ></td>
										<td><input type="date" name="doj<?php echo $count; ?>" placeholder="Enter DOJ" value="<?php echo $rto_employee[$count]['Date_of_joining']; ?>" ></td>
									</tr>		
									<?php 		$count++;
											}; ?>						
								</table>
								<button type="button" id="add" class="button" value="Add one more ">Add one more </button>
								<button type="button" id="remove" class="button" value="Add one more ">Delete the last one </button>
							</div>
						</div>
					</div>
					<div class="cont-horizon">
						<div class="form-a-right">
							Applications capacity per month 
						</div>
						<div class="form-a-left">
							<input type="number" name="applications_capacity" placeholder="Enter aplications capacity" value="<?php echo $rto_array['applications_capacity']; ?>">
						</div>
					</div>
					<div class="cont-horizon">
						<div class="form-a-right">
							Total Vehicles available for test
						</div>
						<div class="form-a-left">
							<input type="number" name="total_vehicles" placeholder="Enter total vehicles" value="<?php echo $rto_array['total_vehicles']; ?>">
						</div>
					</div>
					<div class="cont-horizon">
						<div class="form-a-right">
							Total systems for online test
						</div>
						<div class="form-a-left">
							<input type="number" name="total_systems" placeholder="Enter no. of systems" value="<?php echo $rto_array['total_systems']; ?>">
						</div>
					</div>
					<div class="cont-horizon">
						<div class="form-a-right">	
						</div>
						<div class="form-a-left">
							<input id="submit" type="submit" name="Update_RTO" value="Create Now">
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php include_once(LIB_PATH.DS."layouts/js_initialize.php"); ?>
		<script>
			$(document).ready(function(){
				max_i = 5
				i = $('#old_total').val();;
				//alert(i);
				$("#add").click(function(){
					if(i<max_i) {
						i++;
						content2 = "<tr id=\"employee"+i+"\"><td  > <input type=\"text\" name=\"designation"+i+"\" placeholder=\"Enter designation\" value=\"\" ></td>									<td><input type=\"text\" name=\"empolyee"+i+"\" placeholder=\"Enter name\" value=\"\" ></td>									<td><input type=\"date\" name=\"doj"+i+"\" placeholder=\"Enter DOJ\" value=\"\" ></td>								</tr>" ;
						$("#employees-table").append(content2);
						
					} else {
						alert("Entries should not exceed "+max_i);					
					}	
					
				});		

				$("#remove").click(function(){
					if(i>=2) {
						i--;
						$("#employees-table tr:last-child").remove();
					} else {
						alert("Atleast one entry should be inserted");
					}
				});	
				$("#submit").click(function(){
					$('#total_employees').val(i);
				});
			});		
		</script>
	</body>
</html>
<?php mysqli_close($conn); ?>