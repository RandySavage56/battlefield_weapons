<?php

	require_once('include/header.php');
	require_once('include/sidebar.php');

	if(!isset($_SESSION['user_id'])){

		if(isset($_POST['submit'])){

			$username = $_POST['username'];
			$password = $_POST['password'];
			$email = $_POST['email'];
			$repeatpassword = $_POST['repeatpassword'];

			if($username&&$email&&$password&&$repeatpassword){

				if($password == $repeatpassword){

					$db->query("INSERT INTO users VALUES('','$username','$email','$password')");

					echo '<h4 style="color: green;"> Compte créé ! Vous pouvez à présent vous <a href="connect.php"> connecter </a> au site. </h4>';

				}else{

					echo '<h4 style="color: red;"> Les mots de passe ne correspondent pas ! </h4>';

				}


			}else{

				echo '<h4 style="color: red;"> Veuillez remplir tous les champs ! </h4>';

			}
		}
?>

<div class="register">
<h1> FORMULAIRE D'INSCRIPTION</h1><br>

<form action="" method="post">
	<label>Votre nom d'utilisateur : </label><input style="color: black;" type="text" name="username"><br><br>
	<label>Votre e-mail : </label><input style="color: black; type="email" name="email"><br><br>
	<label>Votre mot de passe : </label><input style="color: black; type="password" name="password"><br><br>
	<label>Confirmer votre mot de pase : </label><input style="color: black; type="password" name="repeatpassword"><br><br>
</div>
	<input type="submit" name="submit">
</form>


<a href="connect.php"> Se connecter à un compte déjà existant </a>

<?php

	}else{

		header('Location: my_account.php');
	}

	require_once('include/footer.php');

?>