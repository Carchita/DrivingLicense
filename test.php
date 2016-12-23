<?php 
	require_once('includes/initialize.php');

	$TestDuration = "00:30:00";
	list($hour,$min,$sec) = explode(':', $TestDuration);
	$dbSessionDurationTime = mktime(0,0,0,$hour,$min,$sec);

?>
<?php include_once(LIB_PATH.DS.'layouts/html_initialize.php'); ?>
<title>Test page</title>
<?php include_once(LIB_PATH.DS.'layouts/css_initialize.php'); ?>
<?php include_once(LIB_PATH.DS.'layouts/favicon_initialize.php'); ?>
	<body style="background-color: lavender; text-align:left;">
		<div id="count"></div>
		<form name="me" action="test.php" method="get" >
			<input type="submit" name="sub" value="holaa">
		</form>
	</body>	

	<script type="text/javascript">
	    


		    hours = 0;
		    mins = 0;
		    seconds = 10;

		    timer = setInterval(changeTime,1000);

		    function changeTime() {
		    	console.log("holaaaa");
	    		if(seconds == -1){
		    		seconds = 59;
			    	mins = mins-1;
			    }	
			    console.log("bachgaya");
			    if(mins == -1){
			    	mins = 59;
			    	hours = hours -1;
			    }
			    if(hours == -1) {
					document.me.submit();							    		
			    } else {
					document.getElementById("count").innerHTML = hours + " : " + mins + " : " + seconds;
			    }
	    	
	    		seconds = seconds - 1;
		    }


	   

	</script>
	<?php include_once(LIB_PATH.DS.'layouts/js_initialize.php'); ?>
</html>	