<?php
	session_start();

	?>

		<h1>Tableau de bord</h1>
		<h5> Connecté en tant que : 
		<?php echo($_SESSION['username']); ?>
		</h5>
		<br/>

		<a href="?action=add">Ajouter une arme</a><br><br>
		<a href="?action=modifyanddelete">Modifier / Supprimer une arme</a><br/><br/>

		<a href="?action=add_category">Ajouter une catégorie</a><br/><br/>
		<a href="?action=modifyanddelete_category">Modifier / Supprimer une catégorie</a><br/><br/>

		<a href="?action=options">Options</a><br/><br/>

	<?php

	try{
		$db=new PDO('mysql:host=localhost;dbname=battlefield_weapons','root','');
		$db->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);//les noms de champs seront en caractères minuscules
		$db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);//les erreurs lanceront des exceptions
	}
	catch(Exception $e){

	echo "Une erreur est survenue";
	die();
	}

	if(isset($_SESSION['username'])){

		if(isset($_GET['action'])){
			
			if($_GET['action']=='add'){

				if(isset($_POST['Valider'])){

					$stock = $_POST['stock'];
					$name=$_POST['name'];
					$description=$_POST['description'];
					$price=$_POST['price'];

					$img = $_FILES['img']['name'];
					$img_tmp = $_FILES['img']['tmp_name'];

					if(!empty($img_tmp)){

						$image = explode('.', $img);

						$image_ext = end($image);

						if(in_array(strtolower($image_ext), array('png','jpg','jpeg')) === false){

							echo "Veuillez rentrer une image au format : jpg, jpeg ou png";

						}else{

							$image_size = getimagesize($img_tmp);

							if($image_size['mime'] == 'image/jpeg'){

								$image_src = imagecreatefromjpeg($img_tmp);
							
							}else if($image_size['mime'] == 'image/png'){

								$image_src = imagecreatefrompng($img_tmp);
							
							}else{

								$image_src = false;
								echo "Veuillez rentrer une image valide";
							}

							if($image_src != false){

								$image_width = 200;

								if($image_size[0] == $image_width){

									$image_finale = $image_src;
								}else{

									$new_width[0] = $image_width;
									$new_height[1] = 200;
									$image_finale = imagecreatetruecolor($new_width[0], $new_height[1]);

									imagecopyresampled($image_finale, $image_src, 0, 0, 0, 0, $new_width[0], $new_height[1], $image_size[0], $image_size[1]);
								}

								imagejpeg($image_finale, 'imgs/'.$name.'.jpg');
							}
						}

					}else{

						echo "Veuillez rentrer une image";
					}

					if($name&&$description&&$price&&$stock){

						$categorie = $_POST['categorie'];
						$weight = $_POST['weight'];

						$select = $db->query("SELECT price FROM weight WHERE name = '$weight'");

						$s = $select->fetch(PDO::FETCH_OBJ);

						$shipping = $s->price;

						$old_price = $price;

						$price_with_shipping = $old_price + $shipping;

						$select = $db->query("SELECT TVA FROM weapons");

						$s1 = $select->fetch(PDO::FETCH_OBJ);

						$tva = $s1->tva;

						$final_price = $price_with_shipping + ($price_with_shipping*$tva/100);

						$insert=$db->prepare("INSERT INTO weapons VALUES(NULL,'$name','$description','$price','$categorie','$weight','$shipping','$tva','$final_price','$stock')");
						$insert->execute();

					}else{

						echo "Veuillez remplir tous les champs";
					}
				}
			?>

			<form action="" method="post" enctype="multipart/form-data">
				<fieldset>
					<legend> Produit </legend>
						<label>Nom de l'arme : </label><input type="text" name="name"><br/><br/>
						<label>Description : </label><textarea name="description"></textarea><br/><br/>
						<label>Prix : </label><input type="text" name="price"><br/><br/>
						<label>Categorie de l'arme : </label><select name="categorie">

					<?php

						$select = $db->query('SELECT*FROM categorie');

						while ($s = $select->fetch(PDO::FETCH_OBJ)) {
							
							?>

							<option> <?php echo $s->name; ?></option>

							<?php
						}
					?>

					</select><br><br>
					<label>Image de l'arme : </label><input type="file" name="img"><br/><br/>
				</fieldset><br>
				<fieldset>
					<legend> Frais de port </legend>
					<label style="text-decoration: underline;"> Poids de l'article </label><br><br>
					<label> Moins de : </label>
					<select name="weight">
				
				<?php

						$select = $db->query('SELECT*FROM weight');

						while ($s = $select->fetch(PDO::FETCH_OBJ)) {
							
							?>

							<option> <?php echo $s->name; ?></option>
							<?php
						}
					?>
					
					</select><label> kg </label><br><br>
				</fieldset><br>

				<fieldset>
					<legend> Stock </legend>
					<label> Nombre d'articles à ajouter au stock : </label><input type="text" name="stock">
					<br><br>
				</fieldset>
				<input type="submit" name="Valider">
			</form>

			<?php

			}else if ($_GET['action'] == 'modifyanddelete'){

				$select=$db->prepare("SELECT*FROM weapons");
				$select->execute();

				while($s=$select->fetch(PDO::FETCH_OBJ)){

					echo $s->name;
					?>

						<a href="?action=modify&amp;id=<?php echo $s->id; ?> ">Modifier</a>
						<a href="?action=delete&amp;id=<?php echo $s->id; ?> ">Supprimer</a><br/><br/>

					<?php

				}

			}elseif ($_GET['action'] == 'modify'){

				$id=$_GET['id'];

				$select=$db->prepare("SELECT*FROM weapons WHERE id=$id");
				$select->execute();

				$data=$select->fetch(PDO::FETCH_OBJ);

				?>
				<form action="" method="post">
				<label>Nom de l'arme : </label><input value=' <?php echo $data->name; ?>' type="text" name="name"><br/><br/>
				<label>Description : </label><textarea name="description"><?php echo $data->description; ?></textarea><br/><br/>
				<label>Prix : </label><input value=' <?php echo $data->price; ?>' type="text" name="price"><br/><br/>
				<label>Stock : </label><input type="text" name="stock" value="<?php echo $data->stock; ?>">
				<input type="submit" name="Valider" value="Modifier">
				</form>

				<?php

				if(isset($_POST['Valider'])){

					$name=$_POST['name'];
					$description=$_POST['description'];
					$price=$_POST['price'];
					$stock = $_POST['stock'];
				
					$update=$db->prepare("UPDATE weapons SET name='$name',description='$description',price='$price', stock='$stock' WHERE id=$id");
					$update->execute();
					
					header('Location: admin.php?action=modifyanddelete');

				}
				
			}else if($_GET['action'] == 'delete'){

				$id=$_GET['id'];
				$delete=$db->prepare("DELETE FROM weapons WHERE id=$id");
				$delete->execute();

				header('Location: admin.php?action=modifyanddelete');

			}else if($_GET['action'] == 'add_category'){

				if(isset($_POST['Valider'])){

					$name = $_POST['name'];

					if($name){

						$insert=$db->prepare("INSERT INTO categorie VALUES(NULL,'$name')");
						$insert->execute();

					}else{

						echo "Veuillez remplir tous les champs";
					}
				}

				?>

				<form action="" method="post">
					<label> Nom de la catégorie d'armes : </label><input type="text" name="name"><br></br>
					<input type="submit" name="Valider" value="Ajouter">
				</form>

				<?php

			}else if($_GET['action'] == 'modifyanddelete_category'){

				$select=$db->prepare("SELECT*FROM categorie");
				$select->execute();

				while($s=$select->fetch(PDO::FETCH_OBJ)){

					echo $s->name;
					?>

						<a href="?action=modify_category&amp;id=<?php echo $s->id; ?> ">Modifier</a>
						<a href="?action=delete_category&amp;id=<?php echo $s->id; ?> ">Supprimer</a><br/><br/>
					<?php

				}

			}else if($_GET['action'] == 'modify_category'){

				$id=$_GET['id'];

				$select=$db->prepare("SELECT*FROM categorie WHERE id=$id");
				$select->execute();

				$data=$select->fetch(PDO::FETCH_OBJ);

				?>

				<form action="" method="post">
				<label>Nom de la catégorie : </label><input value=' <?php echo $data->name; ?>' type="text" name="name"><br/><br/>
				<input type="submit" name="Valider" value="Modifier">
				</form>

				<?php

				if(isset($_POST['Valider'])){

					$name=$_POST['name'];
					$id = $_GET['id'];
					$select = $db->query("SELECT name FROM categorie WHERE id = '$id'");
					$result = $select->fetch(PDO::FETCH_OBJ);
					
					$update=$db->prepare("UPDATE categorie SET name='$name' WHERE id=$id");
					$update->execute();

					
					
					$update = $db->query("UPDATE weapons SET categorie = '$name' WHERE categorie = '$result->name'");
	
					header('Location: admin.php?action=modifyanddelete_category');

				}

			}else if($_GET['action'] == 'delete_category'){

				$id=$_GET['id'];
				$delete=$db->prepare("DELETE FROM categorie WHERE id=$id");
				$delete->execute();

				header('Location: admin.php?action=modifyanddelete_category');

			}else if($_GET['action'] == 'options'){
			
				?>

					<fieldset>
						<legend> Frais de port</legend>
						<label> Options de poids (plus de) </label>

				<?php

				$select = $db-> query("SELECT*FROM weight");

				while($s=$select->fetch(PDO::FETCH_OBJ)){

					?>

						<form action="" method="post">
						<input type="text" name="weight" value="<?php echo $s->name; ?>"/><br>
						<a href="?action=modify_weight&amp;name=<?php echo $s->name; ?>"> Modifier</a>
						</form>
					<?php
				}
					?>

					</fieldset>

					<?php
					$select = $db->query("SELECT tva FROM weapons");

					$s = $select->fetch(PDO::FETCH_OBJ);

					if(isset($_POST['Modifier2'])){

						$tva = $_POST['TVA'];

						if($tva){

							$update = $db->query("UPDATE weapons SET TVA=$tva");

						}
					}

					?>

					<fieldset>
						<legend> TVA </legend>
						<form action="" method="post">
							<label> taux de TVA : </label><input type="text" name="TVA" value="<?php 
							echo $s->tva; ?>">
							<input type="submit" name="Modifier2" value="Modifier">
						</form>
					</fieldset>

					<?php

			}else if($_GET['action'] == 'modify_weight'){

				$old_weight = $_GET['name'];
				$select = $db->query("SELECT * FROM weight WHERE name = $old_weight");
				$s = $select->fetch(PDO::FETCH_OBJ);

				if(isset($_POST['modifier'])){

					$weight = $_POST['weight'];
					$price = $_POST['price'];

					if($weight&&$price){

						$update = $db->query("UPDATE weight SET name = '$weight', price = '$price' WHERE name = $old_weight");

					}
				}

				?>

				<fieldset>
					<label style="text-decoration: underline;"> Frais de port : </label><br><br>
					<label style="font-weight: bold;"> Options de poids </label><br><br>

					<form action="" method="post">
						<label> Poids (plus de) : </label><input type="text" name="weight" value="<?php echo $_GET['name']; ?>"><label> kg </label><br><br>
						<label> Correspond à : </label><input type="text" name="price" value="<?php echo $s->price;?>"><label> € </label><br><br>
						<input type="submit" name="modifier" value="Modifier">
					</form>
				</fieldset>

				<?php

			}else{
			

				die('Une erreur s\'est produite');

			}
		}else{

		}
	
	}else{

		header("Location: ../index.php");
	}

?>

