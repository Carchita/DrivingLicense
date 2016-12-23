<?php
	include_once('../includes/initialize.php');
	if(!isset($_SESSION['admin'])) {
		header("Location: ../adminlogin.php");
	}

	if(isset($_POST['Create_RTO'])) {

		$count = 1; 
		$RTO_name = mysqli_real_escape_string($conn,trim($_POST['RTO_Name']));
		$RTO_location = mysqli_real_escape_string($conn,trim($_POST['RTO_Location']));
		$RTO_name_location = $RTO_name."_".$RTO_location;
		$concerned_person = mysqli_real_escape_string($conn,trim($_POST['Head']));
		$Employees_total = mysqli_real_escape_string($conn,trim($_POST['total_employees'])); 
		while($count<=$Employees_total){
			if((isset($_POST['designation'.$count]) && $_POST['designation'.$count] !== "") && (isset($_POST['empolyee'.$count]) && $_POST['empolyee'.$count] !== "") && (isset($_POST['doj'.$count]) && $_POST['doj'.$count] !== "")) {
				echo $employee[$count]['designation'] = mysqli_real_escape_string($conn,trim($_POST['designation'.$count]));
				echo $employee[$count]['joining_date'] = $_POST['doj'.$count];
				echo $employee[$count]['person_name'] = mysqli_real_escape_string($conn,trim($_POST['empolyee'.$count]));
				
			};
			$count++;
		};
		$Applications_capacity = mysqli_real_escape_string($conn,trim($_POST['applications_capacity']));
		$Total_vehicles = mysqli_real_escape_string($conn,trim($_POST['total_vehicles']));
		$Total_systems = mysqli_real_escape_string($conn,trim($_POST['total_systems']));

		// RTO office table creation
		$query = " CREATE table RTO_office_".$RTO_name_location." ( id int(20) not null auto_increment, Name_of_the_RTO varchar(255) not null, Designation varchar(100) not null, Date_of_joining varchar(100) not null, Name_of_the_person varchar(100) not null,  PRIMARY KEY (id), INDEX (Name_of_the_RTO) ); ";
		$result = mysqli_query($conn, $query);
		if(!$result){
			die('ERROR:  '.mysqli_error($conn));
		} else {


			//Insertion of basic details of RTO into central server
			$query = "INSERT INTO RTO_offices (Name_of_the_RTO, Location_of_the_RTO, concerned_person, total_employees, applications_capacity, total_vehicles, total_systems) VALUES ( '{$RTO_name}', '{$RTO_location}', '{$concerned_person}', '{$Employees_total}', '{$Applications_capacity}', '{$Total_vehicles}', '{$Total_systems}' );" ;
			$result = mysqli_query($conn, $query);
			if (!$result) {
				die("ERROR:  ". mysqli_error($conn));
			} else {
	
				// Insertion of employeess at particular RTO
				$query = "";
				$count2 = 1; 
				while($count2 <= $Employees_total){
					$query = "INSERT INTO RTO_office_".$RTO_name_location ;
					$query .= " (Name_of_the_RTO, Designation , Date_of_joining, Name_of_the_person) VALUES ( '{$RTO_name}', '".$employee[$count2]['designation'];
					$query .= "', '".$employee[$count2]['joining_date'] ;
					$query .= "', '".$employee[$count2]['person_name'] ;
					$query .= "') ; " ;	

					$result = mysqli_query($conn, $query);
					if(!$result){
						die("ERROR:  ". mysqli_error($conn));
					} else {
					$_SESSION['message'] = "New RTO Entry is Successful at ".$count2." ! \n";
					$count2++;
					};

				
					header("Location: admin_rtos_view.php");

				}	
			}
		}
	}	

?>
<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Admin | Add RTO</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<link rel="stylesheet" href="../assets/css/dashboard.css">
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>

	<body>
		<img src="../assets/img/backgrounds/plain.jpg" class="bg">
		<?php include_once(LIB_PATH.DS.'layouts/navbar.php') ?>
		<div class="container inner-bg" >
			<div class="header">
				<h1><strong>ADD NEW RTO</strong></h1>
			</div>
			<div class="page-content">
				<form action="Add_new_RTO.php" method="POST">	
					<div class="cont-horizon">
						<div class="form-a-right">
							Name of the RTO
						</div>
						<div class="form-a-left">
							<input type="text" name="RTO_Name" placeholder="Enter RTO name" value="">
						</div>
					</div>
					<div class="cont-horizon">
						<div class="form-a-right">
							Location of the RTO
						</div>
						<div class="form-a-left">
							<input type="text" name="RTO_Location" placeholder="Enter RTO Location" value="">
						</div>
					</div>
					<div class="cont-horizon">
						<div class="form-a-right">
							Head of the RTO
						</div>
						<div class="form-a-left">
							<input type="text" name="Head" placeholder="Enter Head of RTO" value="">
						</div>
					</div>
					<div class="cont-horizon">
						<div class="form-a-right">
							Add Employees of the RTO
						</div>
						<div class="form-a-left">
							<input id="total_employees" type="hidden" name="total_employees" placeholder="Enter total employees" value="">
							<div id="employees">
								<table id="employees-table">
									<tr>
										<th>Designantion</th>
										<th>Name of the Person</th>
										<th>Date of Joining</th>
									</tr>
									<tr id="employee1">
										<td><input type="text" name="designation1" placeholder="Enter designation" value="" ></td>
										<td><input type="text" name="empolyee1" placeholder="Enter name" value="" ></td>
										<td><input type="date" name="doj1" placeholder="Enter DOJ" value="" ></td>
									</tr>								
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
							<input type="number" name="applications_capacity" placeholder="Enter aplications capacity" value="">
						</div>
					</div>
					<div class="cont-horizon">
						<div class="form-a-right">
							Total Vehicles available for test
						</div>
						<div class="form-a-left">
							<input type="number" name="total_vehicles" placeholder="Enter total vehicles" value="">
						</div>
					</div>
					<div class="cont-horizon">
						<div class="form-a-right">
							Total systems for online test
						</div>
						<div class="form-a-left">
							<input type="number" name="total_systems" placeholder="Enter no. of systems" value="">
						</div>
					</div>
					<div class="cont-horizon">
						<div class="form-a-right">	
						</div>
						<div class="form-a-left">
							<input id="submit" type="submit" name="Create_RTO" value="Create Now">
						</div>
					</div>
				</form>
			</div>
		</div>
		<?php include_once(LIB_PATH.DS."layouts/js_initialize.php"); ?>
		<script>
			$(document).ready(function(){
				max_i = 5
				i=1;
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
						alert("Atleast one entry should be inserted")
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