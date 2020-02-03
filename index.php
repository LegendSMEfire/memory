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
			<?php include("header.php");?>
		</header>

		<main>
			<?php if(isset($_SESSION["id"]) && !isset($_SESSION["game"])) 
			{ 
?>				<div class="columns">
					<form method="post" class="play-form">
						<input type="hidden" name="action" value="start">
						<select name="pairs" class="difficulty">
							<option value="" disabled selected>Sélectionnez un nombre de paires</option>
							<option value="3">3</option>
							<option value="6">6</option>
							<option value="9">9</option>
							<option value="12">12</option>
						</select>
						
						<input type="submit" value="Jouer" class="play-btn">
					</form>
				</div>
<?php						
			}
			
			if(isset($_SESSION["game"]) && isset($_SESSION["id"])){
				
				include("memory.php"); 
			}
			
			
			?>
		</main>

		<footer>
		</footer>
	</body>

</html>