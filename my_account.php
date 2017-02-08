<?php

	require_once('include/header.php');
	require_once('include/sidebar.php');
	

	?>
	<div class="account">
		<h1> Mon compte </h1>
		<h2>Mes informations personnelles</h2>


	<?php

	$user_id = $_SESSION['user_id'];
	$select = $db->query("SELECT * FROM users WHERE id = '$user_id'");

	while($s = $select->fetch(PDO::FETCH_OBJ)){

		?>

			<h4> Pseudo : <?php echo $s->username; ?></h4>
			<h4> Mail : <?php echo $s->email; ?></h4>
			<h4> Mot de passe : <?php echo $s->password; ?></h4>

		<?php
	}
?>

	<h2> Mes transactions </h2>
<?php

	$select = $db->query("SELECT * FROM transaction WHERE user_id = '$user_id'");

	while($s = $select->fetch(PDO::FETCH_OBJ)){

		$transaction_id = $s->transaction_id;
		$select2 = $db->query("SELECT * FROM products_transactions WHERE transaction_id ='$transaction_id'");

		?>
		<h4> Nom et prénom : <?php echo $s->name; ?></h4>
		<h4> Adresse: <?php echo $s->street; ?></h4>
		<h4> Ville : <?php echo $s->city; ?></h4>
		<h4> Pays : <?php echo $s->country; ?></h4>
		<h4> Date de la transaction : <?php echo $s->date; ?></h4>
		<h4> ID de la transaction : <?php echo $s->transaction_id; ?></h4>
		<h4> Prix total : <?php echo $s->amount; ?></h4>
		<h4> Frais de port : <?php echo $s->shipping; ?></h4>
		<h4> Produits : </h4>
		<?php while($r = $select2->fetch(PDO::FETCH_OBJ)){?>
			<h5> Nom : <?php echo $r->products; ?></h5>
			<h5> Quantité : <?php echo $r->quantity; ?></h5>
		<?php } ?>
		<h4> Devise : <?php echo $s->currency_code; ?></h4><br>
		</div>
		<?php
	}
?>
	<a href="disconnect.php"> Se déconnecter </a>

<?php
	require_once('include/footer.php');
?>