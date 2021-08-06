<?php
//initialize sesion
session_start()
//check if user logged in if yes then redirect him to the login page
if (isset($_SESSION["loggedin"]) || $_SESSION["loggedin"]!==true) {
	# code...
	header("location:login.php");
	exit;
}
//include the confug file
require_once 'stdnt config.php'
//define variables with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
//process form data when form is submitted
if ($_SERVER["REQUEST METHOD"] == "POST") {
	# code...
	//validate new password
	if (empty(trim($_POST["new_password"]))) {
		# code...
		$new_password_err = "please enter your new password";
		elseif (strlen(trim($_POST[new_password]))<6) {
			# code...
			$new_password_err = "your password should contain at least 6 characters";
		}
		else{
			$new_password=trim($_POST["new_password"]);
		}

	}
}
//validate confirm password
if (empty(trim($_POST["confirm_password"]))) {
	# code...
	$confirm_password_err="kindly confirm your password";
	else{
		$confirm_password= trim($_POST["confirm_password"]);
	if (empty($new_password_err) && ($new_password!=$confirm_password)) {
		# code...
		$confirm_password_err = "password did not match";

	}
	}

}
//check input errors before updating the database
if (empty($new_password_err) && empty($confirm_password_err)) {
	# code...
	//prepare an update statement
	$sql= "UPDATE students SET password=? WHERE id=?";
	//prepare stmt
	if ($stmt= mysqli_prepare($link, $sql)) {
	 	# code...
	 } //bind variables to the prepared statement
	 mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);

	 //set parameters
	 $param_password = password_hash($new_password, PASSWORD_DEFAULT);
	 $param_id = $_SESSION["id"];
	 //attempt to execute prepared stmt
	 if (mysqli_stmt_execute($stmt)) {
	 	# code...
	 	//password updated successfully, destroy the session and direct to the login page
	 	session_destroy();
	 	header("location: login.php")
	 	exit;
	 }
	 else{
	 	echo "oops! something went wrong.Please try again later";


	 }
	 //close statement
	 mysqli_close($stmt);
	 }
	 //close connection
	 mysqli_close($link);


}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Reset password</title>
</head>
<body>
<div class="wrapper">
	<h2>Reset Your Password</h2><br />
	<p> <b>Please fill out this form to reset your password</b></p>
	<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
            <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
                <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link" href="welcome.php">Cancel</a>




	</form>
	

</div>

</body>
</html>
