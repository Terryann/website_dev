<?php
session_start();

require_once 'config.php';
$username = $password = "";
$username_err = $password_err = "";
if (isset($_POST['submit'])) {
	if (empty(trim($_POST["username"]))) {
		$username_err ="please enter username ";
		}else{
			$sql = "SELECT id FROM students WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "This username is already taken.";
                } else{
                    header("location: reg student.php");
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
                exit();
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
        
      

if (empty(trim($_POST["password"]))) {
	$password_err = "please enter your password";
    echo $password_err;}
	else
		{$password = trim($_POST["password"]);
    exit();
	}
       if (empty($username_err) && empty($password_err)) {
                    header("location: Home.html");
                }         
                
}         
mysqli_close($link);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; }
        .wrapper{ width: 350px; padding: 20px; margin-left: 280px; margin-top: 40px; 
        }
        input[type="submit"]{background-color: rgb(0,255,255); margin-left: 60px; width: 60px;}
        h2{font-family: BROADWAYS; text-align: left;}
        input[type="text"]{border-color: rgb(255,0,0);
            width: 150px;
            padding: 2px;}
            input[type="password"]{border-color: rgb(255,0,0);
            width: 150px;
            padding: 2px;}
            


    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p><b><u>Please fill in your credentials to login.</u></b></p>
        <form action="Home.html" method="post">


            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Username</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div><br />
        
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Password</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div><br /> 
        
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div><br /> 
            <p>Don't have an account? <a href="reg student.php">Sign up now</a>.</p>
        </form>
    </div>    
</body>
</html>