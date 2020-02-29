Hello, I would like to contact you.
Please add me on Steam or Discord
Steam : https://steamcommunity.com/profiles/76561198120166532
Discord : KINGXIII#1121

Bonjour, j'aimerais prendre contact avec toi.
Ajoute moi sur Steam ou Discord s'il te plait.
Steam : https://steamcommunity.com/profiles/76561198120166532
Discord : KINGXIII#1121

<?php

session_start();

if (!isset($_SESSION["user"])) {
	header("Location: wof.php");
	die;
}

if (isset($_SESSION["game"]) && !$_GET["win"]) {
	header("Location: memory.php");
	die;
}

?>

<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Index</title>
	</head>

	<body>
		<header>
			<?php include "includes/header.php"; ?>
		</header>

		<main class="container">
			<?php if (isset($_GET["win"])) {
				unset($_SESSION["game"]); ?>
				<span class="title" style="color: green;">Vous avez gagné !</span>
				<p class="subtitle">Votre partie a été enregistrée.</p>
			<?php } ?>
			<div class="columns">
				<form action="memory.php" method="post" class="play-form">
					<input type="hidden" name="action" value="start">
					<select name="difficulty" class="difficulty">
						<option value="" disabled selected>Sélectionnez un nombre de paires</option>
						<option value="1">3</option>
						<option value="2">6</option>
						<option value="3">9</option>
						<option value="4">12</option>
					</select>

					<input type="submit" value="Jouer" class="play-btn">
				</form>
			</div>
		</main>

		<footer>
		</footer>
	</body>

</html>
