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
        $sql = "SELECT * FROM $tact ORDER BY activite";
        $reponse=$M->querydb($sql);
        $ac=array();$id=array();
        while($donnees = $reponse->fetch()) {
            array_push($ac,$donnees['activite']);
            array_push($id,$donnees['id']);
        }
        $act=array();$ida=array();
        for ($i=0;$i<count($ac);$i++) {
            if ($ac[$i] != "Pas d'activité") {
                if (count($act)==0) {array_push($act,$ac[$i]);array_push($ida,$id[$i]);}
                else {
                    $trouve=false;$j=0;
                    while ((!$trouve)and($j<count($act))) {
                        $trouve=($act[$j]==$ac[$i]);
                        if (!$trouve) $j++;
                    }
                    if (!$trouve) {array_push($act,$ac[$i]);array_push($ida,$id[$i]);}
                }
            }
        }
        $optionsactivite="";
        for($i=0;$i<count($act);$i++) $optionsactivite = $optionsactivite."<option value=$ida[$i]>$act[$i]</option>";
    ?>
    <div class="titre1">Modification d'une activité</div>
    <div class="champ">
        <fieldset class="champemprunteurs">
            <form name="nouvelAd" method="post" action="affichGract2.php">
                Choisissez l'activité que vous voulez modifier : <br><br>
                <select name="id"><?php echo $optionsactivite ?></select></td>
                 <input type="submit" value="VALIDER">
            </form>
        </fieldset>
    </div>
</body>
</html>
