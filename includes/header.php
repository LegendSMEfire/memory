

<nav>
	<a href="index.php" id="header-logo" class="header-link"><img src="assets/logo.png"/></a>
	<?php if(!isset($_SESSION["user"])) { ?>
		<a href="inscription.php" class="header-link">Inscription</a>
		<a href="connexion.php" class="header-link">Connexion</a>
	<?php } else { ?>
		<a href="editer_profil.php" class="header-link"><?= $_SESSION["user"]["login"] ?></a>
		<a href="deconnexion.php" id="deco-btn" class="header-link">Déconnexion</a>
	<?php } ?>
	<a href="wof.php" id="deco-btn" class="header-link">Leaderboard</a>
</nav>