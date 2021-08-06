<?php
// if set submit to db
if (isset($_POST["submit"])) {
// include config file
require_once "config.php";

session_start();

	//define var
	$username = $password =  $confirm_password = $email_address = "";
	$username_err = $password_err = $confirm_password_err = $email_address_err = "";
	//input values from user
	$username= mysqli_real_escape_string($link, $_POST['username']);
  $password=mysqli_real_escape_string($link, $_POST['password']);
  $confirm_password=mysqli_real_escape_string($link, $_POST['confirm_password']);
  $email_address=mysqli_real_escape_string($link, $_POST['email_address']);
	$password_hash = password_hash($password, PASSWORD_DEFAULT);
	// validate credentials
	if (empty($_POST['username'])) {
		 $username_err = "enter your username";
			}
			if (empty($_POST['password'])) {
		 $password_err = "enter your password";
			}

			if (empty($_POST['confirm_password_err']) && ($confirm_password!== $password )) {
				$confirm_password_err = "passwords didn't match";
				echo $confirm_password_err;
				exit();
			}
			if (empty($_POST['email_address'])) {
				$email_address_err = "input a valid email";
			}

	// check if no possible input errorsand then insert tothe db
if (!empty($username) && !empty($password) && !empty($confirm_password) && !empty($email_address)) {
	

				$sql = "INSERT INTO students(username, password,email_address) VALUES('$username', '$password_hash', '$email_address')";
				
		
			//prepare mysqli stmt
				if ($stmt = mysqli_prepare($link, $sql)) {
					// bind var to the prepared stmt
					mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password, $param_email_address);
					//set parameters
					$param_username = $username;
					$param_password = password_hash($password, PASSWORD_DEFAULT);
					$param_email_address = $email_address;
					//attempt to execute
					if (mysqli_stmt_execute($stmt)) {
						header("location: login student.php");
						exit();
					}else{
						echo "something went wrong.please try again later";
						exit();
					}
					//close stmt
					mysqli_stmt_close($stmt);

				}
			}
			//close conn
			mysqli_close($link);
		}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/cs/head">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/cs/head">
<link rel="stylesheet" type="text/css" href="reg.css">
</head>
<body>
	<h5><a href="Home.html">Home</a></h5>
	<div class="p-3 mb-2 bg-secondary text-white">
		
<div class="container-fluid">
	
	<form action="reg student.php" method="post">
		<label>Username</label></br>
		<input type="text" name="username" > </br>
		<label>Password</label></br>
		<input type="password" name="password" > </br>
		<label>Confirm_password</label></br>
		<input type="password" name="confirm_password" > </br>
		<label>Email_address</label></br>
		<input type="email" name="email_address" > </br>
		<input type="submit" name="submit" value="Submit">
		<input type="reset" name="reset" value="reset">
		<p>Already have an Account <a href="login student.php" >login here</a></p>

		
	</form>

</div>

</div>
</body>
</html>