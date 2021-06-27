<?php
if (!empty($_COOKIE["login"]) and !empty($_COOKIE["key"])) {
	$login = $_COOKIE['login']; 
	$key = $_COOKIE['key'];
	
	require_once($_SERVER['DOCUMENT_ROOT']."/php/databaseHandler.php");
	$db = new DatabaseHandler();
	$result = $db->execute("SELECT user_id FROM Users WHERE login='$login' and cookie='$key'");
	$db->close();
	$row = pg_fetch_row($result);
	if (!empty($row)) {
		session_start();
		$_SESSION['userID'] = $row[0];
		header("Location: php/chatterbox.php");
		exit;
	}
}
?>