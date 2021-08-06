<?php
// Initialize the session
session_start();
 
// Include config file
require_once "config.php";

 
// Define variables and initialize with empty values
$Firstname = $password = "";
$Firstname_err = $password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["Firstname"]))){
        $Firstname_err = "Please enter username.";
        

    } else{
        $Firstname = trim($_POST["Firstname"]);
       
    }

    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($Firstname_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, Firstname, password FROM staff1 WHERE Firstname, password = ?, ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ss", $param_Firstname, $param_password);
            
            // Set parameters
            $param_Firstname = $Firstname;
            $param_password = $password;


            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $Firstname, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["Firstname"] = $Firstname;
                            $_SESSION["password"] = $password;

                           

                            
                            // Redirect user to welcome page
                            header("location: welcome.php");

                            exit();
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $Firstname_err = "No account found with that username.";
                     
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}
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
        <form action="welcome.php" method="post">


            
                <label>Firstname</label><br />
                <input type="text" name="Firstname" required>
           <br />
        
            
                <label>Password</label><br />
                <input type="password" name="password" required>
                <br /> 
        
            
                <input type="submit" class="btn btn-primary" value="Login">
            <br /> 
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>    
</body>
</html>