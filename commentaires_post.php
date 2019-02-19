<!-- Traitement de l'ajout du commentaire dans la BDD -->


<?php
	$id=$_GET['id'];
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=test', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"));
	}
	catch (Exception $e) {
		die ('Erreur : ' . $e->getMessage());
	}
	$req = $bdd->prepare('INSERT INTO commentaires (id_billet, auteur, commentaire) VALUES (?, ?, ?)');
	$req->execute(array($id, $_POST['auteur'], $_POST['com_new']));
	
	header("Location: commentaires.php?id=$id");
?>