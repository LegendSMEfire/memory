<?php

include "includes/shortcuts.php";

session_start();

$stmt = $db->prepare("SELECT * FROM users");
$success = $stmt->execute();
$users = $stmt->fetchAll();

?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="style.css">
		<title>Communauté</title>
	</head>

	<body>
		<header>
			<?php include("includes/header.php"); ?>
		</header>

		<main>
			<div class="container">
				<span class="title">Communauté</span>

				<div class="columns community">
					<?php foreach ($users as $user) { ?>
						<div class="column">
							<div class="user-card"><a href="profil.php?id=<?= $user['id'] ?>" class="user-link"><img src="<?= $user['avatar'] ?>" class="wof-image"/><span>&nbsp;<?= $user["login"] ?></span></a></div>
						</div>
					<?php } ?>
				</div>
			</div>
		</main>

		<footer>
		</footer>
	</body>
</html>
