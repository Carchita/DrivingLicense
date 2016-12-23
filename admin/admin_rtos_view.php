<?php 
	include_once('../includes/initialize.php');
	if(!isset($_SESSION['admin'])) {
		header("Location: ../adminlogin.php");
	}

	$query = "SELECT * FROM RTO_offices;";
	$result = mysqli_query($conn, $query);
	if(!$result) {
		die("ERROR: ".mysqli_error($result));
	} else {
		$count = 1;
		While($x = mysqli_fetch_array($result)) {
            $rtos_array[$count]['rto_id'] = $x['id'];
			$rtos_array[$count]['rto_name'] = $x['Name_of_the_RTO'];
			$rtos_array[$count]['rto_location'] = $x['Location_of_the_RTO'];
			$rtos_array[$count]['head'] = $x['concerned_person'];
			$rtos_array[$count]['total_employees'] = $x['total_employees'];
			$rtos_array[$count]['total_vehicles'] = $x['total_vehicles'];
			$rtos_array[$count]['total_systems'] = $x['total_systems'];
			$rtos_array[$count]['applications_capacity'] = $x['applications_capacity'];
			$count++;
		}
		$total_rtos = $count - 1 ;	
	}
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
                                <h1><strong>RTOs list</strong></h1>
                                <div style="float: right"><a href="Add_new_RTO.php"><u>+ ADD new RTO</u></a></div>
                                <div class="top-big-link">
                                   <table class="table">
                                        <tr>
                                            <th>S.No</th>
                                            <th>RTO NAME</th>
                                            <th>LOCATION</th>
                                            <th>RTO HEAD</th>
                                            <th>TOTAL EMPLOYEES</th>
                                            <th>APPLICATIONS CAPACITY</th>
                                            <th>SYSTEMS</th>
                                            <th>VEHICLES(availble)</th>
                                            <th></th>
                                        </tr>
                                        <?php 	$count = 1;
                                        		while ($count <= $total_rtos) { ?>
                                        <tr>
                                        	<td><?php echo $count; ?></td>
                                        	<td><?php echo ucfirst($rtos_array[$count]['rto_name']); ?></td>
                                        	<td><?php echo ucfirst($rtos_array[$count]['rto_location']); ?></td>
                                        	<td><?php echo ucfirst($rtos_array[$count]['head']); ?></td>
                                        	<td><?php echo ucfirst($rtos_array[$count]['total_employees']); ?></td>
                                        	<td><?php echo ucfirst($rtos_array[$count]['applications_capacity']); ?></td>
                                        	<td><?php echo ucfirst($rtos_array[$count]['total_systems']); ?></td>
                                        	<td><?php echo ucfirst($rtos_array[$count]['total_vehicles']); ?></td>
                                            <td><a href="edit_RTO.php?id=<?php echo $rtos_array[$count]['rto_id']; ?>" style="padding-right: 20px;">Edit details</a><a href=""></a></td>
                                        </tr>
                                        <?php	$count++;
                                        		} ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        </div> 
    </body> 
</html>
<?php mysqli_close($conn); ?>                              