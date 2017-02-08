<?php

	require_once('include/header.php');
	require_once('include/sidebar.php');
	require_once('include/fonctions_panier.php');
	require_once('include/paypal.php');

	$erreur = false;

	$action = (isset($_POST['action'])?$_POST['action']:(isset($_GET['action'])?$_GET['action']:null));

	if($action !== null){

		if(!in_array($action, array('ajout','suppression','refresh')))

			$erreur = true;

			$l = (isset($_POST['l'])?$_POST['l']:(isset($_GET['l'])?$_GET['l']:null));
			$q = (isset($_POST['q'])?$_POST['q']:(isset($_GET['q'])?$_GET['q']:null));
			$p = (isset($_POST['p'])?$_POST['p']:(isset($_GET['p'])?$_GET['p']:null));

			$l = preg_replace('#\v#', '', $l);

			$p = floatval($p);

			if(is_array($q)){

				$qteProduit = array();

				$i = 0;

				foreach ($q as $contenu){
					
					$qteProduit[$i++] = intval($contenu);
				}

			}else{

				$q = intval($q);
			}
		}
	

	if(!$erreur){

		switch ($action) {
			case 'ajout':
				ajouterArticle($l,$q,$p);
				break;

			case 'suppression':
				supprimerArticle($l);
				break;

			case 'refresh':
				for($i = 0;$i<count($qteProduit);$i++){

					modifierQteArticle($_SESSION['panier']['libelleProduit'][$i], round($qteProduit[$i]));

				}

				break;
			
			default:
				
				break;
		}
	}
	?>

	<form method="post" action="" >
		<table class="cart">
			<tr class="cart_title">
				<td colspan="4"> Votre panier </td>
			</tr>
			<tr class="cart_labels">
				<td> Libellé produit </td>
				<td> Prix unitaire </td>
				<td class="qty"> Quantité </td>
				<td class="tva"> TVA </td>
				<td> Action </td>
			</tr>

			<?php

				if(isset($_GET['deletepanier']) && $_GET['deletepanier'] == true){

					supprimerPanier();
				}

				if(creationPanier()){

				$nbProduits = count($_SESSION['panier']['libelleProduit']);

				if($nbProduits <= 0){

					echo '<p style="color: red;"> Votre panier est vide ! </p>';

				}else{

					$total = montantGlobal();
					$totaltva = montantGlobalTva();
					$shipping = calculFraisPorts();
					$paypal = new Paypal();

					$params = array(

						'RETURNURL' =>'http://localhost/site_ecommerce/process.php',
						'CANCELURL' =>'http://localhost/site_ecommerce/cancel.php',
						'PAYMENTREQUEST_0_AMT' => $totaltva + $shipping,
						'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR',
						'PAYMENTREQUEST_0_SHIPPINGAMT' => $shipping,
						'PAYMENTREQUEST_0_ITEMAMT' => $totaltva
					);

					$response = $paypal->request('SetExpressCheckout', $params);

					if($response){

						$paypal = 'https://sandbox.paypal.com/webscr?cmd=_express-checkout&useraction=commit&token='.$response['TOKEN'].'';

					}else{

						var_dump($response);
						die('Erreur');
						
					}

					for($i = 0; $i<$nbProduits;$i++){

						?>

							<tr>
								
							<td><br><?php echo $_SESSION['panier']['libelleProduit'][$i]; ?></td>
							<td><br><?php echo $_SESSION['panier']['prixProduit'][$i];?></td>
							<td><br><input style="color: black; name="q[]" value="<?php echo $_SESSION['panier']['qteProduit'][$i]; ?>" size="5"></td>
							<td><br><?php echo $_SESSION['panier']['tva']."%";?></td>
							<td><br><a href="panier.php?action=suppression&amp;l=<?php echo rawurlencode($_SESSION['panier']['libelleProduit'][$i])?>"> [X] </a></td>

							</tr>

							<?php
							
						}			
							
							?>

							<tr>
								<td colspan="2"><br>
									<p> Total : <?php echo $total; ?> € </p>
									<p> Total avec TVA : <?php echo $totaltva; ?> € </p>
									<p> Calcul des frais de port : <?php echo $shipping;?> € </p><br><br>
									<?php 
										if(isset($_SESSION['user_id'])){
									?>
											<a href="<?php echo $paypal; ?>">Payer la commande</a><br><br>
									<?php 
										}else{

									?>
										<h4 style="color: red;"> Vous devez d'abord vous identifier pour pouvoir procéder à la commande <br> <a href="connect.php"> Se connecter </a></h4><br>

								</td>
							</tr>

							<tr>
								<td colspan="4">
								<div class="refresh">
									<input type="submit" value="rafraîchir">
									<input type="hidden" name="action" value="refresh">
								</div>
									<a href="?deletepanier=true"> Supprimer le panier </a>
								</td>
							</tr>

						<?php
					}

				}

			}

			?>
		</table>
	</form>

	<?php

	require_once('include/footer.php');
?>