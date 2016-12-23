<?php 
	
	// Defining the core paths
	defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);

	defined('SITE_ROOT') ? null : define('SITE_ROOT', 'C:'.DS.'xampp'.DS.'htdocs'.DS.'DrivingLicense');
	defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');

	require_once("dbConnect.php");
	require_once("session.php");

?>