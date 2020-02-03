<nav>
	<a href="index.php" id="header-logo"><img src="assets/logo.png" /></a>
<?php
	if(!isset($_SESSION)) 
	{
		session_start();	
	}
	include("function.php");
	
	if(!isset($_SESSION["id"])){ ?>
		
		<a href="inscription.php" class="header-link">Inscription</a>
		<a href="connexion.php" class="header-link">Connexion</a>
	
	<?php 
	}
	else { ?>
	
		<a href="index.php" class="header-link">Memory</a>
		<a href="profil.php" class="header-link">Profil</a>
		<a href="index.php?deconnexion=true" id="deco-btn" class="header-link">Déconnexion</a>
	
	<?php 
	}

	if(isset($_GET["deconnexion"]))
	{
		session_destroy();
		header("location:index.php");
	}
	
	if(isset($_SESSION["blocked"])) {
		error("Vous etes bloqués pour 60 secondes", true);
		
		if(getdate()[0] - $_SESSION["blocked"] > 60) {
			header("location:index.php");
		}
	}
?>

</nav>