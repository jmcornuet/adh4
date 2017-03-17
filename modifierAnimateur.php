<?php
	session_start();
    require_once("session.php");
	if (!$prenom) die();
	include("liOptions.php");
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
    <script type="text/javascript"></script>
</head>
<body onload="resizemenu()" onresize="resizemenu()">
	<?php 
        include("menus.php");
        $M = new MConf;
        $sql = "SELECT * FROM $tani ORDER BY nom";
        $reponse=$M->querydb($sql);
        $an=array();$id=array();
        while ($donnees = $reponse->fetch()) {
            $animateur=$donnees['nom']." ".$donnees['prenom'];
            array_push($an,$animateur);
            array_push($id,$donnees['id']);
        }
        $optionspersonne="";
        for($i=0;$i<count($an);$i++) {
            $optionspersonne = $optionspersonne."<option value=$id[$i]>$an[$i]</option>";
    }

    ?>
    <div class="titre1">Modification d'une fiche adhérent</div>
    <div class="champ">
        <fieldset class="champemprunteurs">
            <form name="nouvelAd" method="post" action="affichAnimateur2.php">
                Choisissez l'animateur dont vous voulez modifier la fiche : <br><br>
                <select name="id"><?php echo $optionspersonne ?></select></td>
                 <input type="submit" value="VALIDER">
            </form>
        </fieldset>
    </div>
</body>
</html>


