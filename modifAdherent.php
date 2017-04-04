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
	    include("adherents.inc");
        include("liOptions.php");
	    $ad = new Adherent;
	    $ad->getpost();
        $ad->activite1=getoption($optionsactivite,$ad->activite1);
        $ad->activite2=getoption($optionsactivite,$ad->activite2);
        $ad->activite3=getoption($optionsactivite,$ad->activite3);
        $ad->activite4=getoption($optionsactivite,$ad->activite4);
        $ad->activite5=getoption($optionsactivite,$ad->activite5);
        $ad->activite6=getoption($optionsactivite,$ad->activite6);
        $ad->getcodes($tact);
	    if ($ad->modifie($tadh)) echo "</br></br><div class='alerte'>La fiche de $ad->prenom $ad->nom a bien été modifiée dans la base de données </div>";
	    else echo "</br></br><div class='alerte'>La fiche de $ad->prenom $ad->nom n'a pas pu être modifiée dans la base de données !!!</div>";
	?>
</body>
</html>