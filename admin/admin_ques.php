<?php 
	require_once('../includes/initialize.php');
	if(!isset($_SESSION['admin'])) {
		header("Location: ../home.php");
	}

	$email = $_SESSION['admin'];
	$sql = "SELECT * FROM AdminLoginDetails WHERE Email = '$email';";
	$result =  mysqli_query($conn,$sql);
	$userRow = mysqli_fetch_array($result);


?>
<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Admin | questions</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>
    <body>
    	<img src="../assets/img/backgrounds/plain.jpg" class="bg">
        <?php include_once(LIB_PATH.DS.'layouts/navbar.php') ?>
    	<div class="container inner-bg">
			<?php include_once(LIB_PATH.DS.'layouts/navbar.php'); ?>
	        <div class="page-content ">
	        	<div class="header">
	        		<h1><strong>Topics and Questions</strong></h1>
	        	</div>
	        	<?php if(isset($_SESSION['message'])) { ?>
	        	<div id="message"> <?php echo $_SESSION['message']; ?> </div>	
	        		<?php unset($_SESSION['message']) ;} ?>
	        	<div class="cont-horizon">
	        		<div class="form-a-right"></div>
	        		<div class="form-a-left">
		        		<select name="topic-filter" onclick="TopicFilter(this.value)">
		        			<option value=""></option>
		        			<option value="section-1">Section-1</option>
		        			<option value="section-2">Section-2</option>
		        			<option value="section-3">Section-3</option>
		        			<option value="section-4">Section-4</option>
		        			<option value="section-5">Section-5</option>
		        		</select>
		        	</div>	
	        	</div>
	        	<table id="quest_container" class="table-content ">
	        		
	        	</table>
	        </div>
	    </div>
	    
	    
	    <script type="text/javascript">
	    	function TopicFilter(str) {
	    		if(str.length== 0) {
					document.getElementById("quest_container").innerHTML = "please do Select the topic ";
					return;
				} else {
					var xmlhttp = new XMLHttpRequest();
					xmlhttp.onreadystatechange = function() {
						if(xmlhttp.readyState==4 && xmlhttp.status==200) {
							document.getElementById("quest_container").innerHTML = xmlhttp.responseText;
						}
					};
					xmlhttp.open("GET","topic_picking.php?topic=" + str,true );
					xmlhttp.send();
				};	

			};

	    </script>   
	    <?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?> 
    </body>
</html>