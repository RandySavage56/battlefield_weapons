<?php

	require_once('include/header.php');
	require_once('include/sidebar.php');
	//var_dump($_SESSION['user_id']);

	if(!isset($_SESSION['user_id'])){

		if(isset($_POST['submit'])){

			$password = $_POST['password'];
			$email = $_POST['email'];

			if($email&&$password){

				$select = $db->query("SELECT id FROM users WHERE email = '$email' AND password = '$password'");

				if($select->fetchColumn()){

					$select = $db->query("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
					$result = $select->fetch(PDO::FETCH_OBJ);
					$_SESSION['user_name'] = $result->username;
					$_SESSION['user_id'] = $result->id;	
					$_SESSION['user_email'] = $result->email;
					$_SESSION['user_password'] = $result->password;

					header('Location: my_account.php');

				}else{

					echo '<h4 style="color: red;"> Adresse mail et/ou mot de passe invalide ! </h4>';
				}

			}else{

				echo '<h4 style="color: red;"> Veuillez remplir tous les champs ! </h4>';

			}
	}
?>

<div class="login">
<h1> LOGIN </h1><br>

<form action="" method="POST">
	<label>Votre e-mail : </label><input style="color: black; type="email" name="email"><br><br>
	<label>Votre mot de passe : </label><input style="color: black; type="password" name="password"><br><br>
</div>
	<input type="submit" name="submit">
</form>

<a href="register.php"> Créer un compte </a>

<?php

	}else{

		header('Location: my_account.php');
	}

	require_once('include/footer.php');

?>