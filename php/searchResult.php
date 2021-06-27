<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="\css\searchResult.css">
	</head>
	
	<body>
		<div id="searchResult_container">
			<div id="searchResult_labelHeader">Search result</div>
			<div><hr id="searchResult_separator"></div>
			<div id="list">
				<?php
				$search = preg_replace('/\s+/', ' ', $_GET['search']);
				
				require_once($_SERVER['DOCUMENT_ROOT']."/php/databaseHandler.php");
				$db = new DatabaseHandler();
				$result = $db->execute(
					"SELECT user_id, name, surname, last_access_time FROM Users
					WHERE concat(name, ' ', surname) LIKE '$search%' OR
					concat(surname, ' ', name) LIKE '$search%';");
				$db->close();
				$number = 0;
				while ($row = pg_fetch_row($result)): ?>
					<div class="searchResult_listItem">
						<div class="searchResult_leftPanel">
							<?php ++$number; ?>
							<script>
							function openUserPage(id) {
								document.location.href = "/php/userPage.php?id=" + id;
							}
							</script>
							
							<a class="searchResult_link" onclick="openUserPage(<?php echo $row[0]; ?>)"><?php echo $row[1], " ", $row[2] ?></a>
						</div>
						<div class="searchResult_centerPanel">
							<?php
							if (time() - $row[3] <= 120)
								echo "online";
							else
								echo "offline";
							?>
						</div>
					</div>
				<?php endwhile;
				
				if ($number == 0) echo "Nothing found";
				?>
			</div>
		</div>
	</body>
</html>