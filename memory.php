<?php

session_start();

if (!isset($_SESSION["user"])) {
	header("Location: index.php");
	die;
}

include "includes/shortcuts.php";

$user = &$_SESSION["user"];

function startGame() {
	if (isset($_POST["difficulty"]) && is_numeric($_POST["difficulty"])) {
		$_SESSION["game"] = [
			"cards" => [],
			"startTime" => microtime(true),
			"lastTry" => time(),
			"matching" => -1,
			"attempts" => 0,
			"difficulty" => $_POST["difficulty"]
		];
		$game = &$_SESSION["game"];

		$cards = scandir("./assets/cards");
		array_splice($cards, 0, 2);

		for ($i = 0; $i < $_POST["difficulty"] * 3; $i++) {
			$randKey = array_rand($cards);
			$randVal = $cards[$randKey];
			$card = [ "image" => $randVal, "flipped" => false ];
			array_push($game["cards"], $card, $card);
			array_splice($cards, $randKey, 1);
		}
		shuffle($game["cards"]);
	}
}
function pickCard() {
	$game = &$_SESSION["game"];

	if (isset($_POST["pickedCard"]) && is_numeric($_POST["pickedCard"]) && isset($game["cards"][$_POST["pickedCard"]])) {
		$game["lastTry"] = time();
		if ($game["matching"] < 0 || isset($game["resetMatching"])) {
			$game["matching"] = $_POST["pickedCard"];
			unset($game["resetMatching"]);
		} else {
			$game["attempts"]++;

			$matchingCard = &$game["cards"][$game["matching"]];
			$pickedCard = &$game["cards"][$_POST["pickedCard"]];

			if ($matchingCard["image"] == $pickedCard["image"] && $game["matching"] != $_POST["pickedCard"]) {
				$matchingCard["flipped"] = true;
				$pickedCard["flipped"] = true;
				$game["matching"] = -1;
			} else {
				$game["resetMatching"] = true;
			}
		}
	}
}
function endGame() {
	unset($_SESSION["game"]);
}
$disabled = false;
function finishGame() {
	global $disabled;
	global $db;
	global $user;
	$game = &$_SESSION["game"];

	if (!isset($game["finished"])) {
		$time = microtime(true) - $game["startTime"];

		$stmt = $db->prepare("INSERT INTO games(`id_user`, `time`, `attempts`, `difficulty`)
		VALUES (?, ?, ?, ?)");
		$stmt->execute([
			$user["id"],
			$time,
			$game["attempts"],
			$game["difficulty"]
		]);
	}

	header("Refresh: " . (isset($game["finished"]) ? "0" : "1.5") . "; URL=index.php?win=1");
	$game["finished"] = true;
	$disabled = true;
}

function getCardFrontState($id) {
	$game = &$_SESSION["game"];
	if ($game["matching"] == $id) {
		return "front-selected";
	} else {
		if (isset($_POST["pickedCard"]) && $_POST["pickedCard"] == $id && $game["matching"] != -1) {
			return "front-wrong";
		} else {
			return "front";
		}
	}
}
function getCardStyle($id) {
	$game = &$_SESSION["game"];

	if (isset($game) && isset($game["cards"][$id])) {
		if ((isset($_POST["pickedCard"]) && $_POST["pickedCard"] == $id) ||
			$game["matching"] == $id ||
			$game["cards"][$id]["flipped"]) {
			return "url(assets/cards/{$game['cards'][$id]['image']}), url(assets/" . getCardFrontState($id) . ".png)";
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
		case "end":
			endGame();
			break;
	}
} else {
	$_SESSION["game"]["matching"] = -1;
}

$remainingTime = time() - ($_SESSION["game"]["lastTry"] ?? time());
if ($remainingTime > 60 * 10) {
	endGame();
}

if (!isset($_SESSION["game"])) {
	header("Location: index.php");
	die;
} elseif (count($_SESSION["game"]["cards"] ?? []) > 0) {
	$done = true;
	foreach ($_SESSION["game"]["cards"] as $card) {
		if (!$card["flipped"]) {
			$done = false;
			break;
		}
	}
	if ($done) {
		finishGame();
	}
}

?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="style.css">
		<title>Memory</title>
	</head>
	<body>
		<header>
			<?php include "includes/header.php"; ?>
		</header>
		<main class="container">
			<form method="post" class="columns cards">
				<input type="hidden" name="action" value="pick">
				<?php foreach ($_SESSION["game"]["cards"] ?? [] as $id => $image) { ?>
					<input type="submit" name="pickedCard" value="<?= $id ?>" class="card" style="background-image: <?= getCardStyle($id) ?>;" <?= $disabled ? "disabled" : "" ?>>
				<?php } ?>
			</form>
			<form method="post" class="play-form">
				<input type="hidden" name="action" value="end">
				<input type="submit" value="Abandonner" class="play-btn"/>
			</form>
		</main>
	</body>
</html>

