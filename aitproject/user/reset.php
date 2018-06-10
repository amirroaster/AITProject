<?php
session_start();
require_once 'connect.php';
$smsg = "";
$fmsg = "";
if(isset($_SESSION['username'])) {
	$regBlock = true;
    $smsg .= "User already logged in";
}
else {
	if (isset($_GET['email']) && isset($_GET['pass'])) {
	$email= $_GET['email'];
	$pass= $_GET['pass'];
	
	
	$sql ="SELECT * FROM `user` WHERE email= '$email' AND password= '$pass'";
	$result = mysqli_query($link, $sql);
	$count = mysqli_num_rows($result);
	if($count == 1) {
		while($row = mysqli_fetch_assoc($result)) {
			$username = $row['username']; 
			if(isset($_POST) & !empty($_POST)) {
				$newPass = trim($_POST['newPassword']);
				$newPass = strip_tags($newPass);
				$newPass = htmlspecialchars($newPass);
				$newPassword = hash('sha256', $newPass);
				$confirmNewPass = trim($_POST['confirmNewPassword']);
				$confirmNewPass = strip_tags($confirmNewPass);
				$confirmNewPass = htmlspecialchars($confirmNewPass);
				$confirmNewPassword = hash('sha256', $confirmNewPass);
				if($newPass == $confirmNewPass) {
					$sql ="UPDATE `user` SET password='$newPassword' WHERE email= '$email' AND password= '$pass'";
					if ($link->query($sql) === TRUE) {	
						$smsg .= "Password is changed.<br />You can log in with the new password.";
						header( "refresh:2;url=login.php" );
					} else {
						$fmsg .= "The profile is not found" . $link->error;
					}
				}
				else {
					$fmsg .= "Password does not match<br />";
				}
			}
		}
	}
	// if($count==1) {
		// if(isset($_POST) & !empty($_POST)) {
			// $newPass = trim($_POST['newPassword']);
			// $newPass = strip_tags($newPass);
			// $newPass = htmlspecialchars($newPass);
			// $newPassword = hash('sha256', $newPass);
			// $confirmNewPass = trim($_POST['confirmNewPass']);
			// $confirmNewPass = strip_tags($confirmNewPass);
			// $confirmNewPass = htmlspecialchars($confirmNewPass);
			// $confirmNewPassword = hash('sha256', $confirmNewPass);
			// if($newPass == $confirmNewPass) {
				// $sql ="UPDATE `user` SET password='newPassword' WHERE email= '$email' AND password= '$pass'";
				// if ($link->query($sql) === TRUE) {	
					// $smsg .= "Password is changed.<br />You should log in again.";
					// // header( "refresh:2;url=login.php" );
				// } else {
					// $fmsg .= "The profile is not found" . $link->error;
				// }
			// }
			// else {
				// $fmsg .= "Password does not match<br />";
			// }
		// }
		// else {
			// $fmsg .= "The profile is not found";
		// }
		// else {
			// $fmsg .= "The profile is not found";
		// }
	}
	else {
			$fmsg .= "The profile is not found" . $link->error;
	}
}

$link->close();
?>
<html>
<head>
    <title>Reset Password</title>
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
		<?php if ( $regBlock == false ) {?>
			<form class="form-signin" method="POST">
				<h2 class="form-signin-heading">Reset the Password</h2>
				<div class="input-group">
					<span class="input-group-addon" id="basic-addon1">@</span>
					<input type="text" name="username" class="form-control" value="<?php echo $username ?>" readonly>
				</div>
				<label for="newPassword" class="sr-only">New Password</label>
				<input type="password" name="newPassword" id="newPassword" class="form-control" placeholder="New Password" required>
				<label for="confirmNewPassword" class="sr-only">Confirm New Password</label>
				<input type="password" name="confirmNewPassword" id="confirmNewPassword" class="form-control" placeholder="Confirm New Password" required>
				<button class="btn btn-lg btn-primary btn-block" type="submit">Reset</button>
			</form>
		<?php }?>
	</div>
	<footer> 
		<p>by Amir</p>
	</footer>
</html>
