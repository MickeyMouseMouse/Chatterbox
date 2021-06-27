<html>
	<head>
		<meta charset="utf-8">
		<link rel="icon" href="..\images\favicon.ico" type="image/x-icon">
		<title>Chatterbox</title>
		<link rel="stylesheet" type="text/css" href="\css\chatterbox.css">
		<script src="\javascript\chatterbox.js"></script>
		<script src="\javascript\jquery-3.6.0.min.js"></script>
	</head>
	
	<body>
		<div id="chatterbox_container">
			<div id="chatterbox_topPanel">
				<div id="chatterbox_topLeftPanel">
					<img src="../images/logo.png">
				</div>
				
				<div id="chatterbox_topCenterPanel">
					<input id="searchField" type="text" placeholder="People search">
					<button id="buttonFind" class="button" onclick="find()">Find</button>
				</div>
				
				<div id="chatterbox_topRightPanel">
					<button id="buttonLogOut" class="button" onclick="logout()">Log out</button>
				</div>
			</div>
			
			<div id="chatterbox_bottomPanel">
				<div id="chatterbox_bottomLeftPanel">
					<div>
						<button id="buttonMyPage" class="button" onclick="openUserPage('myPage')">My Page</button>
					</div>
					<div>
						<button id="buttonMessanger" class="button" onclick="messenger()">Messenger</button>
					</div>
				</div>
				
				<iframe id="chatterbox_bottomRightPanel">Your browser doesn't support iframe tag</iframe>
				<script>
				$(document).ready(function(){  
					var searchField = document.getElementById("searchField");
					searchField.addEventListener('keydown', function(e) {
						if (e.keyCode === 13) // Enter
							find();
					});
					
					openUserPage("myPage");
				});  
				</script>
			</div>
		</div>
	</body>
</html>