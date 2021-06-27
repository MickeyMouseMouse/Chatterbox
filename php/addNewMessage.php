<?php
	session_start();
	$userID = $_SESSION['userID'];
	$conversationID = $_POST['conversationID'];
	$message = $_POST['message'];
	
	require_once($_SERVER['DOCUMENT_ROOT']."/php/databaseHandler.php");
	$db = new DatabaseHandler();
	$result = $db->execute("INSERT INTO Messages(conversation_id, sender_id, message)
		VALUES($conversationID, $userID, '$message');");
	$db->close();
?>