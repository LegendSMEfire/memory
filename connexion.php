
<?php

session_start();

if (isset($_SESSION["user"])) {
	header("Location: index.php");
	die;
}

include "includes/shortcuts.php";

$messages = [];

if (count($_POST) > 0 && !in_array("", $_POST)) {
	$stmt = $db->prepare("SELECT * FROM users WHERE login = ?");
	$login = htmlentities($_POST["login"]);
	$stmt->execute([$login]);
	$user = $stmt->fetch();

	if ($user && password_verify($_POST["password"], $user["password"])) {
		$_SESSION["user"] = $user;

		header("Location: index.php");
		die;
	} else {
		array_push($messages, "Mot de passe incorrect");
	}
}

?>

<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<title> </title>
	</head>

	<body>
		<header>
			<?php include "includes/header.php"; ?>
		</header>

		<main class="container">
			<span class="title">Connexion</span>
			<span class="subtitle">Grimpez en haut du leaderboard et gagnez les diamants !</span>
			<?php foreach ($messages as $message) { ?>
				<span class="subtitle"><?= $message ?></span>
			<?php } ?>

			<form id="narrow-form" method="post">
				<label for="login">Login</label>
				<input type="text" name="login" maxlength="50" required value="<?= htmlentities($_POST['login'] ?? '') ?>"/>

				<label for="password">Mot de passe</label>
				<input type="password" name="password" maxlength="255" required/>

				<input type="submit" value="Envoyer" class="play-btn"/>
			</form>
		</main>

		<footer>
		</footer>
	</body>
</html>
