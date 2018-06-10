<?php
session_start();
require_once 'connect.php';

require_once "recaptchalib.php";
$secret = "6LcO2V0UAAAAAMy6Hn8L8hNXL7XrpngZDr61l-_n";
$response = null;
$reCaptcha = new ReCaptcha($secret);
$smsg = "";
$fmsg = "";
$regBlock = false;
if(isset($_SESSION['username'])) {
    $smsg .= "User already logged in";
	$regBlock = true;
}
else if(isset($_POST) & !empty($_POST)) {
	
	if ($_POST["g-recaptcha-response"]) {
		$response = $reCaptcha->verifyResponse(
			$_SERVER["REMOTE_ADDR"],
			$_POST["g-recaptcha-response"]
		);
	}
	 
	if ($response != null && $response->success) {
		
		$username = mysqli_real_escape_string($link, $_POST['username']);
		$pass = trim($_POST['password']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		$password = hash('sha256', $pass);
		
		$sql ="SELECT * FROM `user` WHERE username= '$username' AND password= '$password' AND active= '1'";
		
		$result = mysqli_query($link, $sql);
		$count = mysqli_num_rows($result);
		if($count==1) {
			while($row = mysqli_fetch_assoc($result)) {
				$_SESSION['username'] = $row["username"];
				$_SESSION['email'] = $row["email"];
				header( "refresh:1;url=.." );
			}
		}
		else {
			$fmsg .= "Invalid Username/Password<br />Also probably you have not activated your account";
		}
	}
	else {
		$fmsg .= "Failure response form google reCaptcha";
	}
}


$link->close();
?>
<html>
<head>
    <title>User Login</title>
	<link rel="icon" href="../files/favicon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" type="text/css" href="../css/userStyle.css">
	<link rel="stylesheet" type="text/css" href="../css/all.css">
</head>
<body>
	<header> 
		<div id="menu">
			<a href="../">Home</a><br />
			<a href="../user">User</a><br />
			<a href="../pages">OpenData</a><br />
			<a href="../search">Search</a>
		</div>
	</header>
    <div class="container">
        <?php if( $smsg != "" ) {?><div class="alert alert-success" role="alert"><?php echo $smsg; ?></div><?php }?>
        <?php if( $fmsg != "" ) {?><div class="alert alert-danger" role="alert"><?php echo $fmsg; ?></div><?php }?>
        <?php if ( $regBlock == false ) {?>
			<form class="form-signin" method="POST">
				<h2 class="form-signin-heading">Please Login</h2>
				<div class="input-group">
					<span class="input-group-addon" id="basic-addon1">@</span>
					<input type="text" name="username" class="form-control" placeholder="Username" required>
				</div>
				<label for="inputPassword" class="sr-only">Password</label>
				<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
				<div class="g-recaptcha" data-sitekey="6LcO2V0UAAAAALfBChyFk8walgzxBNmz6tdkIPr5"></div>
				<button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
				<a class="btn btn-lg btn-primary btn-block" href="register.php">Register</a>
				<a class="btn btn-lg btn-primary btn-block" href="forget.php">Forget the Password</a>
			</form>
		<?php }?>
    </div>
    <footer> 
		<p>by Amir</p>
	</footer>
</body>
</html>