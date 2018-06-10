<?php
session_start();
require_once 'connect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require_once("vendor/autoload.php");
$mail = new PHPMailer(true);
$smsg = "";
$fmsg = "";
$regBlock = false;
require_once "recaptchalib.php";
$secret = "6LcO2V0UAAAAAMy6Hn8L8hNXL7XrpngZDr61l-_n";
$response = null;
$reCaptcha = new ReCaptcha($secret);

if(isset($_SESSION['username'])) {
	$regBlock = true;
    $smsg .= "User already logged in";
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
		$email = mysqli_real_escape_string($link, $_POST['email']);  
		$pass = trim($_POST['password']);
		$pass = strip_tags($pass);
		$pass = htmlspecialchars($pass);
		$password = hash('sha256', $pass);
		$passagain = trim($_POST['passwordagain']);
		$passagain = strip_tags($passagain);
		$passagain = htmlspecialchars($passagain);
		$passwordagain = hash('sha256', $passagain);
		if($pass == $passagain) {
		
			$usernamesql = "SELECT * FROM `user` WHERE username = '$username'";
			$usernameres = mysqli_query($link, $usernamesql);
			$count = mysqli_num_rows($usernameres);
			if($count == 1) {
				$fmsg .= "Username Exists in the Database, please try a different username<br />";
			}
			
			$emailsql = "SELECT * FROM `user` WHERE email = '$email'";
			$emailres = mysqli_query($link, $emailsql);
			$count = mysqli_num_rows($emailres);
			if($count == 1) {
				$fmsg .= "Email Exists in the Database, please try a different email<br />";
			}
			
			$sql ="INSERT INTO `user`(username, email, password) VALUES ('$username','$email','$password')";
			$result = mysqli_query($link, $sql);
			if($result) {
				$smsg .= "User Registration Successful<br />";
				include('config.php');

				try {
					// // //Server settings
					// $mail -> SMTPDebug = 2;
					$mail -> isSMTP();
					$mail -> Host = $smtphost;
					$mail -> Port = 587;
					$mail -> SMTPSecure = 'tls';
					$mail -> SMTPAuth = true;
					$mail -> Username = $smtpuser;
					$mail -> Password = $smtppass;
					
					//Recipients
					$mail -> setFrom('noreply@aitpr.com', 'Admin');
					$mail -> addAddress($email);
					
					//Content
					$mail -> isHTML(true);
					$mail -> Subject = 'Activation Link';
					$mail -> Body    = '<html>Dear '.$username.'<br/><br/>Registration Email: '.$email.'<p>Activation link: <a href="localhost/aitproject/user/activate.php?username='.$username.'&active='.$password.'">Activate</a></p><p>We are too glad.</p><br/><p>by AitPr Team</p></html>';
					//$mail -> Body    = '<html><a href=\"//https://localhost/aitproject/user/activate.php?username'.$username.'&active='.$password.'\">Activate your profile</a></html>';
					$mail -> AltBody = 'Dear '.$username. 'Thanks for joining.';
					
					
					$mail -> send();
				}
				catch (Exception $e) {
					$fmsg .= $e->getMessage();
				}
				
				
				$smsg .= "The activation link was sent to your email.<br />";
				header( "refresh:1;url=.." );

						
			}
			else {
				$fmsg .= "Failed to register user<br />";
			}
		}
		else {
			$fmsg .= "Password does not match<br />";
		}
		
	  } else {
		$fmsg .= "Failure response form google reCaptcha";
	}	
}
$link->close();
?>
<html>
<head>
    <title>Registration</title>
	<link rel="icon" href="../files/favicon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" type="text/css" href="../css/userstyle.css">
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
				<h2 class="form-signin-heading">Registraion</h2>
				<div class="input-group">
					<span class="input-group-addon" id="basic-addon1">@</span>
					<input type="text" name="username" class="form-control" placeholder="Username" value="<?php if(isset($username) & !empty($username)) { echo $username; } ?>" required>
				</div>
				<label for="inputEmail" class="sr-only">Email address</label>
				<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" value="<?php if(isset($email) & !empty($username)) { echo $email; } ?>" required autofocus>
				<label for="inputPassword" class="sr-only">Password</label>
				<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
				<label for="inputPassword" class="sr-only">Password Again</label>
				<input type="password" name="passwordagain" id="inputPasswordagain" class="form-control" placeholder="Confirm Password" required>
				<div class="g-recaptcha" data-sitekey="6LcO2V0UAAAAALfBChyFk8walgzxBNmz6tdkIPr5"></div>
				<button class="btn btn-lg btn-primary btn-block" type="submit">Register</button>
				<a class="btn btn-lg btn-primary btn-block" href="login.php">Login</a>
				<a class="btn btn-lg btn-primary btn-block" href="forget.php">Forget the Password</a>
			</form>
		<?php }?>
    </div>
	<footer> 
		<p>by Amir</p>
	</footer>
    
</body>
</html>