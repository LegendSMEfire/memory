<?php

function startGame() {
	if (isset($_POST["pairs"]) && is_numeric($_POST["pairs"])) {
		$_SESSION["game"] = [];
		$_SESSION["matching"] = -1;
		$cards = scandir("./assets/cards");
		array_splice($cards, 0, 2);
		for ($i = 0; $i < $_POST["pairs"]; $i++) {
			$randKey = array_rand($cards);
			$randVal = $cards[$randKey];
			$card = [ "image" => $randVal, "flipped" => false ];
			array_push($_SESSION["game"], $card, $card);
			array_splice($cards, $randKey, 1);
		}
		shuffle($_SESSION["game"]);
	}
}

$disabled = false;
function pickCard() {
	global $disabled;

	if (isset($_POST["pickedCard"]) && is_numeric($_POST["pickedCard"]) && isset($_SESSION["game"][$_POST["pickedCard"]])) {
		if ($_SESSION["matching"] < 0) {
			$_SESSION["matching"] = $_POST["pickedCard"];
		} else {
			$matchingCard = &$_SESSION["game"][$_SESSION["matching"]];
			$pickedCard = &$_SESSION["game"][$_POST["pickedCard"]];
			if ($matchingCard["image"] == $pickedCard["image"] && $_SESSION["matching"] != $_POST["pickedCard"]) {
				$matchingCard["flipped"] = true;
				$pickedCard["flipped"] = true;
				$_SESSION["matching"] = -1;
			} else {
				$disabled = true;
				header("Refresh: 1; URL=index.php");
			}
		}
	}
}

function getCardFrontState($id) {
	if ($_SESSION["matching"] == $id) {
		return "front_selected";
	} else {
		if (isset($_POST["pickedCard"]) && $_POST["pickedCard"] == $id && $_SESSION["matching"] != -1) {
			return "front_wrong";
		} else {
			return "front";
		}
	}
}

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

<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="stylesheet.css"/>
		<title>Memory</title>
	</head>

	<body>
		<header>
		</header>

		<main>
			<?php if(!isset($_SESSION["deck"])) { ?>
				<form action="" method="post" class="play-form">
					<select name="difficulty" class="difficulty">
						<option value="" disabled selected>Choisissez votre difficulté</option>
						<option value="3">3 paires</option>
						<option value="6">6 paires</option>
						<option value="9">9 paires</option>
						<option value="12">12 paires</option>
					</select>
					<input type="submit" value="Jouer" name="submitBtn" class="play-btn"/>
				</form>
				
				
			<?php } else { ?>
			<form method="post" class="columns cards">
				<input type="hidden" name="action" value="pick">
				<?php foreach ($_SESSION["game"] ?? [] as $id => $image) {  ?>
					<input type="submit" name="pickedCard" value="<?= $id ?>" class="card" style="background-image: <?= getCardStyle($id) ?>;" <?= $disabled ? "disabled" : "" ?>>
			<?php } }?>
			</form>
		</main>

		<footer>
		</footer>
	</body>

</html>