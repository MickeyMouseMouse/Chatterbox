<?php
	session_start();
	$userID = $_SESSION['userID'];
	session_destroy();
	
	require_once($_SERVER['DOCUMENT_ROOT']."/php/databaseHandler.php");
	$db = new DatabaseHandler();
	$result = $db->execute("UPDATE Users SET last_access_time=null, cookie=null WHERE user_id = $userID");
	$db->close();
	
	$cookie_options = array('expires' => time(), 'path' => '/');
	setcookie("login", "", $cookie_options);
	setcookie("key", "", $cookie_options);
	
	header('Location: authorization.php');
	exit;
?>