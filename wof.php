<?php
	
	if(!isset($_GET["order"]))
	{
		$_GET["order"] = "time ASC";
	}
	
	$pdo = new PDO("mysql:host=localhost;dbname=memory","root","");
	$leaderboard = $pdo->query("SELECT users.login, users.avatar, time, attempts, difficulty FROM games
	INNER JOIN users ON users.id = games.id_user 
	ORDER BY games.".htmlspecialchars($_GET["order"]))->fetchAll(PDO::FETCH_ASSOC);
	
	function create_rank($login, $avatar, $time, $attempts, $difficulty, $rank){
		switch ($rank) 
		{
			case 0:
				$rank="first";
				break;
			
			case 1:
				$rank="second";
				break;
				
			case 2:
				$rank="third";
				break;
			
			default:
				$rank="";
				break;
		}
?>
		<tr class="scored" id="<?=$rank?>">
			<td class="pseudo-wof"><?=$login?><img src="<?=$avatar?>" class="wof-image"/></td>
			<td><?=$time?></td>
			<td><?=$attempts?></td>
			<td><?=$difficulty?></td>
		<tr>
<?php
	}
?>


<!DOCTYPE html>

<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<link rel="stylesheet" href="style.css">
		<title>Wall Of sh/fame</title>
	</head>

	<body>
		<header>
			<?php include("includes/header.php"); ?>
		</header>

		<main>
			<table class="leaderboards" id="ez">
				
				<tr>
					<th>Pseudo</th>
					<th><a href="wof.php?order=time%20ASC">Time</a></th>
					<th><a href="wof.php?order=attempts%20ASC">Attempt</a></th>
					<th><a href="wof.php?order=difficulty%20DESC">Difficulty</a></th>
				</tr>
				
				<?php 
					$count = 0;
					foreach($leaderboard as $score)
					{
						create_rank($score["login"], $score["avatar"],  $score["time"], $score["attempts"], $score["difficulty"], $count);
						$count++;
					}
				?>
				
			</table>
		</main>

		<footer>
		</footer>
	</body>

</html>