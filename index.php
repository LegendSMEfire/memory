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
			<?php if(isset($_SESSION["id"])) { include("memory.php"); }?>
		</main>

		<footer>
		</footer>
	</body>

</html>



<?php





?>