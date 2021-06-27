<?php
function getCookie() {
	$cookie = '';
	$length = 10;
	$set = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!?<>$#;:%^&*\|/";
	for($i = 0; $i < $length; $i++) {
		$randInt = rand(0,76); // [0;76]
		$cookie .= $set[$randInt];
	}
	return $cookie;
}
?>