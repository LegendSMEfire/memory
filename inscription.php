<!DOCTYPE html>

<html>
	<head>
		<link rel="stylesheet" type="text/css" href=""/>
		<title> </title>
	</head>

	<body>
		<header>
			<?php include("header.php");?>
		</header>

		<main>
		
			<form action="" method="post">
				
				<label for="pseudo">Pseudo</label>
				<input type="text" name="pseudo" required/>
				
				<label for="mdp">Mot de passe</label>
				<input type="password" name="mdp" required/>
				
				<label for="mdpV">Vérifier mot de passe</label>
				<input type="password" name="mdpV" required/>
				
				<input type="submit" name="submitBtn" value="Connecter"/>
			
			</form>
			
		</main>

		<footer>
		</footer>
	</body>

</html>



<?php

	
	
?>