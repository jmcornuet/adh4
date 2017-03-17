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
        include("adherents.inc");
        $M = new MConf; 
        $sql="SELECT id,nom,prenom FROM $tadh ORDER BY nom";
        $reponse = $M->querydb($sql);
        $id=array();$nom=array();$prenom=array();
        while ($donnees = $reponse->fetch()) {
            array_push($id,$donnees['id']);
            array_push($nom,$donnees['nom']);
            array_push($prenom,$donnees['prenom']);            
        }
        $optionspersonne="";
        for($i=0;$i<count($id);$i++) {
            $optionspersonne = $optionspersonne."<option value=".$id[$i].">".$nom[$i]." ".$prenom[$i]."</option>";
        }
    ?>
    <div class="titre1">Modification d'une fiche adhérent</div>
    <div class="champ">
        <fieldset class="champemprunteurs">
            <form name="nouvelAd" method="post" action="affichAdherent2.php">
                Choisissez la personne dont vous voulez modifier la fiche : <br><br>
                <select name="id"><?php echo $optionspersonne ?></select></td>
                 <input type="submit" value="VALIDER">
            </form>
        </fieldset>
    </div>
</body>
</html>

