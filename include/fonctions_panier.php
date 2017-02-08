<?php

	function creationPanier(){

		try{
			$db=new PDO('mysql:host=localhost;dbname=battlefield_weapons','root','');
			$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);//les noms de champs seront en caractères minuscules
			$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);//les erreurs lanceront des exceptions
		
		}catch(Exception $e){

			echo "Une erreur est survenue";
			die();
		}
						
		if(!isset($_SESSION['panier'])){

			$_SESSION['panier'] = array();
			$_SESSION['panier']['libelleProduit'] = array();
			$_SESSION['panier']['qteProduit'] = array();
			$_SESSION['panier']['prixProduit'] = array();
			$_SESSION['panier']['verrou'] = false;
			$select = $db->query("SELECT tva FROM weapons");
			$data = $select->fetch(PDO::FETCH_OBJ);
			$_SESSION['panier']['tva'] = $data->tva;

		}
		return true;
	}

	function ajouterArticle($libelleProduit, $qteProduit, $prixProduit){

		if(creationPanier() && !isVerrouille()){

			$position_produit = array_search($libelleProduit, $_SESSION['panier']['libelleProduit']);

			if($position_produit !== false){

				$_SESSION['panier']['qteProduit'][$position_produit] += $qteProduit;

			}else{

				array_push($_SESSION['panier']['libelleProduit'], $libelleProduit);
				array_push($_SESSION['panier']['qteProduit'], $qteProduit);
				array_push($_SESSION['panier']['prixProduit'], $prixProduit);
			}

		}else{

			echo'Erreur, veuillez contacter l\'admin';

		}

	}

	function ModifierQteArticle($libelleProduit, $qteProduit){

		if(creationPanier() && !isVerrouille()){

			if($qteProduit>0){

				$position_produit = array_search($libelleProduit, $_SESSION['panier']['libelleProduit']);

				if($position_produit !== false){

					$_SESSION['panier']['qteProduit'][$position_produit] = $qteProduit;
				}

			}else{

				supprimerProduit($libelleProduit);

			}

		}else{

			echo'Erreur, veuillez contacter l\'admin';

		}

	}

	function supprimerArticle($libelleProduit){

		if(creationPanier() && !isVerrouille()){

			$tmp = array();
			$tmp['libelleProduit'] = array();
			$tmp['qteProduit'] = array();
			$tmp['prixProduit'] = array();
			$tmp['verrou'] = $_SESSION['panier']['verrou'];

			$tmp['tva'] = $_SESSION['panier']['tva'];

			for($i = 0; $i<count($_SESSION['panier']['libelleProduit']); $i++){

				if($_SESSION['panier']['libelleProduit'][$i] !== $libelleProduit){

					array_push($tmp['libelleProduit'], $_SESSION['panier']['libelleProduit'][$i]);
					array_push($tmp['qteProduit'], $_SESSION['panier']['qteProduit'][$i]);
					array_push($tmp['prixProduit'], $_SESSION['panier']['prixProduit'][$i]);

				}
			}

			$_SESSION['panier'] = $tmp;

			unset($tmp);

		}else{

			echo 'Erreur, veuillez contacter l\'admin';

		}
	}	

	function supprimerPanier(){

		if(isset($_SESSION['panier'])){

			unset($_SESSION['panier']);
		}
	}

	function montantGlobal(){

		$total = 0;

		for($i = 0; $i<count($_SESSION['panier']['libelleProduit']); $i++){

			$total += $_SESSION['panier']['qteProduit'][$i]*$_SESSION['panier']['prixProduit'][$i];

		}

		return $total;

	}

	function montantGlobalTva(){

		$total = 0;

		for($i = 0; $i<count($_SESSION['panier']['libelleProduit']); $i++){

			$total += $_SESSION['panier']['qteProduit'][$i]*$_SESSION['panier']['prixProduit'][$i];

		}

		return $total + $total*$_SESSION['panier']['tva']/100;

	}

	function isVerrouille(){

		if(isset($_SESSION['panier']) && $_SESSION['panier']['verrou']){

			return true;

		}else{

			return false;
		}
	}

	function compterArticle(){

		if(isset($_SESSION['panier'])){

			return count($_SESSION['panier']['libelleProduit']);

		}else{

			return 0;
			
		}
	}

	function calculFraisPorts(){

	try{
			$db=new PDO('mysql:host=localhost;dbname=battlefield_weapons','root','');
			$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);//les noms de champs seront en caractères minuscules
			$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);//les erreurs lanceront des exceptions
		
		}catch(Exception $e){

			echo "Une erreur est survenue";
			die();
		}

		$weight_product = "";
		$shipping = "";

		for($i = 0;$i<compterArticle();$i++){

			for($j = 0;$j<$_SESSION['panier']['qteProduit'][$i]; $j++){

				$name = $_SESSION['panier']['libelleProduit'][$i];
				$select = $db->query("SELECT weight FROM weapons WHERE name = '$name'");
				$result = $select->fetch(PDO::FETCH_OBJ);
				$weight = $result->weight;

				$weight_product += $weight;

				}
			}

		$select = $db->query("SELECT*FROM weight WHERE name >= '$weight_product'");
		$result2 = $select->fetch(PDO::FETCH_OBJ);
	
		$shipping = $result2->price;

		return $shipping;
	}



?>