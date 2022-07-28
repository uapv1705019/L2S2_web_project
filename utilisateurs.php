<?php
session_start();

// connexion à la BDD
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

// création des variables de session

if(isset($_POST['login']) and isset($_POST['password']))
{
	// vérification de l'identité de la personne qui se connecte
	$log = $pdo->query('SELECT * FROM utilisateurs;');
	$logok = false; // booléen qui dit si il y a correspondance entre les valeurs entrées dans le form et la BDD
	$isadmin = false; // booléen qui dit si la personne connectée est admin ou non
	$prenom = ""; // pas du tout nécessaire, juste présent pour l'esthétique
	while($row = $log->fetch()):
		if($row['nom'] == $_POST['login'] && $row['id'] == $_POST['password'])
		{
			$logok = true;
			$prenom = $row['prenom'];
			if ($row['admin'] == "true") // on vérifie le contenu de la colonne 'admin' pour la personne dont on a trouvé la correspondance login/password
			{
				$isadmin = true;
			}
		}
	endwhile;
	
	if ($logok == true)
	{
		$_SESSION['login'] = $_POST['login'];
		$_SESSION['password'] = $_POST['password'];
		$_SESSION['admin'] = $isadmin;
		$_SESSION['prenom'] = $prenom;
	}
}
?>
<?php include 'class.php'?>
<!DOCTYPE html>
<html>
	<head>
	    <meta charset="utf-8" />
		<title>Projet : Liste utilsateurs</title>
		<meta name="author" content="Laurent Pereira">
		<meta name="reply-to" content="laurent.pereira-da-silva-quintas@alumni.univ-avignon.fr">
	    <meta name="description" content="">
		<meta name="Content-Type" content="text/html; charset=utf-8">
		<meta name="Content-Language" content="fr">
		<meta name="keywords" content="">
		<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<!--<?php
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
		?>-->
	</head>
	<body>
		<!--boutons de connexion et de déconnexion-->
		<?php
		if (!isset($_SESSION['login']))
		{
		?>
		<p> Bonjour invité, vous n'êtes actuellement pas connecté. Si vous voulez profiter pleinement de notre site : <button onclick="document.getElementById('id01').style.display='block'" class="w3-button w3-green">Se connecter</button></p>
		
		<?php
		};
		?>
		
		<?php
		if (isset($_SESSION['login']))
		{
		?>
		<p>Bonjour <?php echo $_SESSION['prenom']." ".$_SESSION['login'];?>. Ce n'est pas vous? <button onclick="location.href='logout.php'" class="w3-button w3-red">Se déconnecter</button></p>
		<?php
		};
		?>
		
		<?php
		if (isset($_SESSION['login']) && $_SESSION['admin'] == true) // seul l'admin doit avoir accès à cette page
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
					<th scope="col">PRENOM</th>
					<th scope="col">NOM</th>
					<?php
					if (isset($_SESSION['login']))
					{
						?>
					<th scope="col">TICKET</th>
					<?php
					};
					?>
				</tr>
			</thead>
			<tbody class="w3-center">
				<?php
					$stmt = $pdo->query('SELECT * FROM utilisateurs ORDER BY id;');
					while($row = $stmt->fetch()):
					
				?>
				<tr>
					<td scope="col"><?php echo $row['id'];?></td>
					<td scope="col"><?php echo $row['prenom'];?></td>
					<td scope="col"><?php echo $row['nom'];?></td>
					<?php
					if (isset($_SESSION['login']))
					{
						if ($_SESSION['admin'] == true)
						{
					?>
						<td scope="col"><a href="<?php echo"tickets.php?user=".$row['id']?>">Voir ticket</a></td>
					<?php
						}
						elseif (($_SESSION['admin'] == false) && ($row['id'] == $_SESSION['password']))
						{
					?>
						<td scope="col"><a href="<?php echo"tickets.php?user=".$row['id']?>">Voir ticket</a></td>
					<?php
						}
					};
					?>
					
					
					
					
					
					<!--<td scope="col"><a href="<?php echo"tickets.php?user=".$row['id']?>"><?php echo $row['id'];?></a></td>-->
					
				</tr>
				<?php endwhile; ?>
			</tbody>
		
		</table>
		
		<!--Code bouton login-->
		<div id="id01" class="w3-modal">
			<div class="w3-modal-content w3-card-4 w3-animate-zoom" style="max-width:600px">

			  <div class="w3-center"><br>
				<span onclick="document.getElementById('id01').style.display='none'" class="w3-button w3-xlarge w3-hover-red w3-display-topright" title="Close Modal">&times;</span>
				<img src="avatar.gif" alt="Avatar" style="width:30%" class="w3-circle w3-margin-top">
			  </div>

			  <form class="w3-container" action="utilisateurs.php" method = "POST">
				<div class="w3-section">
				  <label><b>Username</b></label>
				  <input class="w3-input w3-border w3-margin-bottom" type="text" placeholder="Enter Username" name="login" id= "login" required>
				  <label><b>Password</b></label>
				  <input class="w3-input w3-border" type="password" placeholder="Enter Password" name="password" id="password" required>
				  <button class="w3-button w3-block w3-green w3-section w3-padding" type="submit">Login</button>
				  <input class="w3-check w3-margin-top" type="checkbox" checked="checked"> Remember me
				</div>
			  </form>

			  <div class="w3-container w3-border-top w3-padding-16 w3-light-grey">
				<button onclick="document.getElementById('id01').style.display='none'" type="button" class="w3-button w3-red">Cancel</button>
				<span class="w3-right w3-padding w3-hide-small">Forgot <a href="#">password?</a></span>
			  </div>

			</div>
		  </div>
		
		
	</body>
</html>
