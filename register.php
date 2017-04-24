<?php
  require('config/db.inc.php');
	if (isset($_POST['register'])) {
    //Form Process
    $username = stripslashes(trim(ucfirst($_POST['username'])));
    $firstname = stripslashes(trim(ucfirst($_POST['firstname'])));
    $lastname = stripslashes(trim(ucfirst($_POST['lastname'])));
		$email = stripslashes(trim($_POST['email']));
    $password = stripslashes(trim($_POST['password']));
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $_date = date('Y-m-d G:i:s');

    //Checks if User Exist
    $query = "SELECT * FROM `users` WHERE username = '$username' OR email ='$email'";
    $result = mysqli_query($con,$query) or die(mysql_error());
    $rows = mysqli_num_rows($result);
    if($rows == 0){
      // Insert details into User table.
      $query60 = "INSERT INTO users (username,email,hashed_password,firstname,lastname,date) values ('$username', '$email', '$hashed_password','$firstname','$lastname','$_date')";
      mysqli_query($con, $query60);
      $uid = mysqli_insert_id($con);
      $_token = sha1(mt_rand());
      //Insert token into login table
      $query50 = "INSERT INTO login (user_id,token,date) values ('$uid','$_token','$_date')";
      mysqli_query($con, $query50);
      //Start Session
      session_start();
      $_SESSION['username'] = $username;
      $_SESSION['token'] = $_token;
      header("Location: index.php");
    }else{
      $msgs[] = "User Already Exist";
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
			        <h2 class="form-signin-heading">Register Freely</h2>
              <input type="text" name="firstname" class="form-control" placeholder="Firstname" autocomplete="off" required autofocus>
              <input type="text" name="lastname" class="form-control" placeholder="Lastname" autocomplete="off" required>
              <input type="text" name="username" class="form-control" placeholder="Username" autocomplete="off" required>
			        <input type="email" name="email" class="form-control" placeholder="Email" autocomplete="off" required>
			        <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off" required>
			        <button class="btn btn-lg btn-danger btn-block" name="register" type="submit">Sign Up</button><p></p>
              Already A Member <a class="btn btn-danger btn-xs" href="login.php">Login</a>
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
