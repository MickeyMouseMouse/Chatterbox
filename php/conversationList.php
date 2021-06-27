<html>
	<head>
		<meta charset="utf-8" http-equiv="Refresh" content="5">
		<link rel="stylesheet" type="text/css" href="\css\conversationList.css">
		<script src="\javascript\jquery-3.6.0.min.js"></script>
	</head>
	
	<body>
		<div id="conversationList_container">
			<div id="conversationList_labelHeader">Conversations</div>
			<div> <hr id="conversationList_separator"> </div>
			<div id="conversationList_list">
				<?php
				session_start();
				$userID = $_SESSION['userID'];
				
				require_once($_SERVER['DOCUMENT_ROOT']."/php/databaseHandler.php");
				$db = new DatabaseHandler();
				$result = $db->execute("
					SELECT T2.conversation_id, T1.user_id, T1.name, T1.surname, T1.last_access_time
					FROM Users T1, User_to_conversation T2
					WHERE T1.user_id = T2.user_id AND
						T2.user_id != $userID AND
						T2.conversation_id IN (SELECT conversation_id FROM User_to_conversation WHERE user_id = $userID);");
				$db->close();
				
				$number = 0;
				while ($row = pg_fetch_row($result)): ?>
					<div class="conversationList_listItem">
						<div class="conversationList_leftPanel">
							<?php ++$number; ?>
							<script>
							function openConversation(conversationID) {
								document.location.href = "../php/conversation.php?conversationID=" + conversationID;  
							}
							</script>
						
							<a 
								class="conversationList_link"
								onclick="openConversation(<?php echo $row[0]; ?>)">
									<?php echo $row[2], " ", $row[3] ?>
							</a>
						</div>
						<div class="conversationList_centerPanel">
							<span id="<?php echo $number?>" class="conversationList_newMessagesFlag">
								<script>
								$.ajax({  
									url: "../php/checkForNewMessages.php",
									type: "POST",
									data: "conversationID=" + <?php echo $row[0] ?>,
									success: function(text){
										if (text == "true")
											document.getElementById("<?php echo $number; ?>").textContent = "●";
									}  
								});
								</script>
							<span>
						</div>
						<div class="conversationList_rightPanel">
							<?php
							if (time() - $row[4] <= 120)
								echo "online";
							else
								echo "offline";
							?>
						</div>
					</div>
				<?php endwhile; ?>
			</div>
		</div>
	</body>
</html>