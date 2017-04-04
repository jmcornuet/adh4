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
    include("liOptions.php");//echo "avant animateurs.inc<br>";
    include("animateurs.inc");//echo "après animateurs.inc<br>";
    $an = new Animateur;
    $an->id = $_POST['id'];//echo "avant getani<br>";
    $an->getani($tani);//echo "après getani<br>";
    $OK = $an->supprime($tani);//echo "après supprime<br>";
    if($OK) echo "</br></br><div class='alerte'>La fiche de $an->prenom $an->nom a bien été supprimée de la base de données</div>";
	else echo "</br></br><div class='alerte'>La fiche de $an->prenom $an->nom n'a pas pu être supprimée de la base de données !!!</div>";
?>
</body>
</html>
