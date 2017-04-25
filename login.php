<?php
	require('config/db.inc.php');

  //Check if user has logged in
  if(isset($_SESSION["token"])){
    session_start();
    $_token = $_SESSION['token'];
    $_username = $_SESSION['username'];
    $query = "SELECT * FROM `users` WHERE username = '$_username'";
    $result = mysqli_query($con,$query) or die(mysql_error());
    $row = mysqli_fetch_assoc($result);
    $uid = $row['id'];
    $query = "SELECT * FROM `login` WHERE token = '$_token' and user_id = '$uid'";
    $result = mysqli_query($con,$query) or die(mysql_error());
    $rows = mysqli_num_rows($result);
      if($rows > 0){
      header("Location: index.php");
      exit(); 
    }
  }  

	if (isset($_POST['login'])) {
		// Post
		$usermail = stripslashes(trim($_POST['usermail']));
		$password = stripslashes(trim($_POST['password']));

		//Check if user exist
		$query = "SELECT * FROM `users` WHERE username = '$usermail' OR username ='$usermail'";
		$result = mysqli_query($con,$query) or die(mysql_error());
		$rows = mysqli_num_rows($result);
        if($rows > 0){
        	$row = mysqli_fetch_assoc($result);
        	$hashed_password = $row['hashed_password'];
        	$_user_id = $row['id'];
        	$_username = $row['username'];

        	// Check if password is correct
        	if (password_verify($password, $hashed_password)) {
        		$_date = date('Y-m-d G:i:s');
        		$_token = sha1(mt_rand());

        		//Update Token
        		$query78 = "UPDATE login SET token = '$_token', date = '$_date' WHERE user_id = '$_user_id'";
      			mysqli_query($con, $query78);

      			//Session Details
      			$_SESSION['username'] = $_username;
      			$_SESSION['token'] = $_token;
    			echo "<script>alert('$_token')</script>";
				header("Location: index.php");
			} else {
			    $msgs[] = "Password is Wrong";
			}
        }else{
        	$msgs[] = "User doesn't exist";
        }
	}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>City</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">City</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

      <div class="starter-template">
      	<div class="col-md-12">
      		<?php
	            if (isset($msgs)) {
	        ?>
	            <div class="alert alert-info">
	              <h4>
	                <?php
	                  foreach($msgs as $msg){
	                    echo $msg;
	                  }
	                ?>
	              </h4>
	            </div>
	        <?php
	            }
	        ?>
      		<div style="margin:auto;" class="col-md-4 col-xs-8">
		      	<form class="form-signin" method="post" action="?">
			        <h2 class="form-signin-heading">Log in</h2>
			        <input type="text" name="usermail" class="form-control" placeholder="Username" autocomplete="off" required autofocus>
			        <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="random-string" required>
			        <button class="btn btn-lg btn-info btn-block" name="login" type="submit">Sign in</button>
			        <p></p>
			        Create an Account <a class="btn btn-info btn-xs" href="register.php">Register</a>
			    </form>
      		</div>
      	</div>
      </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="dist/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>
