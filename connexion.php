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
				
				<input type="submit" name="submitBtn" value="Connecter"/>
			
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
			$usr = sql_request("SELECT id, psw FROM utilisateurs WHERE pseudo = '".$_POST["pseudo"]."'",
			true,true);
			var_dump($usr);
			
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