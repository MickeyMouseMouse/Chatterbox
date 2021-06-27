function check(form) {
	var userLogin = document.getElementById("loginField").value;
	var userPassword = document.getElementById("passwordField").value;
	if (userLogin.length != 0 && userPassword.length != 0) form.submit();
}