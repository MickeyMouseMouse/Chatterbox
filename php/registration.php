<html>
	<head>
		<meta charset="utf-8">
		<link rel="icon" href="..\images\favicon.ico" type="image/x-icon">
		<title>Chatterbox - Registration</title>
		<link rel="stylesheet" type="text/css" href="..\css\registration.css">
		<script src="..\javascript\registration.js" async></script>
	</head>
	
	<body>
		<?php
		if (isset($_GET['error'])) {
			if ($_GET['error'] === "login") $error = "This login already exists";
			if ($_GET['error'] === "password") $error = "The password must be 8 characters or longer";
		}
		?>
		
		<div id="registration">
			<div id="labelHeader">Registration</div>
			<form id="form" action="\php\signup.php" method="post" onsubmit="check(this);return false;">
				<div>
					<input id="loginField" name="login" type="text" class="textField" placeholder="Login">
				</div>
				<div>
					<input id="passwordField" name="password" type="password" class="textField" placeholder="Password">
				</div>
				<div>
					<input id="nameField" name="name" type="text" class="textField" placeholder="Name">
				</div>
				<div>
					<input id="surnameField" name="surname" type="text" class="textField" placeholder="Surname">
				</div>
				<div id="bottomPanel">
					<div id="bottomLeftPanel">
						<button id="buttonSignUp" onclick="signup()">Sign up</button>
					</div>
					<div id="bottomRightPanel">
						<a id="linkLogIn" href="\php\authorization.php">Log in</a>
					</div>
				</div>
			</form>
			
			<?php if (!empty($error)):?>
			<div class="errorMessage"><?php echo $error; ?></div>
			<?php endif; ?>
		</div>
	</body>
</html>