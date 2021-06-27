<?php
function error($error) {
	header("Location: registration.php?error=$error");
	exit;
}

$login = $_POST['login'];
$password = $_POST['password'];
$name = $_POST['name'];
$surname = $_POST['surname'];

require_once($_SERVER['DOCUMENT_ROOT']."/php/databaseHandler.php");
$db = new DatabaseHandler();
$result = $db->execute("SELECT login FROM Users");
while ($row = pg_fetch_row($result))
	if ($row[0] == $login) error("login"); // login already exists

if (strlen($password) < 8) error("password"); // the password is weak


require($_SERVER['DOCUMENT_ROOT'].'/php/cookieGenerator.php');
$cookie = getCookie();
$cookie_options = array('expires' => time() + 24 * 60 * 60, 'path' => '/');
setcookie("login", "$login", $cookie_options);
setcookie("key", "$cookie", $cookie_options);

$password = password_hash($password, PASSWORD_DEFAULT);
$result = $db->execute("INSERT INTO Users(login, password, cookie, name, surname, profile_photo, status, last_access_time)
VALUES ('$login', '$password', '$cookie', '$name', '$surname', FALSE, '', null) RETURNING user_id");
$userID = pg_fetch_row($result)[0];
$db->close();

session_start();
$_SESSION['userID'] = $userID;
header("Location: chatterbox.php");
exit();
?>