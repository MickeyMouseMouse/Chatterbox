<?php
function error() {
	header("Location: authorization.php?error");
	exit;
}

$login = $_POST['login'];
$password = $_POST['password'];

require_once($_SERVER['DOCUMENT_ROOT']."/php/databaseHandler.php");
$db = new DatabaseHandler();
$result = $db->execute("SELECT user_id, password FROM Users WHERE login='$login'");

$row = pg_fetch_row($result);
if (!$row) error(); // there is no such user login
if (password_verify($password, $row[1])) {
	$userID = $row[0];
	
	require($_SERVER['DOCUMENT_ROOT']."/php/cookieGenerator.php");
	$cookie = getCookie();
	$cookie_options = array('expires' => time() + 24 * 60 * 60, 'path' => '/');
	setcookie("login", "$login", $cookie_options);
	setcookie("key", "$cookie", $cookie_options);
	$db->execute("UPDATE Users SET cookie='$cookie' WHERE user_id=$userID;");
}
else // wrong password
	error();
$db->close();

session_start();
$_SESSION['userID'] = $userID;
header("Location: chatterbox.php");
exit;
?>