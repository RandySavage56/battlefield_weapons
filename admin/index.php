<?php
	session_start();
	$user = "randy56";
	$password_admin= "cethole56";

	if(isset($_POST["Valider"])){

		$username = $_POST['username'];
		$password = $_POST['password'];

		if($username && $password){
			if ($username == $user && $password == $password_admin) {
				
				$_SESSION['username'] = $username;
				header('Location: admin.php');
			}else{

			echo "Votre username et/ou mot de passe sont invalides";
			}
		}else{
			echo "Veuillez remplir tous les champs";
		}
	}
?>

<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="styles/design.css">

<h1> Administration - Connexion </h1>
<form action="" method="POST">
	<label> Nom d'utilisateur </label><input type="text" name="username">
	<label> Mot de passe </label><input type="password" name="password">
	<input type="submit" name="Valider">
</form>