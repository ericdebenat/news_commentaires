<!DOCTYPE HTML>
<html>
<head>
	<meta charset='utf-8'>
	<link rel='stylesheet' href='style.css'>
	<title>Commentaires</title>
</head>
<body>
	<div class='titre'><h1>Les News</h1></div>
	<div><a href='index.php'>Retour à la liste des news</a></div>
	<?php
	$id=$_GET['id'];
	
/* Connexion à la base de données */	

	try {
		$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
	}
	catch (Exception $e) {
		die ('Erreur : ' . $e->getMessage());
	}

/* Affichage de la news */
	
	$req = $bdd->query("SELECT id, titre, contenu, DATE_FORMAT(date_creation, '%d/%m/%Y') AS jour, DATE_FORMAT(date_creation, '%Hh%imin%ss') AS heure FROM billets WHERE id='$id'");
	$billets = $req->fetch()
	?>
		<div class='titre_billet'>
			<h3><?php echo htmlspecialchars($billets['titre']) ?> <em>le <?php echo $billets['jour'] ?> à <?php echo $billets['heure'] ?></em></h3>
		</div>
		<div class='contenu_billet'>
			<?php echo htmlspecialchars($billets['contenu']) ?>
		</div>
		<div>
			<h2>Commentaires :</h2>
		</div>
		
	<?php
	$req->closeCursor();

/* Affichage des commentaires */

	$req = $bdd->query("SELECT auteur, DATE_FORMAT(date_commentaire, '%d/%m/%Y') AS jour, DATE_FORMAT(date_commentaire, '%Hh%imin%ss') AS heure, commentaire FROM commentaires WHERE id_billet='$id' ORDER BY date_commentaire ASC");
	while ($commentaires = $req->fetch()) { ?>
		<div class='titre_commentaire'>
			<strong><?php echo htmlspecialchars($commentaires['auteur']) ?></strong> le <?php echo $commentaires['jour'] ?> à <?php echo $commentaires['heure'] ?> :
		</div>
		<div class='contenu_commentaire'>
			<span class='com'><?php echo htmlspecialchars($commentaires['commentaire']) ?></span>
		</div>
	<?php 
	}
	$req->closeCursor();
	?>

<!-- Formulaire d'ajout d'un commentaire -->

	<div>
		<h2>Ajouter un commentaire :</h2>
		<form method='post' action="commentaires_post.php?id=<?php echo $id ?>">
			<div><label for='auteur'>Pseudo : </label></div>
			<div><input type='text' name='auteur' required></div>
			<div><label for='com_new'>Commentaire : </label></div>
			<div><textarea name='com_new' rows=5 required></textarea></div>
			<div><input type='submit' value='Envoyer'></div>
		</form>
	</div>
</body>
</html>