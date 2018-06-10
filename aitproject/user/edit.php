<?php
session_start();
require_once 'connect.php';
$smsg = "";
$fmsg = "";
if(isset($_SESSION['username'])) {
	$username = strval($_SESSION['username']);
	$sql ="SELECT * FROM `user` WHERE username= '$username' AND active= '1'";
	$result = mysqli_query($link, $sql);
	$count = mysqli_num_rows($result);
	if($count==1) {
		while($row = mysqli_fetch_assoc($result)) {
			$email = $row["email"];
			$oldPassSaved = $row["password"];
		}
	}
	if(isset($_POST) & !empty($_POST)) {
		$oldPass = trim($_POST['oldPassword']);
		$oldPass = strip_tags($oldPass);
		$oldPass = htmlspecialchars($oldPass);
		$oldPassword = hash('sha256', $oldPass);
		if($oldPassword == $oldPassSaved) {
			$newPass = trim($_POST['newPassword']);
			$newPass = strip_tags($newPass);
			$newPass = htmlspecialchars($newPass);
			$newPassword = hash('sha256', $newPass);
			$confirmNewPass = trim($_POST['confirmNewPassword']);
			$confirmNewPass = strip_tags($confirmNewPass);
			$confirmNewPass = htmlspecialchars($confirmNewPass);
			$confirmNewPassword = hash('sha256', $confirmNewPass);
			if($newPass == $confirmNewPass) {
				
				if($oldPass != $newPass) {
					$sql ="UPDATE `user` SET email='$email', password='$newPassword' WHERE username= '$username'";
					if ($link->query($sql) === TRUE) {	
						$smsg .= "The account is updated.<br />You should log in again!";
						session_destroy();
						header( "refresh:2;url=.." );
						
					} else {
						$fmsg .= "The account is not updated.";
					}
					
				}
				else {
					$fmsg .= "You should use another password.<br />";
				}
			}
			else {
				$fmsg .= "Password doesn't match. <br />";
			}
		}
		else {
			$fmsg .= "The password is wrong.";
		}
		
		
		
	}
}
else {
	$fmsg .= "You have not logged in!";
	header( "refresh:2;url=index.php" );
}
$link->close();
?>

<html>
<head>
    <title>Edit the Profile</title>
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
		<form class="form-signin" method="POST">
			<h2 class="form-signin-heading">Edit the Profile</h2>
			<div class="input-group">
                <span class="input-group-addon" id="basic-addon1">@</span>
                <input type="text" name="username" class="form-control" value="<?php echo $username ?>" readonly>
			</div>
			<label for="inputEmail" class="sr-only">Email address</label>
			<input type="email" name="email" id="inputEmail" class="form-control" placeholder="<?php echo $email;?>" value="<?php echo $email; ?>" required>
			<label for="oldPassword" class="sr-only">Old Password</label>
			<input type="password" name="oldPassword" id="oldPassword" class="form-control" placeholder="Old Password" required>
			<label for="newPassword" class="sr-only">New Password</label>
			<input type="password" name="newPassword" id="newPassword" class="form-control" placeholder="New Password" required>
			<label for="confirmNewPassword" class="sr-only">Confirm New Password</label>
			<input type="password" name="confirmNewPassword" id="confirmNewPassword" class="form-control" placeholder="Confirm New Password" required>
			<button class="btn btn-lg btn-primary btn-block" type="submit">Edit</button>
		</form>
	</div>
	<footer> 
		<p>by Amir</p>
	</footer>
</html>