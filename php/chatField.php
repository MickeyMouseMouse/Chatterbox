<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="\css\chatField.css">
	</head>
	
	<body>
		<?php
		session_start();
		$userID = $_SESSION['userID'];
		$conversationID = $_POST['conversationID'];
		
		require_once($_SERVER['DOCUMENT_ROOT']."/php/databaseHandler.php");
		$db = new DatabaseHandler();
		$result = $db->execute("SELECT message_id, sender_id, message FROM Messages WHERE conversation_id = $conversationID");
		?>
		
		<div id="dialog_container">
		<?php
		while ($row = pg_fetch_row($result)):
			if ($row[1] == $userID):?>	
				<div class="myMessage"><?php echo $row[2]; ?></div>
			<?php
			else: ?>
				<div class="interlocutorMessage"><?php echo $row[2]; ?></div>
		<?php
			endif;
		endwhile; ?>
		</div>
		
		<?php
		$rowsNumber = pg_num_rows($result);
		if ($rowsNumber != 0) {
			$lastMessageID = pg_fetch_row($result, $rowsNumber - 1)[0];
			$result = $db->execute("UPDATE User_to_conversation SET last_read_message_id = $lastMessageID
										WHERE user_id = $userID AND conversation_id = $conversationID");
		}
		$db->close();
		?>
	</body>
</html>