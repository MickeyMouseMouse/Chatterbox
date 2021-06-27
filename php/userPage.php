<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="\css\userPage.css">
		<script src="\javascript\jquery-3.6.0.min.js"></script>
	</head>
	
	<body>
		<?php
		session_start();
		$userID = $_SESSION['userID'];
		$id = $_GET['id'];
		switch ($id) {
			case "myPage":
				$myPage = true;
				$id = $userID;
				break;
			case $userID:
				$myPage = true;
				break;
			default:
				$myPage = false;
		}
		if ($myPage) {
			$edit = false;
			if (isset($_GET['edit']))				
				if ($_GET['edit'] == "true")
					$edit = true;
		}
		
		require_once($_SERVER['DOCUMENT_ROOT']."/php/databaseHandler.php");
		$db = new DatabaseHandler();
		$result = $db->execute("SELECT name, surname, profile_photo, status, last_access_time FROM Users WHERE user_id = $id");
		$db->close();
		$row = pg_fetch_row($result);
		$name = $row[0];
		$surname = $row[1];
		
		$path = $row[2];
		if ($path == "f" || $path == "false")
			$path = "../images/profilesPhotos/default.png";
		else
			$path = "../images/profilesPhotos/$id.png";
		
		$status = $row[3];
		
		$online = "offline";
		if (time() - $row[4] <= 120)
			$online = "online";

		?>
	
		<div id="userPage_container">
			<div id="userPage_topPanel">
				<div id="userPage_userPhotoPanel">
					<img id="userPhoto" src=<?php echo $path; ?>>
				</div>
				<div id="userPage_userInfoPanel">
					<div id="userPage_userInfoTopPanel">
						<div id="userPage_userNamePanel">
							<p id="userNameField"><?php echo $name, ' ', $surname; ?></p>
						</div>
						<div id="userPage_userOnlineStatusPanel">
							<p id="userOnlineStatusField"><?php echo $online; ?></p>
						</div>
					</div>
					<div id="userPage_userInfoBottomPanel">
						<p id="userStatusField"><?php echo $status; ?></p>
					</div>
				</div>
			</div>
			
			<div id="userPage_bottomPanel">
				<?php
				if (!$myPage): ?>
					<div>
						<script>
						function writeMessage(interlocutorID) {
							$.ajax({  
								url: "../php/writeMessage.php",
								type: "GET",
								data: "interlocutorID=" + interlocutorID,
								success: function(conversationID){
									document.location.href = "../php/conversation.php?conversationID=" + conversationID; 
								}  
							});
						}
						</script>
						
						<button id="writeMessageButton" onclick="writeMessage(<?php echo $id; ?>)">Write a message</button>
					</div>
				<?php
				else:
					if (!$edit):?>
						<script>
						function showEditMenu() {
							document.location.href = "../php/userPage.php?id=myPage&edit=true";
						}
						</script>
					
						<button id="editButton" onclick="showEditMenu()">Edit</button>
					<?php
					else: ?>
						<form
							enctype="multipart/form-data"
							action="/php/updateUserData.php"
							method="post">
							<div class="listItem">
								New profile photo:
								<input id="browseButton" name="profilePhoto" type="file">
							</div>
							<div class="listItem">
								<input name="newName" type="text" placeholder="New name">
							</div>
							<div class="listItem">
								<input name="newSurname" type="text" placeholder="New surname">
							</div>
							<div class="listItem">
								<input name="newStatus" type="text" placeholder="New status">
							</div>
							<div class="listItem">
								<input name="oldPassword" type="password" placeholder="Old password">
								<input name="newPassword" type="password" placeholder="New password">
							</div>
							<div class="listItem">
								<button id="updateButton" button="submit">Update</button>
								
								<script>
								function closeEditMenu() {
									document.location.href = "../php/userPage.php?id=myPage&edit=false";
								}
								</script>
								<button id="closeButton" type="button" onclick="closeEditMenu()">Close</button>
							</div>
						</form>
					<?php
					endif;
				endif ?>
			</div>
		</div>
	</body>
</html>