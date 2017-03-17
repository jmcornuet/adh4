<?php
    session_start();
    require_once("session.php");
    if (!$prenom) die();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Club MGEN</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="bibglobal0.css" type="text/css" rel="stylesheet" media="screen"/>
    <link href="msgBoxLight.css" rel="stylesheet">
    <script src="jquery-2.1.4.min.js"></script>
    <script src="jquery.msgBox.js"></script>
    <script src="fonctions.js"></script>
</head>
<body onload="resizemenu()" onresize="resizemenu()">
	<?php 
        include("menus.php"); 
	    include("animateurs.inc");
	    include("gract.inc");
	    $an = new Animateur;
	    $an->getpost();
	    $an->id = $an->idanim($tani);
	    $rep = $an->modifie($tani);
	    if (!$rep) echo "</br></br><div class='alerte'>La fiche de $an->prenom $a->nom n'a pas pu être modifiée dans la base de données coucou !!!</div>";
	    else {
		    $gr = new Gracts;
		    $gr->getpost();
		    $rep = true;
	        for ($i=0;$i<$gr->n;$i++) {
	        	$gr->gract[$i]->getcodactivite($tact);
        		$gr->gract[$i]->idanimateur = $an->id;
	        	//echo $gr->gract[$i]->id."-  -".$gr->gract[$i]->activite."-  -".$gr->gract[$i]->codactivite."-  -".$gr->gract[$i]->idanimateur."-  ".$gr->gract[$i]->groupe."  ".$gr->gract[$i]->lieu."  ".$gr->gract[$i]->jour."  ".$gr->gract[$i]->debut."  ".$gr->gract[$i]->fin." <br>";
        		$r = $gr->gract[$i]->modifie($tact);
        		$rep = ($rep and $r);
	        }
	        if ($rep) echo "</br></br><div class='alerte'>La fiche de $an->prenom $an->nom a bien été modifiée dans la base de données </div>";

    	}
	?>
</body>
</html>