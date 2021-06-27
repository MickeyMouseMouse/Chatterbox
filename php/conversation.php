<html>
	<head>
		<meta charset="utf-8">
		<script src="\javascript\jquery-3.6.0.min.js"></script>
		<link rel="stylesheet" type="text/css" href="\css\conversation.css">
	</head>
	
	<body>
		<?php
		session_start();
		$userID = $_SESSION['userID'];
		$conversationID = $_GET['conversationID'];
		
		require_once($_SERVER['DOCUMENT_ROOT']."/php/databaseHandler.php");
		$db = new DatabaseHandler();
		$result = $db->execute("
			SELECT T1.user_id, T1.name, T1.surname
			FROM Users T1, User_to_conversation T2
			WHERE T1.user_id = T2.user_id AND
				T2.user_id != $userID AND
				T2.conversation_id = $conversationID;");
		$db->close();
		
		$row = pg_fetch_row($result);
		$interlocutorID = $row[0];
		$interlocutorName = $row[1];
		$interlocutorSurname = $row[2];
		?>
		<div id="conversation_container">
			<div id="conversation_topPanel">
				<script>
				function openUserPage(id) {
					document.location.href = "/php/userPage.php?id=" + id;
				}
				</script>
				<a id="link" onclick="openUserPage(<?php echo $interlocutorID; ?>)">
					<?php echo $interlocutorName, " ", $interlocutorSurname; ?>
				</a>
			</div>
			<div id="conversation_middlePanel">
				<script>
				function getAllMessages() {  
					$.ajax({  
						url: "../php/chatField.php",
						type: "POST",
						data: "conversationID=<?php echo $conversationID ?>",
						success: function(html){
							var chatField = document.getElementById("conversation_middlePanel");
							$(chatField).html(html);
							chatField.scrollTop = chatField.scrollHeight; // scroll down
						}  
					});  
				}
				
				function checkForNewMessages() {
					$.ajax({  
						url: "../php/checkForNewMessages.php",
						type: "POST",
						data: "conversationID=<?php echo $conversationID; ?>",
						success: function(result){
							if (result == "true")
								getAllMessages();
						}
					});
				} 
				</script> 
			</div>
			<div id="conversation_bottomPanel">
				<div id="conversation_bottomLeftPanel">
					<input id="messageField" name="message" type="text" placeholder="Type a message">
					
					<script>
					function send() {
						var messageField = document.getElementById("messageField");
						if (messageField.value.length != 0) {
							$.ajax({
								url: "../php/addNewMessage.php",
								type: "POST",
								data: "conversationID=<?php echo $conversationID; ?>&message=" + messageField.value
							});
						}
						messageField.value = "";
					}
					
					$(document).ready(function(){  
						var messageField = document.getElementById("messageField");
						messageField.addEventListener('keydown', function(e) {
							if (e.keyCode === 13) // Enter
								send();
						});
						
						getAllMessages();
						setInterval('checkForNewMessages()', 500);
					});  
					</script>
				</div>
				<div id="conversation_bottomRightPanel">
					<button id="buttonSend" onclick="send()">Send</button>
				</div>
			</div>
		</div>
	</body>
</html>