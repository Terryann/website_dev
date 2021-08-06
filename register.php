<?php
session_start();

// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$Firstname = $password = $confirm_password = $occupation ="";
$Firstname_err = $password_err = $confirm_password_err = $_err = "";
 
// Processing form data when form is submitted
if(isset($_POST['submit'])){
 
    // Validate username
    if(empty(trim($_POST["Firstname"]))){
        $Firstname_err = "Please enter a username.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM staff1 WHERE Firstname = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_Firstname);
            
            // Set parameters
            $param_Firstname = trim($_POST["Firstname"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $Firstname_err = "This username is already taken.";
                } else{
                    $Firstname = trim($_POST["Firstname"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
        exit();
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        
        if(empty($confirm_password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
            echo $confirm_password_err;
            exit();
        }
    }
    // validate occupation
    if (empty(trim($_POST["occupation"]))) {
        $occupation_err = "please give your occupation details";
     }
     else{
                    $occupation = trim($_POST["occupation"]);
                }
    
    
    // Check input errors before inserting in database
    if(empty($Firstname_err) && empty($password_err) &&empty($occupation_err) ){
        
        // Prepare an insert statement
        $sql = "INSERT INTO staff1 (Firstname, password, occupation) VALUES ('$Firstname', '$password', '$occupation')";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_Firstname, $param_password, $param_occupation);
            
            // Set parameters
            $param_Firstname = $Firstname;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
           
            $param_occupation = $occupation;

            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: Home.html");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

            // Close statement
            mysqli_stmt_close($stmt);
        
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        body{ font: 14px sans-serif; 
            margin: all;}
        .wrapper{ width: 350px; padding: 20px; margin: auto;
            widows: auto;}

        input[type="text"]{border-color: rgb(255,0,255);
            width: 150px;
            padding: 2px;}
            input[type="password"]{border-color: rgb(255,0,255);
            width: 150px;
            padding: 2px;}
            input[type="submit"]{background-color: rgb(0,255,255); padding: 10px; border-radius: 15px;}
             input[type="reset"]{background-color: rgb(0,255,255); padding: 10px; border-radius: 15px;}

    </style>
</head>
<body>

    <div class="wrapper">
        <h4><a href="Home.html">Home</a></h4>
        <h2><Marquee bgcolor="yellow" behavior="alternate" direction="left">Staff Registration </Marquee></h2>

        <p><i>Please fill this form to create an account.</i></p>
        <form action="login.php" method="post">
            <div class="form-group <?php echo (!empty($Firstname_err)) ? 'has-error' : ''; ?>">
                <label><b>Firstname</b></label>
                <input type="text" name="Firstname" class="form-control" value="<?php echo $Firstname; ?>">
                <span class="help-block"><?php echo $Firstname_err; ?></span>
            </div> <br />   
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label><b>Password</b></label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
          </div><br />
            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label><b>Confirm Password</b></label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div><br />
            <div class="form-group <?php echo (!empty($occupation)) ? 'has-error' : ''; ?>">
            <label><b>Occupation</b></label>
                <input type="text" name="occupation" class="form-control" value="<?php echo $occupation; ?>">
                <span class="help-block"><?php echo $occupation; ?></span>
                            </div><br />
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="submit">
                <input type="reset" class="btn btn-default" value="Reset">
                <p>Already have an account? <a href="login.php">Login here</a>.</p>
            </div>
            
        </form>
    </div>    
</body>
</html>