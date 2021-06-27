<?php
session_start();
$userID = $_SESSION['userID'];

$uploadPath = "C:\Server\htdocs\images\profilesPhotos\\$userID.png";

$newName = $_POST['newName'];
$newSurname = $_POST['newSurname'];
$newStatus = $_POST['newStatus'];
$oldPassword = $_POST['oldPassword'];
$newPassword = $_POST['newPassword'];

require_once($_SERVER['DOCUMENT_ROOT']."/php/databaseHandler.php");
$db = new DatabaseHandler();

if ($_FILES["profilePhoto"]['type'] == 'image/png') {
	move_uploaded_file($_FILES['profilePhoto']['tmp_name'], $uploadPath);
	$db->execute("UPDATE Users SET profile_photo = TRUE WHERE user_id = $userID");
}

if (!empty($newName))
	$db->execute("UPDATE Users SET name = '$newName' WHERE user_id = $userID");

if (!empty($newSurname))
	$db->execute("UPDATE Users SET surname = '$newSurname' WHERE user_id = $userID");

if (!empty($newStatus))
	$db->execute("UPDATE Users SET status = '$newStatus' WHERE user_id = $userID");

if (!empty($oldPassword) && !empty($newPassword)) {
	$result = $db->execute("SELECT password FROM Users WHERE user_id = $userID");
	$row = pg_fetch_row($result);
	if (password_verify($oldPassword, $row[0])) {
		$newPassword = password_hash($newPassword, PASSWORD_DEFAULT);
		$db->execute("UPDATE Users SET password = '$newPassword' WHERE user_id = $userID");
	}
}
$db->close();

header("Location: userPage.php?id=myPage&edit=false");
exit;
?>