<nav>

<?php
	session_start();
	include("function.php");
	
	if(!isset($_SESSION["id"])){ ?>
		
		<a href="inscription.php">Inscription</a>
		<a href="connexion.php">Connexion</a>
	
	<?php 
	}
	else { ?>
	
		<a href="memory.php">Memory</a>
		<a href="index.php?deconnexion=true">Déconnexion</a>
	
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