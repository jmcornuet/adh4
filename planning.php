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
    <link href="msgBoxLight.css" rel="stylesheet">
    <script src="jquery-2.1.4.min.js"></script>
    <script src="jquery.msgBox.js"></script>
    <link href="bibglobal0.css" type="text/css" rel="stylesheet" media="screen"/>
    <script src="fonctions.js"></script>
</head>
<body onload="resizemenu()" onresize="resizemenu()">
    <?php 
        include("menus.php");
        $lieu=["tous","Salle 5","Salle 14","Salle 15","Salle 16","Salle 17","Salle 18","Gymnase","Bridge","Foyer"];
        $optionslieu="";
        for ($i=0;$i<count($lieu);$i++) $optionslieu = $optionslieu."<option value=\"$lieu[$i]\" >$lieu[$i]</option>";
    ?>
    <div class="titre1">Planning d'occupation des salles : choix de la salle</div>
    <div class="champ">
        <fieldset class="champemprunteurs">
            <form name="formactivite" method="post" action="affichPlanning.php"> 
                <table  class="saisie">
                    <tr>
                        <td><label for "lieu">Lieu :</label></td>
                        <td><select id="lieu" name="lieu"><?php echo $optionslieu ?> </select></td>
                    </tr>
                </table>
                <br><br>
                <input type="submit" value="Afficher le planning"> 
            </form> 
        </fieldset>
    </div>
    <div id="aaa"></div>
</body>
</html>
                