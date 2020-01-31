<!DOCTYPE html>

<html lang="en">
	<head>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Inscription</title>
	</head>

	<body>
		<header>
			<?php include("header.php");?>
		</header>

		<main class="inscription-form">
		
			<span class="inscription-title">Créez votre compte</span>
			<span class="inscription-desc">Préparez vous pour le meilleur DLC de minecraft !</span>
			
			<form action="" method="post" >
				
				<label for="pseudo">Pseudo</label>
				<input type="text" name="pseudo" required/>
				
				<label for="mdp">Mot de passe</label>
				<input type="password" name="mdp" required/>
				
				<label for="mdpV">Vérifier mot de passe</label>
				<input type="password" name="mdpV" required/>
				
				<div id="inscription-profilPic">
					<span>
						<input type="radio" name="profil" value="profil1" id="profil1" class="radio-picture"/>
						<label for="profil1">
							<img src="assets/profilPics/profil1.png" class="inscription-profil-image"/>
						</label>
					</span>
					
					<span>
						<input type="radio" name="profil" value="profil2" id="profil2" class="radio-picture"/>
						<label for="profil2">
							<img src="assets/profilPics/profil2.png" class="inscription-profil-image"/>
						</label>
					</span>
					
					<span>
						<input type="radio" name="profil" value="profil3" id="profil3" class="radio-picture"/>
						<label for="profil3">
							<img src="assets/profilPics/profil3.png" class="inscription-profil-image"/>
						</label>
					</span>
					
					<span>
						<input type="radio" name="profil" value="profil4" id="profil4" class="radio-picture"/>
						<label for="profil4">
							<img src="assets/profilPics/profil4.png" class="inscription-profil-image"/>
						</label>
					</span>
					
					<span>
						<input type="radio" name="profil" value="profil5" id="profil5" class="radio-picture"/>
						<label for="profil5">
							<img src="assets/profilPics/profil5.png" class="inscription-profil-image"/>
						</label>
					</span>
					
					<span>
						<input type="radio" name="profil" value="profil6" id="profil6" class="radio-picture"/>
						<label for="profil6">
							<img src="assets/profilPics/profil6.png" class="inscription-profil-image"/>
						</label>
					</span>
					
					<span>
						<input type="radio" name="profil" value="profil7" id="profil7" class="radio-picture"/>
						<label for="profil7">
							<img src="assets/profilPics/profil7.png" class="inscription-profil-image"/>
						</label>
					</span>
					
					<span>
						<input type="radio" name="profil" value="profil8" id="profil8" class="radio-picture"/>
						<label for="profil8">
							<img src="assets/profilPics/profil8.png" class="inscription-profil-image"/>
						</label>
					</span>
				</div>
				
				<input type="submit" name="submitBtn" value="Connecter" class="play-btn"/>
			
				<span id="term">
					En soumettant ce formulaire, vous acceptez <span class="green">les termes et conditions</span>,
					y compris notre <span class="green">politique de confidentialité</span> et le <span class="green">contrat de licence de l'utilisateur final de Minecraft</span>.
				</span>
			</form>
			
			
		</main>

		<footer>
		</footer>
	</body>

</html>


<?php

	if(isset($_POST["submitBtn"]))
	{
		if(required($_POST))
		{
			if(empty(sql_request("SELECT pseudo FROM utilisateurs WHERE pseudo = '".htmlspecialchars($_POST["pseudo"])."'", true)))
			{
				if($_POST["mdp"] == $_POST["mdpV"])
				{
					$psw = password_hash(htmlspecialchars($_POST["mdp"]), PASSWORD_BCRYPT);
					sql_request("INSERT INTO utilisateurs(`id`,`pseudo`,`psw`,`profilPic`)
					VALUES (NULL, '".$_POST["pseudo"]."', '".$psw."', 'assets/profilPics/".$_POST["profil"].".png')");
					header("location:connexion.php");
				}
			}
		}
	}
	
?>