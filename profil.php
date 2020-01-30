<!DOCTYPE html>

<html lang="en">
	<head>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="ie=edge">
		<title>Index</title>
	</head>

	<body>
		<header>
			<?php 
				include("header.php");
				$usr = sql_request("SELECT * FROM utilisateurs WHERE id = ".$_SESSION["id"], true, true);
			?>
		</header>

		<main>
			
			<form action="" method="post" enctype="multipart/form-data">
				
				<div >
					<div id="profilPic-container" ><img id="profil-image" class="input-zone" src="<?= $usr[3] ?>"/></div>
					<input type="file" name="profilPic" />
				</div>
			
			
				<div class="input-zone">
					<label for="pseudo">Pseudo</label>
					<input type="text" name="pseudo" value="<?= $usr[1] ?>"/>
				</div>
				
				<div class="input-zone">
					<label for="psw">Changer mot de passe</label>
					<input type="password" name="psw" />
				</div>
				
				<input type="submit" name="submitBtn" value="Changer"/>
			</form>
			
		</main>

		<footer>
		</footer>
	</body>

</html>



<?php
	if(isset($_POST["submitBtn"]))
	{
		if(!empty($_POST["pseudo"]) && $usr[1] != $_POST["pseudo"])
		{
			sql_request("UPDATE utilisateurs SET pseudo = '".$_POST["pseudo"]."'
			WHERE id =".$_SESSION["id"]);
		}
		if(!empty($_POST["psw"]) && $_POST["psw"] != $usr[2])
		{
			sql_request("UPDATE utilisateurs SET psw = '".$_POST["psw"]."'
			WHERE id =".$_SESSION["id"]);
		}
		if(!empty($_FILES["profilPic"]["name"]))
		{
			$cur_file = pathinfo($_FILES["profilPic"]["name"]);
			$image_path = "assets/profilPics/".$_SESSION["id"].".".$cur_file["extension"];
			
			foreach(scandir("assets/profilPics/") as $files)
			{
				if(pathinfo($files, PATHINFO_FILENAME) == $_SESSION["id"])
				{
					unlink("assets/profilPics/".pathinfo($files, PATHINFO_BASENAME));
				}
			}
			
			if(!file_exists($image_path))
			{
				move_uploaded_file($_FILES["profilPic"]["tmp_name"] , $image_path);
				sql_request("UPDATE utilisateurs SET profilPic = '".$image_path."'");
			}
		}
		
		header("location:profil.php");
	}


?>