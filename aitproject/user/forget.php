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
		$email = mysqli_real_escape_string($link, $_POST['email']); 
		$sql = "SELECT * FROM `user` WHERE email = '$email'";	
		$result = mysqli_query($link, $sql);
		$count = mysqli_num_rows($result);
		if($count == 1) {
			while($row = mysqli_fetch_assoc($result)) {
				$password = $row["password"];
			}
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
				$mail -> Subject = 'Do you forget your password?';
				$mail -> Body    = '<html>It seems that you are supposed to change your password on AITPr<p>Reset Password: <a href="localhost/aitproject/user/reset.php?email='.$email.'&pass='.$password.'">Reset</a></p><br/><p>by AitPr Team</p></html>';
				$mail -> AltBody = 'Dear '.$username. 'Thanks for joining.';
				
				
				$mail -> send();
			}
			catch (Exception $e) {
				$fmsg .= $e->getMessage();
			}
			
			
			$smsg .= "The password was sent to ".$email."<br />";
			header( "refresh:1;url=.." );
		}
		else {
			$fmsg .= "Invalid Email";
		}
	}
}
$link->close();
?>
<html>
<head>
    <title>Forget the Password</title>
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
				<h2 class="form-signin-heading">Forget the Password</h2>
				<label for="inputEmail" class="sr-only">Email address</label>
				<input type="email" name="email" id="inputEmail" class="form-control" placeholder="Email address" value="<?php if(isset($email) & !empty($username)) { echo $email; } ?>" required autofocus>
				<div class="g-recaptcha" data-sitekey="6LcO2V0UAAAAALfBChyFk8walgzxBNmz6tdkIPr5"></div>
				<button class="btn btn-lg btn-primary btn-block" type="submit">Send the Password</button>
			</form>
		<?php }?>
    </div>
	<footer> 
		<p>by Amir</p>
	</footer>
    
</body>
</html>
