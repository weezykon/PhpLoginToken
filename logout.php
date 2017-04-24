<?php
	require('config/db.inc.php');
	include("auth.inc.php");

	$_username = $_SESSION['username'];
	$query = "SELECT * FROM `users` WHERE username = '$_username'";
	$result = mysqli_query($con,$query) or die(mysql_error());
	$row = mysqli_fetch_assoc($result);
	$uid = $row['id'];

	//Logout Token
	$_token = 0;
	$query78 = "UPDATE login SET token = '$_token' WHERE user_id = '$uid'";
	mysqli_query($con, $query78);

	// get session parameters 
	$params = session_get_cookie_params();

	// Delete the actual cookie. 
	setcookie(session_name(),'', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

	// Destroy session 
	session_destroy();
	header("Location: login.php");
?>