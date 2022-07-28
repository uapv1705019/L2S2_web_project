<?php session_start();?>
<?php include 'class.php'?>
<!DOCTYPE html>
<html>
	<head>
	    <meta charset="utf-8" />
		<title>Projet : Tickets de l'utilisateur sélectionné</title>
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
		<button onclick="location.href='utilisateurs.php'" class="w3-button w3-green">Retour liste utilisateurs</button>
		<?php
		if (isset($_SESSION['login']) && $_SESSION['admin'] == 'true') // seul l'admin doit avoir accès à cette page
		{
		?>
		<button onclick="location.href='produits.php'" class="w3-button w3-blue">Accès liste produits</button>
		<?php
		};
		?>
		<!--<table border="1" style="text-align:center;">-->
		<table class="w3-table w3-border w3-bordered w3-striped">
			<thead class="w3-center">
				<tr>
					<th scope="col">ID</th>
					<th scope="col">DATE</th>
					<th scope="col">PRODUITS</th>
					
				</tr>
				<button class="w3-button w3-yellow monbouton">Afficher/masquer détails</button>
			</thead>
			<tbody>
				<?php
					$stmt = $pdo->query('SELECT DISTINCT tickets.id, tickets.date
										FROM utilisateurs JOIN tickets ON (utilisateurs.id = tickets.utilisateur_id) 
										JOIN ticket_entry ON (tickets.id = ticket_entry.ticket_id) 
										JOIN produits ON (ticket_entry.produit_id = produits.id)
										JOIN categories ON (produits.categorie_id = categories.id)
										where utilisateurs.id ='.$_GET['user'].'
										group by categories.nom, tickets.id
										order by tickets.date;');
					while($row = $stmt->fetch()):
					
				?>
				<tr>
					<td scope="col"><?php echo $row['id'];?></td>
					<td scope="col"><?php echo $row['date'];?></td>
					<td scope="col" class="panneau" style="display:none">								<!--<td scope="col"><?php echo $row['nom'];?></td>-->
					<?php
						$stmt1 = $pdo->query('SELECT DISTINCT produits.nom, categories.nom as nom1
										FROM utilisateurs JOIN tickets ON (utilisateurs.id = tickets.utilisateur_id) 
										JOIN ticket_entry ON (tickets.id = ticket_entry.ticket_id) 
										JOIN produits ON (ticket_entry.produit_id = produits.id)
										JOIN categories ON (produits.categorie_id = categories.id)
										where tickets.id='.$row['id'].'
										group by categories.nom, tickets.id, produits.nom
										order by categories.nom;');
					while($row1 = $stmt1->fetch()):
					?>
					<br><?php echo $row1['nom1']." : ".$row1['nom'];?><br>
					<?php endwhile;?>
					</td>	
				</tr>
				<?php endwhile; ?>
			</tbody>
		
		</table>
		
		<script>
			$(".monbouton").click(function()
			{ 
				$(".panneau").toggle(); 
			});
			</script>
		
	</body>
</html>
