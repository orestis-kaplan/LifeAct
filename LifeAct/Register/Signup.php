<?php
require_once  'connect.php';


$username_err = $password_err = $email_err= $confirm_err='';
$username = $password = $email= $confirm='';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
//Validate Username
	if(empty($_POST["uname"])){
		$username_err = 'Username is required';
	}
   elseif (!preg_match("/^[a-zA-Z ]*$/",$username)) {
 			$username_err = "Only letters and white space allowed";
   }
   else{
	$sql = "SELECT ID FROM users WHERE name = ?";

        if($stmt = mysqli_prepare($conn, $sql)){

            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set parameters
            $param_username = trim($_POST["uname"]);
			 if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);

	                if(mysqli_stmt_num_rows($stmt) == 1){
	                    $username_err = "Username '$param_username'  is already taken.";
                    //	header("location:http://localhost/LifeAct/Register/Signup.php");

	                } else{
	                    $username = test_input($_POST["uname"]);
	                }
            }
			else{
				echo "Oops!!! Something went wrong please try again.";
			}
			        // Close statement
       				 mysqli_stmt_close($stmt);
		}
	}

	//Validate email
		if(empty(trim($_POST["mail"]))){
		$email_err = 'E-mail is required';
		}
		//An uparxei
	   else{
				$sql = "SELECT ID FROM users WHERE email = ?";

		        if($stmt = mysqli_prepare($conn, $sql)){

		            // Bind variables to the prepared statement as parameters
		            mysqli_stmt_bind_param($stmt, "s", $param_email);

		            // Set parameters
		            $param_email = trim($_POST["mail"]);
					 if(mysqli_stmt_execute($stmt)){
		                /* store result */
		                mysqli_stmt_store_result($stmt);
			                if(mysqli_stmt_num_rows($stmt) == 1){
			                    $email_err = "Email '$param_email'  is already taken.";

		                    //	header("location:http://localhost/LifeAct/Register/Signup.php");
							}
							else{
									$email = test_input($_POST["mail"]);
											echo "<p> asasas </p>";
							}
					}
				 	else{
						echo "Oops!!! Something went wrong please try again.";
					}
					        // Close statement
		       				 mysqli_stmt_close($stmt);
				}
        }

		//Validate Password
		if(empty(trim($_POST["psw"]))){
			$password_err='Please enter a password';
		}
		elseif(strlen(trim($_POST["psw"])) <7){
			$password_err='Password must have at least 7 characters';
		}
		else{
			$password=test_input($_POST["psw"]);
		}
		//Validate Password confirmation
		if(empty(trim($_POST["cnf_psw"]))){
			$confirm_err='Please confirm your password';
		}
		else{
			$confirm = test_input($_POST["cnf_psw"]);
			if($password!=$confirm){
				$confirm_err='Passwords do not match';
			}
		}
  if(empty($username_err) && empty($password_err) && empty($confirm_err)&&empty($email_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (name, password,email) VALUES (?, ?, ?)";
        if($stmt = mysqli_prepare($conn, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_password,$param_email);

            // Set parameters
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
			$param_email = $email;
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                header("location: http://localhost/LifeAct/Homepage/home.php");
            	echo "completed successfully";
			} else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
	}
 mysqli_close($conn);
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>

<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="signup.css">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<title>Sign up</title>
</head>
<body style="font-family: Arial, Helvetica, sans-serif;">
	<form id="myform" class="animate" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
			<h2 style="text-align:center;">Sign up</h2>
			<div class="container">
					<label for="uname"><b>Username</b></label><br>
					<input  type="text" id="username" placeholder="Enter a username" name="uname" autocomplete="off" ><span class="error"> *</span>
					<br><span class="php_err"><?php	echo $username_err;  ?></span>
					<br>
					<label for="psw"><b>Password</b></label><br>
					<input type="password" id="password" placeholder="Choose a password" name="psw" onkeyup='check();'><span class="error"> *</span>
					<br><span class="php_err"><?php	echo $password_err; ?></span>
					<br>
					<label for="cnf_psw"><b>Confirm Password</b></label><br>
					<input type="password" id="confirm_password" placeholder="Confirm your password" name="cnf_psw" onkeyup='check();'><span class="error"> *</span>
					<br><span class="php_err"><?php echo $confirm_err; ?></span>
					<img id="green_tick" src="http://localhost/LifeAct/Register/icons/green.jpg">
					<img id="red_tick" src="http://localhost/LifeAct/Register/icons/red.jpg">
					<br>
					<label for="mail"><b>E-mail</b></label><br>
					<input type="email" placeholder="someone@e-mail.com" name="mail" autocomplete="off"><span class="error"> *</span>
					<br><span class="php_err"><?php	echo $email_err ; ?></span>
					<br><br>
					<input id="finish_button" type="submit" name="submit"  value="Finish" onclick="<?php echo $username_err=$email_err=$confirm_err=$password_er=''; ?>">
			</div>
	</form>
</body>
<script>
 $('document').ready(function(){
            $('#username').blur(function(){
                var username = $(this).val();
                $.ajax ({
                    url : "Signup.php",
                    method : "POST",
                    data :  {name :username },
                    dataType : "text"
                });
            });
    });
	var check = function(){
		if(document.getElementById('password').value==document.getElementById('confirm_password').value)
		{
			document.getElementById('green_tick').style.visibility='visible';
			document.getElementById('red_tick').style.visibility='hidden';
		}
		else{
		    document.getElementById('green_tick').style.visibility='hidden';
			document.getElementById('red_tick').style.visibility='visible';
		}
	}
</script>

</html>
