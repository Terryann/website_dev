<?php
//start session
session_start()
//check if user logged in, if yes then redirect him to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"])!== true {
	# code...
	header("location:login.php")
}

?>
<!DOCTYPE html>
<html>
<head>
	<title>welcome</title>
</head>
<body>
	<div class="container">
		<h1>Hi <b><?php echo htmlspecialchars($_SESSION["username"]);?></b>, Welcome to our site.</h1>
		<p>
			<a href="stdntreset password.php">Reset password</a>
			<a href="stdntlogout.php"> Log out</a>
		</p>

	</div>

</body>
</html>