<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<title> </title>
	</head>

	<body>
		<header>
			<?php include("header.php");?>
		</header>

		<main class="inscription-form" id="connexion-main">
		
			<span class="inscription-title">Connection</span>
			<span class="inscription-desc">Grimpez en haut du leaderboard et gagnez les diamants !</span>
		
			<form action="" method="post">
				
				<label for="pseudo">Pseudo</label>
				<input type="text" name="pseudo" required/>
				
				<label for="mdp">Mot de passe</label>
				<input type="password" name="mdp" required/>
				
				<input type="submit" name="submitBtn" value="Connecter" class="play-btn"/>
			
			</form>
			
		</main>

		<footer>
		</footer>
	</body>

</html>



<?php

	if(isset($_POST["submitBtn"])) {
		if(required($_POST))
		{
			$usr = sql_request("SELECT id, psw FROM utilisateurs 
			WHERE pseudo = '".htmlspecialchars($_POST["pseudo"])."'" ,true,true);
			
			if(password_verify($_POST["mdp"], $usr[1]))
			{
				$_SESSION["id"] = $usr[0];
				$_SESSION["pseudo"] = $_POST["pseudo"];
				
				header("location:index.php");
			}
			else
			{
				echo "nope";
			}
		}
	}



?>