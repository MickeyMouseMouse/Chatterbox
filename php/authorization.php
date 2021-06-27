<html>
	<head>
		<meta charset="utf-8">
		<link rel="icon" href="..\images\favicon.ico" type="image/x-icon">
		<title>Chatterbox - Authorization</title>
		<link rel="stylesheet" type="text/css" href="\css\authorization.css">
		<script src="\javascript\authorization.js" async></script>
	</head>
	
	<body>
		<?php
		require($_SERVER['DOCUMENT_ROOT']."\php\loginByCookie.php");
		if (isset($_GET['error'])) $error = true;
		?>
		
		<div id="authorization">
			<div id="labelHeader">Authorization</div>
			<form id="form" action="/php/loginByPassword.php" method="post" onsubmit="check(this);return false;">
				<div>
					<input id="loginField" name="login" type="text" class="textField" placeholder="Login">
				</div>
				<div>
					<input id="passwordField" name="password" type="password" class="textField" placeholder="Password">
				</div>
				<div id="bottomPanel">
					<div id="bottomLeftPanel">
						<button id="buttonLogIn" type="submit">Log in</button>
					</div>
					<div id="bottomRightPanel">
						<a id="linkSignUp" href="/php/registration.php">Sign up</a>
					</div>
				</div>
			</form>
			<?php if (!empty($error)): ?>
			<div id="errorMessage">Invalid login or password</div>
			<?php endif; ?>
		</div>
	</body>
</html>