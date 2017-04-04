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
        include("liOptions.php"); 
	    include("animateurs.inc");
	    include("gract.inc");
	    $an = new Animateur;
	    $an->getpost();
	    $n = $_POST['ngract'];
	    $ga = new Gracts;
	    $ga->getpost2($n);
	    $rep = $an->modifie($tani);//if ($rep) echo "modification animateur OK<br>"; else echo "modification animateur NOT OK<br>";
	    for ($i=0;$i<$ga->n;$i++){
	    	$ga->gract[$i]->activite=getoption($optionsactivite,$ga->gract[$i]->codactivite);
	    	$ga->gract[$i]->idanimateur = $an->id;
	    	$ga->gract[$i]->animateur = $an->animateur;//print_r($ga);echo "<br>";
	    	$r = $ga->gract[$i]->modifie($tact);// if ($r) echo "modification activite OK<br>"; else echo "modification activite NOT OK<br>";
	    	$rep = ($rep && $r);
	    }
	    if ($rep) echo "</br></br><div class='alerte'>La fiche de $an->prenom $an->nom a bien été modifiée dans la base de données </div>";
	    else echo "</br></br><div class='alerte'>La fiche de $an->prenom $a->nom n'a pas pu être modifiée dans la base de données coucou !!!</div>";    	
	?>
</body>
</html>