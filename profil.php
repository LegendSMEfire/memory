<?php

include "includes/shortcuts.php";

if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
	header("Location: index.php");
	die;
}

session_start();

$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$success = $stmt->execute([$_GET["id"]]);
$user = $stmt->fetch();

if (!$user) {
	header("Location: index.php");
	die;
}

$url = "profil.php?id={$user['id']}";

$ordering = [
	"time" => "time ASC",
	"attempts" => "attempts ASC",
	"difficulty" => "difficulty DESC"
];

$order = $_GET["order"] ?? "time";

$stmt = $db->prepare("SELECT users.login, users.avatar, id_user, time, attempts, difficulty FROM games
	INNER JOIN users ON users.id = games.id_user
	WHERE games.id_user = ?
	ORDER BY games." . $ordering[$order] ?? $ordering["time"] . "
	LIMIT 10
");
$stmt->execute([$user['id']]);
$leaderboard = $stmt->fetchAll();

function createRank($data, $rank) {
	extract($data); ?>
	<tr class="scored" id="rank-<?= $rank ?>">
		<td><?= $time ?></td>
		<td><?= $attempts ?></td>
		<td><?= $difficulty ?></td>
	</tr>
<?php } ?>

<!DOCTYPE html>

<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="style.css">
		<title>Profil de <?= $user["login"] ?></title>
	</head>

	<body>
		<header>
			<?php include("includes/header.php"); ?>
		</header>

		<main>
			<div class="container">
				<span class="title">Profil de <?= $user["login"] ?></span>

				<div class="columns">
					<div id="avatar-container">
						<img id="avatar-image" src="<?= $user["avatar"] ?>"/>
					</div>
				</div>

				<?php if (($_SESSION["user"]["id"] ?? -1) == $user["id"]) { ?>
					<a class="subtitle" href="editer_profil.php">Modifier votre profil</a>
				<?php } ?>
			</div>

			<table class="leaderboards" id="ez">
				<thead>
					<tr>
						<th><a href="<?= $url ?>&order=time">Temps</a></th>
						<th><a href="<?= $url ?>&order=attempts">Essais</a></th>
						<th><a href="<?= $url ?>&order=difficulty">Difficulté</a></th>
					</tr>
				</thead>
				<tbody>
					<?php
						for ($i = 0; $i < count($leaderboard); $i++) {
							createRank($leaderboard[$i], $i);
						}
					?>
				</tbody>
			</table>
		</main>

		<footer>
		</footer>
	</body>
</html>
