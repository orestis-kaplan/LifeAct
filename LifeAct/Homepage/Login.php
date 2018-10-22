<?php
require 'C:\xampp\htdocs\LifeAct\Register\connect.php';

$username=$password='';
$username_err=$password_err='';
$exists=1;
$errors = array($username_err,$password_err);

if($_SERVER["REQUEST_METHOD"]=="POST"){
	//Validate Username
	if(empty(trim($_POST['usname'])))
	{
		$username_err = 'Please enter a Username';
	}
	else{
		$username = test_input($_POST['usname']);
	}
	//Validate Password
	if(empty(trim($_POST['psrw'])))
	{
		$password_err = 'Please enter a password';
	}
	else{
		$password = test_input($_POST['psrw']);
	}
	//Check if username or password exists or not
	if(empty($username_err)&&empty($password_err))
	{
		$sql="SELECT name,password FROM users WHERE name=?";

		if($stmt = mysqli_prepare($conn,$sql))
		{
		//bind variable the the prepared statement as parameters
			mysqli_stmt_bind_param($stmt,"s",$param_username);
			$param_username=$username;
			//Attempt to execute the prepared statement
			if(mysqli_stmt_execute($stmt))
			{
			//Store the result
				mysqli_stmt_store_result($stmt);
				//Check if username exists
				if(mysqli_stmt_num_rows($stmt)==1)
				{
				//bind result variables
					mysqli_stmt_bind_result($stmt,$username,$hashed_password);
					if(mysqli_stmt_fetch($stmt)){
					//Check if password is valid.If it is start a new session and save the username to the session
						if(password_verify($password,$hashed_password))
						{
							session_start();
							$_SESSION['usname']=$username;
							header("location:home.php");
						}
						else{
							$password_err = 'The password  is not valid';
							$exists = 0;
						}
					}
				}// If Username doesn't exist ....
				else
				{
						$username_err = 'Username  does not exists';
						$exists = 0;
		}
		}else{
			echo 'Ops!!! Something went wrong';
		}
			//Close stetement
	mysqli_stmt_close($stmt);
	}
	 mysqli_close($conn);
}
}
$json =json_encode($errors);
	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
?>
