<?php
require_once 'connect.php';
$smsg = "";
$fmsg = "";
if (isset($_GET['username']) && isset($_GET['active'])) {
	$activation= $_GET['active'];
	$username= $_GET['username'];
	
	
	$sql ="SELECT * FROM `user` WHERE username= '$username' AND password= '$activation'";
	$result = mysqli_query($link, $sql);
	$count = mysqli_num_rows($result);
	if($count==1) {
		$smsg .= "Your account is activated successfully.<br />You can login now.";
	}
	else {
		$fmsg .= "The profile is not found";
	}
	
	$sql ="UPDATE `user` SET active='1' WHERE password= '$activation'";

	if ($link->query($sql) === TRUE) {	
		header( "refresh:2;url=login.php" );
	} else {
		$fmsg .= "The activation link was not found" . $link->error;
	}

}
else {
		$fmsg .= "The activation link was not found" . $link->error;
	}
$link->close();
?>
<html>
<head>
    <title>Activation</title>
	<link rel="icon" href="../files/favicon.png">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" >
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
    <link rel="stylesheet" type="text/css" href="../css/userStyle.css">
	<link rel="stylesheet" type="text/css" href="../css/all.css">
</head>
<body>
</body>
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
	</div>
	<footer> 
		<p>by Amir</p>
	</footer>
</html>
