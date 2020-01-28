<?php

session_start();

/*
		&& $_POST["pickedCard"] == $id && $_SESSION["matching"] != -1) {
			return "front_wrong";
		} else {
			return "front";
		}
	}
}
*/
function getCardStyle($id) {
	if (isset($_SESSION["game"]) && isset($_SESSION["game"][$id])) {
		if ((isset($_POST["pickedCard"]) && $_POST["pickedCard"] == $id) ||
			$_SESSION["matching"] == $id ||
			$_SESSION["game"][$id]["flipped"]) {
			return "url(assets/cards/{$_SESSION['game'][$id]['image']}), url(assets/" . getCardFrontState($id) . ".png)";
		} else {
			return "linear-gradient(0, transparent, transparent), url(assets/back.png)";
		}
	}
}

if (count($_POST) > 0) {
	switch ($_POST["action"]) {
		case "start":
			startGame();
			break;
		case "pick":
			pickCard();
			break;
	}
} else {
	$_SESSION["matching"] = -1;
}

?>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="style.css">
	<title>Memory</title>
</head>
<body>
<main>
	<form method="post" class="columns cards">
		<input type="hidden" name="action" value="pick">
		<?php foreach ($_SESSION["game"] ?? [] as $id => $image) { ?>
			<input type="submit" name="pickedCard" value="<?= $id ?>" class="card" style="background-image: <?= getCardStyle($id) ?>;" <?= $disabled ? "disabled" : "" ?>>
		<?php } ?>
	</form>

	<div class="columns">
		<form method="post">
			<input type="hidden" name="action" value="start">
			<select name="pairs">
	            <option value="" disabled selected>Sélectionnez un nombre de paires</option>
				<option value="3">3</option>
				<option value="6">6</option>
				<option value="9">9</option>
				<option value="12">12</option>
			</select>
			<input type="submit" value="Jouer">
		</form>
	</div>
</main>
</body>
</html>

