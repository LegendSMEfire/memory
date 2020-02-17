<?php

session_start();

if (isset($_SESSION["user"])) {
	header("Location: index.php");
	die;
}

include "includes/shortcuts.php";

$messages = [];

if(count($_POST) > 0) {
	if(!in_array("", $_POST)) {
		$stmt = $db->prepare("SELECT * FROM users WHERE login = ?");
		$stmt->execute([$_POST["login"]]);
		$user = $stmt->fetch();
		if (!$user) {
			if ($_POST["password"] == $_POST["passwordVerify"]) {
				$hash = password_hash($_POST["password"], PASSWORD_BCRYPT);
				$avatar = "assets/avatars/default/{$_POST['avatar']}";
				$path = realpath($avatar);

				// On regarde si l'utilisateur essaie de s'échapper de notre dossier
				if ($path && !preg_match("/assets(\\|\/)avatars(\\|\/)default(\\|\/)/i", $path)) {
					$stmt = $db->prepare("INSERT INTO users(`login`, `password`, `avatar`)
					VALUES (?, ?, ?)");
					$stmt->execute([
						$_POST["login"],
						$hash,
						$avatar
					]);

					header("Location: connexion.php");
					die;
				} else {
					array_push($messages, "Qu'est-ce que vous essayez de faire ?");
				}
			} else {
				array_push($messages, "Vous n'avez pas confirmé votre mot de passe correctement");
			}
		} else {
			array_push($messages, "Il y a déjà un utilisateur avec ce login !");
		}
	}
}

?>

<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Inscription</title>
	</head>

	<body>
		<header>
			<?php include "includes/header.php"; ?>
		</header>

		<main class="container">
			<span class="title">Créez votre compte</span>
			<span class="subtitle">Préparez vous pour le meilleur DLC de Minecraft !</span>
			<?php foreach ($messages as $message) { ?>
				<span class="subtitle"><?= $message ?></span>
			<?php } ?>

			<form id="narrow-form" method="post">
				<label for="login">Login</label>
				<input type="text" name="login" required maxlength="50" value="<?= $_POST['login'] ?? "" ?>"/>

				<label for="password">Mot de passe</label>
				<input type="password" name="password" required maxlength="255"/>

				<label for="passwordVerify">Mot de passe (confirmation)</label>
				<input type="password" name="passwordVerify" required maxlength="255"/>

				<div id="inscription-avatar">
					<?php
					$avatars = scandir("./assets/avatars/default");
					array_splice($avatars, 0, 2);
					foreach ($avatars as $k => $v) { ?>
						<span>
							<input type="radio" id="avatar-<?= $k ?>" name="avatar" value="<?= $v ?>" class="radio-picture" required/>
							<label for="avatar-<?= $k ?>">
								<img src="assets/avatars/default/<?= $v ?>" class="inscription-avatar-image"/>
							</label>
						</span>
					<?php } ?>
				</div>

				<input type="submit" value="S'inscrire" class="play-btn"/>
			</form>
		</main>
	</body>
</html>
