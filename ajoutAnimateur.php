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
	    include("animateurs.inc");
	    $an = new Animateur;
	    $an->getpost();
	    $an->insere($tani);
	    if ($an->id>0) echo "</br></br><div class='alerte'>La fiche de $an->prenom $an->nom a été ajoutée à la base de données avec l'id $an->id </div>";
	    else echo "</br></br><div class='alerte'>La fiche de $an->prenom $an->nom n'a pas pu être ajoutée à la base de données !!!</div>";

	?>
</body>
</html>