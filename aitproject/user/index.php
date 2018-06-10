<?php
session_start();
require_once 'connect.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require_once("vendor/autoload.php");
$smsg = "";
$fmsg = "";
$tmpmsg = "";
$mailFlag = false;
$url = "../files/".strval($_SESSION['file']);
$file = strval($_SESSION['file']);
//$format = substr($file, strlen($file)-3, strlen($file));
	
$str = "";
$userFlag = false;
$downloadFlag = false;
if(isset($_SESSION['username'])) {
	$userFlag = true;
	$str .= "Hi ";
	$yourUser = $_SESSION['username'];
	$str .= $yourUser;
	$smsg .= $str."<br />";
	if(isset($_SESSION['file'])) {
		$downloadFlag = true;
	}
}
else {
	$str = "Please register or login";
	if(isset($_SESSION['file'])) {
		$fmsg .= "You should log in or register first.";
		
	}
}

if ($downloadFlag) {
	sendingFile();
	if($mailFlag) {
		$smsg .= "The file, named ".$_SESSION['file'].", is sent to ".$_SESSION['email']."<br />";
		$mailFlag = false;
	}
	else {
		$fmsg .= $tmpmsg;
		$fmsg .= '<br />Message was not sent.';
		header( "refresh:1;url=login.php" );
	}
	
}


$tmpuser = $_SESSION['username'];
$tmpemail = $_SESSION['email'];
unset($_SESSION["file"]);
session_destroy();
session_start();
$_SESSION['username'] = $tmpuser;
$_SESSION['email'] = $tmpemail;
		
		
function sendingFile() {
	include('config.php');
	$mail = new PHPMailer(true);
	
	try {
		global $url;
		global $file;
		global $format;
		//Server settings
		// $mail -> SMTPDebug = 2;
		$mail -> isSMTP();
		$mail -> SMTPAuth = true;
		
		$mail -> Host = $smtphost;
		$mail -> Port = 587;
		$mail -> SMTPSecure = 'tls';
		$mail -> SMTPAuth = true;
		$mail -> Username = $smtpuser;
		$mail -> Password = $smtppass;
		
		// //Recipients
		$mail -> setFrom('noreply@aitpr.com', 'Admin');
		$mail -> addAddress($_SESSION['email']);
		
		// // //Content
		$mail -> isHTML(true);
		$mail -> Subject = 'File from AitPr Website';
		$mail -> Body    = '<html><h1>Hello '.$_SESSION['username'].',</h1><br /><p>Your file is following.</p><br /><h3>Regards,<h3>AitPr Team</h3></html>';
		$mail -> AltBody = 'Please check the file.';
		$mail-> AddAttachment($url, $file);
		if($mail->send()) {
			global $mailFlag;
			$mailFlag = true;
		}
		
	}
	catch (Exception $e) {
		global $tmpmsg;
		$tmpmsg .= $e->getMessage();
		$tmpmsg .= '<br />Mailer error: ' . $mail->ErrorInfo;
	}
		
	
		
}
$link->close();
?>
<html>
<head>
	<title><? echo $str; ?></title>
	<link rel="icon" href="../files/favicon.png">
	<link rel="stylesheet" href="../css/all.css">
	<link rel="stylesheet" href="../css/userStyle.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Black+Han+Sans|Cabin|Istok+Web" rel="stylesheet">
</head>
<body>
<header> 
	<div id="menu">
		<a href="../">Home</a><br />
		<a>User</a><br />
		<a href="../pages">OpenData</a><br />
		<a href="../search">Search</a>
	</div>
</header>
<div class="container">
	<?php if( $smsg != "" ) {?><div class="alert alert-success" role="alert"><?php echo $smsg; ?></div><?php }?>
    <?php if( $fmsg != "" ) {?><div class="alert alert-danger" role="alert"><?php echo $fmsg; ?></div><?php }?>
</div>
<article class="articles">
	<aside>
		<h1><?php if($userFlag) {echo "<a href=\"edit.php\">Edit</a>";} ?></h1>
		<h1><?php if($userFlag) {echo "<a href=\"logout.php\">Log out</a>";} ?></h1>
		<h1><?php if(!$userFlag) {echo "<a href=\"register.php\">Register</a>";} ?></h1>
		<h1><?php if(!$userFlag) {echo "<a href=\"login.php\">Log in</a></br>";} ?></h1>
		<h1><?php if(!$userFlag) {echo "<a href=\"forget.php\">Forget the Password</a>";} ?></h1>
	</aside>
</article>
<footer> 
<p>by Amir</p>
</footer>
</body>
</html>