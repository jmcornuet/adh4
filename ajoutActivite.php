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
    <script src="fonctions.js"></script>
</head>
<body onload="resizemenu()" onresize="resizemenu()">
	<?php 
		include("menus.php");
	    include("gract.inc");
	    include("animateurs.inc");
	    $ga = new Gract;
	    $ga->getpost();
	    $ga->getnouveaucode($tact);
        //$an = new Animateur;
        //$an->animateur = $ga->animateur;
        //$ga->idanimateur = $an->idanim();
	    $ga->insere($tact);
	    if ($ga->id>0) echo "</br></br><div class='alerte'>La nouvelle activité $ga->activite a été ajoutée à la base de données avec l'id $ga->id </div>";
	    else echo "</br></br><div class='alerte'>La nouvelle activité $ga->activite n'a pas pu être ajoutée à la base de données !!!</div>";

	?>
</body>
</html>