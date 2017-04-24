<?php	
	$_username = $_SESSION['username'];
	$query = "SELECT * FROM `users` WHERE username = '$_username'";
	$result = mysqli_query($con,$query) or die(mysql_error());
	$row = mysqli_fetch_assoc($result);
	$uid = $row['id'];
	$firstname = $row['firstname'];
	$lastname = $row['lastname'];
	$email = $row['email'];
	$username = $row['username'];
?>	