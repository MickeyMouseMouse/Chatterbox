<?php
session_start();
$userID = $_SESSION['userID'];
$interlocutorID = $_GET['interlocutorID'];

require_once($_SERVER['DOCUMENT_ROOT']."/php/databaseHandler.php");
$db = new DatabaseHandler();
$result = $db->execute("
	SELECT T1.conversation_id FROM User_to_conversation T1
	WHERE user_id = $userID AND
	EXISTS (SELECT T2.conversation_id FROM User_to_conversation T2
		WHERE user_id = $interlocutorID AND T1.conversation_id = T2.conversation_id);");
$row = pg_fetch_row($result);
if (empty($row)) {
	$result = $db->execute("INSERT INTO Conversations(is_dialog, name) 
		VALUES (TRUE, NULL) RETURNING conversation_id");
	$conversationID = pg_fetch_row($result)[0];
	
	$db->execute("INSERT INTO User_to_conversation(user_id, conversation_id, last_read_message_id) 
		VALUES ($userID, $conversationID, NULL)");
	$db->execute("INSERT INTO User_to_conversation(user_id, conversation_id, last_read_message_id) 
		VALUES ($interlocutorID, $conversationID, NULL)");
} else {
	$conversationID = $row[0];
}
$db->close();

echo $conversationID;
?>