<?php
	require('config/db.inc.php');
	session_start();

	function sec_session_start() {
	    $session_name = 'sec_session_id';   // Set a custom session name 
	    $secure = SECURE;

	    // This stops JavaScript being able to access the session id.
	    $httponly = true;

	    // Forces sessions to only use cookies.
	    if (ini_set('session.use_only_cookies', 1) === FALSE) {
	        header("Location: login.php?err=Could not initiate a safe session (ini_set)");
	        exit();
	    }

	    // Gets current cookies params.
	    $cookieParams = session_get_cookie_params();
	    session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly);

	    // Sets the session name to the one set above.
	    session_name($session_name);

	    session_start();            // Start the PHP session 
	    session_regenerate_id();    // regenerated the session, delete the old one. 
	}

	// if(!isset($_SESSION["token"])){
		$_token = $_SESSION['token'];
		$_username = $_SESSION['username'];
		$query = "SELECT * FROM `users` WHERE username = '$_username'";
		$result = mysqli_query($con,$query) or die(mysql_error());
		$row = mysqli_fetch_assoc($result);
		$uid = $row['id'];
		$query = "SELECT * FROM `login` WHERE token = '$_token' and user_id = '$uid'";
		$result = mysqli_query($con,$query) or die(mysql_error());
		$rows = mysqli_num_rows($result);
	    if($rows == 0){
			header("Location: login.php");
			exit(); 
		}
	// }
?>