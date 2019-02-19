<!DOCTYPE HTML>
<html>
<head>
	<meta charset='utf-8'>
	<link rel='stylesheet' href='style.css'>
	<title>Les derniers billets</title>
</head>
<body>
	<div class='titre'><h1>Les News</h1></div>
	<div>Dernières news :</div>
	<?php
	
/* Connexion à la base de données */	
	
		try {
			$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
		}
		catch (Exception $e) {
			die ('Erreur : ' . $e->getMessage());
		}
		$req = $bdd->query('SELECT id, titre, contenu, DATE_FORMAT(date_creation, \'%d/%m/%Y\') AS jour, DATE_FORMAT(date_creation, \'%Hh%imin%ss\') AS heure FROM billets ORDER BY date_creation DESC');

/* Affichage des news */

		while ($billets = $req->fetch()) { ?>
			<div class='titre_billet'>
				<h3><?php echo $billets['titre'] ?> <em>le <?php echo $billets['jour'] ?> à <?php echo $billets['heure'] ?></em></h3>
			</div>
			<div class='contenu_billet'>
				<?php echo $billets['contenu'] ?>
				<div class='lien_commentaire'>
					<?php echo "<a href='commentaires.php?id=".$billets['id']."'>Commentaires</a>"; ?>
				</div>
			</div>
		<?php }
		$req->closeCursor();
	?>
</body>
</html>