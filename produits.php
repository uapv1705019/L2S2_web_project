<?php session_start();?>
<?php include 'class.php'?>
<!DOCTYPE html>
<html>
	<head>
	    <meta charset="utf-8" />
		<title>Projet : Liste produits</title>
		<meta name="author" content="Laurent Pereira">
		<meta name="reply-to" content="laurent.pereira-da-silva-quintas@alumni.univ-avignon.fr">
	    <meta name="description" content="">
		<meta name="Content-Type" content="text/html; charset=utf-8">
		<meta name="Content-Language" content="fr">
		<meta name="keywords" content="">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<?php
			$host = 'xxx';
			$db = 'xxx';
			$username = 'xxx';
			$password = 'xxx';
	 
			$dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$username;password=$password";
			
			try
			{
				// create a PostgreSQL database connection
				$pdo = new PDO($dsn);
				 
				// display a message if connected to the PostgreSQL successfully
				if($pdo)
				{
					echo "Connection to the <strong>$db</strong> database successfully!";

				}
			}
			catch (PDOException $e)
			{
			// report error message
			echo $e->getMessage();
			}
		?>
	</head>
	<body>
		<button onclick="location.href='utilisateurs.php'" class="w3-button w3-blue">Accès liste utilisateurs</button>
		<p>Ajouter ou modifier un produit :</p>
		<p style="color:red">Note : ne pas modifier les produits dont l'id est compris entre 1 et 12</p>
		<div class="w3-container">
		<table class="w3-table">
			<form method="GET" action="produits.php">
				<tr>
					<td><input type="text" name="id" placeholder="id produit"></td>
					<td><select name="categorie">
							<option value="Rayon frais">Rayon frais</option>
							<option value="Conserves">Conserves</option>
							<option value="Bricolage">Bricolage</option>
							<option value="Jardin">Jardin</option>
							<option value="Electroménager">Electroménager</option>
						</select>
					</td>
					<td><input type="text" name="nom" placeholder="nom produit"></td>
					<td><input type="text" name="prix" placeholder="prix produit"></td>
					<td><input type="submit"></td>
				</tr>
			</form>
		</table>
		</div>
		
		<?php
		if (isset($_GET['id']) && isset($_GET['categorie']) && isset($_GET['nom']) && isset($_GET['prix']) && $_GET['id']>12) // j'ai bloqué la modification des produits déjà présents dans la BDD afin de ne modifier que les produits qu'on ajoute.
		{
			if ($_GET['categorie'] == "Rayon frais")
			{
				$idCategorie = 1;
			}
			if ($_GET['categorie'] == "Conserves")
			{
				$idCategorie = 2;
			}
			if ($_GET['categorie'] == "Bricolage")
			{
				$idCategorie = 3;
			}
			if ($_GET['categorie'] == "Jardin")
			{
				$idCategorie = 4;
			}
			if ($_GET['categorie'] == "Electroménager")
			{
				$idCategorie = 5;
			}
			
			$isid = false; // booléen pour savoir si l'id est déjà dans la BDD
			$idverif = $pdo->query('select id from produits;');
			while($row = $idverif->fetch()):
				if ($row['id'] == $_GET['id']) // si il y a correspondance entre l'id de la BDD et l'id donné dans le form
				{
					$isid = true;
				}
			endwhile;
			
			if($isid == true) // correspondance trouvée, UPDATE nécessaire
			{
				$pdo->query('UPDATE produits
							SET nom = \''.$_GET['nom'].'\',
							prix = \''.$_GET['prix'].'\',
							categorie_id = \''.$idCategorie.'\'
							WHERE id = '.$_GET['id'].';'); // modification d'une ligne dans le tableau
			}
			if($isid == false) // aucune correspondance, création nécessaire
			{
				$pdo->query('INSERT INTO produits (id, nom, prix, categorie_id) VALUES (\''.$_GET['id'].'\', \''.$_GET['nom'].'\', \''.$_GET['prix'].'\', \''.$idCategorie.'\')'); //ajout d'une ligne dans le tableau
			}
		}
		?>
		<table class="w3-table w3-border w3-bordered w3-striped">
			<thead class="w3-center">
				<tr>
					<th scope="col">ID PRODUIT</th>
					<th scope="col">CATEGORIE</th>
					<th scope="col">NOM PRODUIT</th>
					<th scope="col">PRIX</th>
				</tr>
			</thead>
			<tbody class="w3-center">
				<?php
					$stmt = $pdo->query('SELECT produits.id, produits.nom, produits.prix, categories.nom as nom_cat
										FROM produits JOIN categories ON (produits.categorie_id = categories.id)
										ORDER BY categories.nom;');
					while($row = $stmt->fetch()):
					
				?>
				<tr>
					<td scope="col"><?php echo $row['id'];?></td>
					<!--<td scope="col"><?php echo $row['nom_cat'];?></td>-->
					<td scope="col"><a href="<?php echo"lastticket.php?categorie=".$row['nom_cat']?>"><?php echo $row['nom_cat']?></a></td>
					<!--<td scope="col"><?php echo $row['nom'];?></td>-->
					<td scope="col"><a href="<?php echo"lastticket.php?produit=".$row['nom']?>"><?php echo $row['nom']?></a></td>
					<td scope="col"><?php echo $row['prix']?></td>
					
				</tr>
				<?php endwhile; ?>
			</tbody>
		</table>
		
	</body>
</html>