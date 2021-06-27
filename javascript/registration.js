function check(form) {
	var userLogin = document.getElementById("loginField").value;
	var userPassword = document.getElementById("passwordField").value;
	var userName = document.getElementById("nameField").value;
	var userSurname = document.getElementById("surnameField").value;
	if (userLogin.length != 0 && userPassword.length != 0 &&
		userName.length != 0 && userSurname.length != 0) form.submit();
}