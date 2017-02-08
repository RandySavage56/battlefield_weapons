<?php
	
	session_start();
	try{
		$db=new PDO('mysql:host=localhost;dbname=battlefield_weapons','root','');
		$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);//les noms de champs seront en caractères minuscules
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);//les erreurs lanceront des exceptions
		}
	catch(Exception $e){

	echo "Une erreur est survenue";
	die();
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title></title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="styles/design.css">
		<link href="https://fonts.googleapis.com/css?family=Orbitron" rel="stylesheet"> 
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script type="text/javascript" src="include/menu.js"> </script>
	</head>

	<body>
		<div class="container">
		<script type="text/javascript" src="jquery.js"></script>
			<div class="header" class="row">
				<div class="col-md-12">
					<header>
						<h1 class="title"> <img src="https://ajbeamish.files.wordpress.com/2014/04/battlefield-4-logo.png" alt="bf" style="width: 100px; height: auto;"> Battlefield 4 Weapons <img src="https://ajbeamish.files.wordpress.com/2014/04/battlefield-4-logo.png" alt="bf" style="width: 100px; height: auto;"></h1>

						
							<div class="row">
								
								<div class="menu">
								 <a class="col-lg-2 col-xs-12" href="index.php">Accueil</a>
								 <a class="col-lg-2 col-xs-12" href="arsenal.php">Arsenal</a>
								 <a class="col-lg-2 col-xs-12" href="panier.php">Panier</a>

								 <?php ; 
								 if(!isset($_SESSION['user_id']))
								 	{
								 		
								 		?>
								 	
								 	<a class="col-lg-3 col-xs-12" href="register.php">Inscription</a>
									<a class="col-lg-3 col-xs-12" href="connect.php">Connexion</a>

								 <?php }else{?>
								 	<a  class="col-lg-6 col-xs-12" href="my_account.php">Mon compte</a>
								 <?php } ?>
								 </div>
								 <div class="hamburgeroverlay"></div>
							</div>
						
					</header>
				</div>
			</div>

			

	