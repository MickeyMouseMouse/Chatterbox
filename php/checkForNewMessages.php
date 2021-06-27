<?php
session_start();
$userID = $_SESSION['userID'];
$conversationID = $_POST['conversationID'];

require_once($_SERVER['DOCUMENT_ROOT']."/php/databaseHandler.php");
$db = new DatabaseHandler();
$result = $db->execute("SELECT last_read_message_id FROM User_to_conversation 
	WHERE user_id = $userID AND conversation_id = $conversationID");
$lastReadMessageID = pg_fetch_row($result)[0];

$result = $db->execute("SELECT message_id FROM Messages 
						WHERE conversation_id = $conversationID
						ORDER BY message_id DESC LIMIT 1;");
$db->close();
$lastMessageID = pg_fetch_row($result)[0];

if ($lastMessageID > $lastReadMessageID)
	echo "true";
else
	echo "false";
?>