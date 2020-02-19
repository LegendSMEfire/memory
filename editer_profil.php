<?php

session_start();

if (!isset($_SESSION["user"])) {
	header("Location: index.php");
	die;
}

include "includes/shortcuts.php";

$user = &$_SESSION["user"];

$messages = [];

if (isset($_SERVER["CONTENT_LENGTH"]) && $_SERVER["CONTENT_LENGTH"] && !$_FILES && !$_POST) {
	array_push($messages, "Votre avatar est trop large !");
}

if(count($_POST) > 0 || count($_FILES) > 0) {
	if (!empty($_POST["login"]) && $_POST["login"] != $user["login"]) {
		$stmt = $db->prepare("SELECT * FROM users WHERE login = ?");
		$login = htmlentities($_POST["login"]);
		$stmt->execute([$login]);
		$existingUser = $stmt->fetch();
		if (!$existingUser) {
			$stmt = $db->prepare("UPDATE users SET login = ? WHERE id = ?");
			if ($stmt->execute([
				$login,
				$user["id"],
			])) {
				array_push($messages, "Login mis à jour avec succès");
			} else {
				array_push($messages, "Erreur de mise à jour du login");
			}
		} else {
			array_push($messages, "Il y a déjà un utilisateur avec ce login !");
		}
	}

	if (!empty($_POST["password"])) {
		if ($_POST["password"] == $_POST["passwordVerify"]) {
			$hash = password_hash($_POST["password"], PASSWORD_BCRYPT);
			$stmt = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
			if ($stmt->execute([
				$hash,
				$user["id"]
			])) {
				array_push($messages, "Mot de passe mis à jour avec succès");
			}
		} else {
			array_push($messages, "Vous n'avez pas confirmé votre nouveau mot de passe correctement");
		}
	}

	if(!empty($_FILES["avatar"]["name"])) {
		try {
			$cur_file = pathinfo($_FILES["avatar"]["name"]);
			$image_path = "assets/avatars/user/{$user['id']}.{$cur_file['extension']}";

			if (!preg_match("/^assets\/avatars\/default\//i", $user["avatar"])) {
				unlink($user["avatar"]);
			}
			if (file_exists($image_path)) {
				unlink($image_path);
			}

			move_uploaded_file($_FILES["avatar"]["tmp_name"], $image_path);

			$stmt = $db->prepare("UPDATE users SET avatar = ? WHERE id = ?");
			if ($stmt->execute([
				$image_path,
				$user["id"],
			])) {
				array_push($messages, "Avatar mis à jour avec succès");
			} else {
				array_push($messages, "Erreur de mise à jour d'avatar");
			}
		} catch (Exception $e) {
			var_dump($e);
			array_push($messages, $e->getMessage());
		}
	}

	$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
	$stmt->execute([$user["id"]]);
	$user = $stmt->fetch();
}

?>

<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Modification profil</title>
	</head>

	<body>
		<header>
			<?php include "includes/header.php"; ?>
		</header>

		<main class="container">
			<span class="title">Modifiez votre profil</span>
			<?php foreach ($messages as $message) { ?>
				<span class="subtitle"><?= $message ?></span>
			<?php } ?>

			<form id="narrow-form" method="post" enctype="multipart/form-data">
				<label for="avatar">Avatar (2 Mo max)</label>
				<div class="columns">
					<div id="avatar-container">
						<img id="avatar-image" src="<?= $user["avatar"] ?>"/>
					</div>
					<input type="file" name="avatar"/>
				</div>

				<label for="login">Login</label>
				<input type="text" name="login" value="<?= htmlentities($user["login"]) ?>" maxlength="50"/>

				<label for="password">Mot de passe</label>
				<input type="password" name="password" maxlength="255"/>

				<label for="passwordVerify">Mot de passe (confirmation)</label>
				<input type="password" name="passwordVerify" maxlength="255"/>

				<input type="submit" value="Changer" class="play-btn"/>
			</form>
		</main>

		<footer>
		</footer>
	</body>
</html>
