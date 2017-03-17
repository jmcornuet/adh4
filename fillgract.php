<?php
	$sql = "SELECT * FROM tactivites2016";
	$bdd = new PDO('mysql:host=localhost;dbname=clubmgen','root','root');
    $reponse=$bdd->query($sql);
    $n=0;$activite=array();$tarifA=array();$tarifC=array();
    while ($donnees = $reponse->fetch()) {
    	$act=addslashes($donnees['activite']);
    	array_push($activite,$act);
    	array_push($tarifA,$donnees['tarifA']);
    	array_push($tarifC,$donnees['tarifC']);
    	echo $activite[$n]."</br>";
    	$n++;

    }
    for ($i=1;$i<$n;$i++) {
    	$sql = "UPDATE tgract2016 SET activite='$activite[$i]' WHERE id=$i+1";
    	$reponse=$bdd->query($sql);
    	echo $i."<br>";
    }
    $bdd=null;
?>