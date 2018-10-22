<?php
require 'C:\xampp\htdocs\LifeAct\Register\connect.php';
$username=$password='';
$username_err=$password_err='';

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
							$second_script='<script>$(document).ready(function(){ $(\'#Logform\').hide();$(\'#LogOut\').css(\'display\',\'block\')});</script>';
						}
						else{
							$script='<script>$(document).ready(function(){ $(\'#id01\').delay(4000).show();});</script>';
							$password_err = 'The password  is not valid';
						}
					}
				}// If Username doesn't exist ....
				else
				{
						$username_err = 'Username  does not exist';
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

	function test_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}
//	if(isset($_POST['login']) && !password_verify($password,$hashed_password))
?>

<!--HTML CODE FOR LOGIN PAGE-->
<!DOCTYPE html>
<html>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="home.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

	<head>
		<title>Kouvas</title>
	</head>
	<body background="TOLpic.jpg">
	<!-- Navigation -->
		<nav class="navigation-bar">
			<div class="dropdown-home">
				<button class="dropbtn">Home</button>
					<div class="dropdown-content">
						<a href="#Possible Customers">Possible Customers</a>
						<a href="#Bloodline">Bloodline</a>
						<a href="#Info" >Info</a>
						<a href="#Mapping">Mapping</a>
					</div>
			</div>
			<a href="#about">About</a>
			<a href="#support" >Support</a>
			<a href="http://localhost/LifeAct/TOL/TOL.html">TOL</a>
			<?php if(isset($second_script))echo $second_script; ?>
				<input type="button" id="Logform" value="Log in" href="id01" onclick="open_close();" >
				<input type="button" id="Signform" value="Sign up" onclick="window.location.href='http://localhost/LifeAct/Register/Signup.php';">
				<a id="LogOut" href="LogOut.php" >Log Out</a>

		</nav>

	<!--Wrapper for news info and basic attributes -->
		<div id="news">
			<h2 style="color:white;text-align:center;vertical-align:middle;line-height:450px;">The news of the page will be displayed here</h2>
		</div>
	<!-- Login Page-->
	<?php if(isset($script))echo $script;?>
	<div id="id01" class="modal">
			<form id="form_id"  class="modal-content animate" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<h2 style="text-align:center;">Sign in</h2>
				<div class="container-login">
						<label for="usname"><b>Username</b></label>
						<input type="text" placeholder="Enter Username" id="username" name="usname" autocomplete="off" required><div id="status"></div><div id="gif" style="display:none;"><img src="http://localhost/LifeAct/Register/loading.gif"></div><span id="response" class="php_err"><?php echo "$username_err"; ?></span>
						<br>
						 <label for="psrw"><b>Password</b></label>
						 <input type="password" placeholder="Enter Password" name = "psrw" required><br><span class="php_err"><?php echo "$password_err"; ?></span><br>
						 <input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>">
						 <input  type="submit" id="login" value="Log in" name="login">
						 <form>
						<input id="signup" type="button" value="Sign up" onclick="window.location.href='http://localhost/LifeAct/Register/SignUp.php';" />
						</form>
						 <br><br>
						 <label id="rememberbox">
						 		<input type="checkbox"  name ="remember">Remember me</checkbox>
						</label>
						<br><br>
						<div class="container-login" style="background-color:#f1f1f1;width:97%;">
							  <button type="button" onclick="document.getElementById('id01').style.display='none'; " id="cancel">Nevermind</button>
							  <span class="psrw">Forgot <a href="#">password?</a></span>
					   </div>
				 </div>
			</form>
		</div>
	</body>
<script type='type/javascript'></script>
	<script>
			function open_close(){
				document.getElementById('id01').style.display='block';
			}
	</script>
	<script>
	$('#username').on('keyup',function(){
		var value = $("input#username").val();
		$('#gif').show();
		$.post( "http://localhost/LifeAct/Homepage/validation.php", { usname:value  },//sto post to usname einai auto pou tha dwsei ta data
			function(data){
				if(data===value+' is valid'){
					$('#gif').hide();
					$('#status').html(data).hide();
					$('#response').hide();
					$('#status').html(data).css("color","green").show();
					$('#login').unbind('click').submit();
			}else
				{
					$('#response').hide();
					$('#status').html(data).css("color","red").show();
					setTimeout(function(){$('#gif').hide();},500);
					$('#login').on('click',function(event){
								event.preventDefault();
				  });
				}
			}
		 );
	});
	</script>
</html>
