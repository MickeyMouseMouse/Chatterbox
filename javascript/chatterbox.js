function find() {
	var search = document.getElementById("searchField").value;
	search = search.replace(/\s+/g, ' ').trim();
	if (search.length != 0) {
		document.getElementById("chatterbox_bottomRightPanel").src = "/php/searchResult.php?search=" + search;
	}
}

function logout() {
	document.location.href = "../php/logout.php";
}

function openUserPage(id) {
	document.getElementById("chatterbox_bottomRightPanel").src = "/php/userPage.php?id=" + id;
}

function messenger() {
	document.getElementById("chatterbox_bottomRightPanel").src = "/php/conversationList.php";
}