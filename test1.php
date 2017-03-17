<?php
	//header('content-type: text/html; charset=utf-8');
	setlocale(LC_TIME, 'fr_FR.utf8', 'fra', 'fr_FR.ISO8859-1');
	echo strftime("%A %d %B %Y");
	include("MGENconfig.php");
	$M = new MConf;
	$bdd = new PDO($M->pdo1,$M->pdo2,$M->pdo3);
	$bdd->exec("SET NAMES 'UTF8'");
//	$sql = "SET NAME UTF8";
//	$reponse = $bdd->query($sql);	
	$sql = "SELECT activite FROM $M->tablgra";
	$reponse = $bdd->query($sql);
	while ($donnees = $reponse->fetch()) {
		echo $donnees["activite"]."<br>";
	}

?>