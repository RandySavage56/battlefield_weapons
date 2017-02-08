<?php

	require_once("include/header.php");
	require_once("include/sidebar.php");
?> 
	<div class="col-md-9">		
<?php

	if(isset($_GET['show'])){

		$weapon = $_GET['show'];

		$select=$db->prepare("SELECT*FROM weapons WHERE name= '$weapon'");
		$select->execute();

		$s = $select->fetch(PDO::FETCH_OBJ);

		$description = $s->description;

		$description_finale = wordwrap($description,100,'<br/>',true);

		?>
		<div style="text-align: center;">
			<img class='col-md-3'src="admin/imgs/<?php echo $s->name; ?>.jpg" class="col-md-3">
			<h1 style="color: #4286f4;"> <?php echo $s->name; ?></h1>
			<h4 style="color: white;"> <?php echo $s->price; ?> € </h4>
			<h5 style="color: white;"> <?php echo $description_finale; ?></h5>
			<h5 style="color: white;"> Stock : <?php echo $s->stock; ?></h5>
			<?php 
					if($s->stock != 0){
				?>
				<div class="addtocart">
				<a href="panier.php?action=ajout&amp;l=<?php echo $s->name; ?>&amp;q=1&amp;p=<?php echo $s->price;?>">Ajouter au panier</a>
					<br/><br/>
				</div>
				<?php
				}else{
					echo '<h5 style="color: red"> Rupture de stock </h5>';
				}
		?>
		</div>

		<?php

	}else{
	
		if(isset($_GET['category'])){

			$categorie = $_GET['category'];
			$select=$db->prepare("SELECT*FROM weapons WHERE categorie= '$categorie'");
			$select->execute();

			?>
			<div class="col-md-9">

			<?php

			while($s=$select->fetch(PDO::FETCH_OBJ)){

				$length = 60;

				$description = $s->description;

				$new_description = substr($description, 0, $length).'...';

				$description_finale = wordwrap($new_description,25,'<br/>',true);

				?>
				<br>
				<a href="?show=<?php echo $s->name;?>"><img class='col-md-2'src="admin/imgs/<?php echo $s->name; ?>.jpg"></a>
				<a href="?show=<?php echo $s->name;?>"><h2 style="color: #4286f4;" class='col-md-3'><?php echo $s->name; ?></h2><br/></a>
					<h5 style="color: white;" class='col-md-2'><?php echo $description_finale; ?></h5><br/>
					<h4 style="color: #e5a53d;" class='col-md-1'><?php echo $s->price; ?> €</h4><br/>
					<h5 style="color: white;" class="col-md-2"> Stock : <?php echo $s->stock; ?></h5>
				<?php 
					if($s->stock != 0){
				?>
				<div class="addtocart">
				<a href="panier.php?action=ajout&amp;l=<?php echo $s->name; ?>&amp;q=1&amp;p=<?php echo $s->price;?>">Ajouter au panier</a>
					<br/><br/>
				</div>
				<?php
				}else{
					echo '<h5 style="color: red"> Rupture de stock </h5>';
				}
		}
	?>
		
		<br/><br/><br/><br/>
				</div>

	<?php 

		}else{

		?>

		<h3 class="category"> Catégories d'armes </h1>
		<?php
		$select = $db->query('SELECT*FROM categorie');

		while($s = $select->fetch(PDO::FETCH_OBJ)){

			?>
			<div class="col-md-9">
			<div class="row">
				<div class="col-md-9">
			<a href="?category=<?php echo $s->name; ?>"><h4> <?php echo $s->name ?></h4></a>
				</div>
			</div>
			</div>
			<?php

		}
	}
}

	require_once("include/footer.php");
?>
