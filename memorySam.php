<?php
	session_start();
	
	if(isset($_POST["reset"]))
	{
		session_destroy();
		header("location:memorySam.php");
	}
	
	if(isset($_POST["submitBtn"]))
	{
		$_SESSION["difficulty"] = $_POST["difficulty"];
		$_SESSION["deck"] = [];
		$images = scandir("assets/cards");
		
		array_splice($images, 0,2);
		
		for($i=0; $i<$_SESSION["difficulty"]; $i++)
		{
			$content = [$i, $images[$i], "hide"];
			array_push($_SESSION["deck"], $content, $content);
		}
		shuffle($_SESSION["deck"]);
	}
	


	if(isset($_SESSION["difficulty"]))
	{
		for($i=0; $i<$_SESSION["difficulty"]*2; $i++)
		{
			if(isset($_POST[$i]))
			{	
				if(isset($_SESSION["second-move"]))
				{
					if($_SESSION["deck"][$_SESSION["first-move"][1]][2] != "valid")
					{
						$_SESSION["deck"][$_SESSION["first-move"][1]][2] = "hide";								
					}
					if($_SESSION["deck"][$_SESSION["second-move"][1]][2] != "valid")
					{
						$_SESSION["deck"][$_SESSION["second-move"][1]][2] = "hide";								
					}
					
					unset($_SESSION["first-move"]);
					unset($_SESSION["second-move"]);
				}
				
				if(!isset($_SESSION["first-move"]))
				{
					$_SESSION["first-move"] = [$_POST[$i], $i];
					$_SESSION["deck"][$i][2] = "selected";
				}
				else
				{
					if($_SESSION["first-move"][1] != $i)
					{
						if(!isset($_SESSION["second-move"]))
						{
							$_SESSION["second-move"] = [$_POST[$i], $i];
						}
				
						if($_SESSION["first-move"][0] == $_POST[$i])
						{
							$_SESSION["deck"][$_SESSION["first-move"][1]][2] = "valid";
							$_SESSION["deck"][$i][2] = "valid";
						}
						else
						{
							if($_SESSION["deck"][$_SESSION["first-move"][1]][2] != "valid")
							{
								$_SESSION["deck"][$_SESSION["first-move"][1]][2] = "invalid";								
							}
							if($_SESSION["deck"][$_SESSION["second-move"][1]][2] != "valid")
							{
								$_SESSION["deck"][$_SESSION["second-move"][1]][2] = "invalid";								
							}
						}
					}
				}
			}
		}
	}
	
	function select_bg($card)
	{
		if($card[2] == "hide")
		{
			return "url(),url(assets/back.png);";
		}
		else if($card[2] == "valid")
		{
			return " url(assets/cards/$card[1]), url(assets/front.png);";
		}
		else
		{
			if ($card[2] == "selected")
			{
				return "url(assets/cards/$card[1]), url(assets/front_selected.png);";
			}
			else if($card[2] == "invalid")
			{
				return "url(assets/cards/$card[1]), url(assets/front_wrong.png);";
			}
		}
	}
?>



<!DOCTYPE html>

<html lang="en" >
	<head>
		<link rel="stylesheet" type="text/css" href="style.css"/>
		<title>Memory Sam</title>
	</head>

	<body>
		<header>
			<?php include("header.php") ?>
		</header>

		<main>
			<?php if(!isset($_SESSION["deck"])) { ?>
				<form action="" method="post" class="play-form">
					<select name="difficulty" class="difficulty">
						<option value="" disabled selected>Choisissez votre difficulté</option>
						<option value="3">3 paires</option>
						<option value="6">6 paires</option>
						<option value="9">9 paires</option>
						<option value="12">12 paires</option>
					</select>
					<input type="submit" value="Jouer" name="submitBtn" class="play-btn"/>
				</form>
				
				
			<?php } else {
				echo "<form action='memorySam.php' method='post' id='memorySam'>";
					for($i=0; $i<$_SESSION["difficulty"]*2; $i++)
					{
						echo "<input type='submit' class='card'
							  name = '".$i."' 	value = '".$_SESSION["deck"][$i][0]."'
							  style = 'background-image:".select_bg($_SESSION["deck"][$i])."'/>";
					}
					echo "<input type='submit' name='reset' value='Reset'/>";
				echo "</form>";
			}?>
			
		</main>

		<footer>
		</footer>
	</body>

</html>