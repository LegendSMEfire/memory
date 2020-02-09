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
					<th><a href="wof.php?order=score">Score</a></th> 
					<th><a href="wof.php?order=time">Time</a></th>
					<th><a href="wof.php?order=try">Attempt</a></th>
					<th><a href="wof.php?order=rank">Rank</a></th>
				</tr>
				
				<tr class="scored" id="first">
					<td class="pseudo-wof">Azefortwo<img src="assets/avatars/default/1.png" class="wof-image"/></td>
					<td>150</td>
					<td>00:00:26</td>
					<td>15</td>
					<td>1</td>
				<tr>
				
				<tr class="scored" id="second">
					<td class="pseudo-wof">Tulthul<img src="assets/avatars/default/3.png" class="wof-image"/></td>
					<td>175</td>
					<td>00:00:14</td>
					<td>23</td>
					<td>2</td>
				<tr>
				
				<tr class="scored" id="third">
					<td class="pseudo-wof">Om3ga3<img src="assets/avatars/default/7.png" class="wof-image"/></td>
					<td>115</td>
					<td>00:00:18</td>
					<td>15</td>
					<td>3</td>
				<tr>
				
			</table>
		</main>

		<footer>
		</footer>
	</body>

</html>