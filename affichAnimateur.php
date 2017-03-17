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
    <script type="text/javascript">
        function supprim(id){
            $.msgBox({
                title: "Suppression d'un animateur",
                content: "Voulez-vous supprimer cet animateur?",
                type: "confirm",
                buttons: [{ value: "ANNULER" }, { value: "SUPPRIMER" }],
                success: function (result) {
                    if (result == "SUPPRIMER") {
                        
                    }
                }
            });
        }

    </script>
</head>
<body onload="resizemenu()" onresize="resizemenu()">
	<?php 
		include("menus.php");
		include("liOptions.php");
        include("animateurs.inc");
        include("gract.inc");
        $an=new Animateur;
        $an->id=$_POST['id'];
        $an->getani($tani);// echo $an->prenom." ".$an->nom."<br>";
        function putSelected($opt,$sel) {
            $f=strpos($opt,$sel)+strlen($sel)+1;
            $s1=substr($opt,0,$f);
            $s2=substr($opt,$f,strlen($opt));
            return $s1." selected".$s2;
        }
        function putSelected2($opt,$sel) {
            $f=strpos($opt,$sel)+strlen($sel);
            $s1=substr($opt,0,$f);
            $s2=substr($opt,$f,strlen($opt));
            return $s1." selected".$s2;
        }
        function putSelected3($opt,$sel) {
            $f=strpos($opt,$sel)-1;
            $s1=substr($opt,0,$f);
            $s2=substr($opt,$f,strlen($opt));
            return $s1." selected".$s2;            
        }
        if (strtolower($an->benevole)=="oui") $optionsbenevole = "<option selected>oui</option><option>non</option>"; 
        else $optionsbenevole = "<option>oui</option><option selected>non</option>";
        $g = new Gract;
        $gracts = new Gracts;
        $sql = "SELECT * FROM $tact WHERE idanimateur=".$an->id." ORDER BY groupe";
        $gracts->cherche($sql);
        $optionsgr=array();$optionsli=array();$optionsjo=array();$optionsde=array();
        $optionsfi=array();$optionsac=array();
        for ($i=0;$i<$gracts->n;$i++) {
            array_push($optionsgr, putSelected2($optionsgroupe,$gracts->gract[$i]->groupe));
            array_push($optionsac, putSelected3($optionsactivite,$gracts->gract[$i]->activite));
            array_push($optionsli, putSelected($optionslieu,$gracts->gract[$i]->lieu));
            array_push($optionsjo, putSelected($optionsjour,$gracts->gract[$i]->jour));
            array_push($optionsde, putSelected($optionsdebut,$gracts->gract[$i]->debut));
            array_push($optionsfi, putSelected($optionsfin,$gracts->gract[$i]->fin));
        }
    ?>
<div class="champ">
    <fieldset class="champemprunteurs">
        <form name="formemprunteurs" action="modifAnimateur.php" method="post">
                <input type="hidden" name="id" value= <?php echo $id ?> >
                <input type="hidden" name="ngract" value= <?php echo $gracts->n ?> >
            <table  class="saisie">
                <tr>
                    <td><label for "nom">Nom :</label></td>
                    <td><input name="nom" type="text" size=30 value="<?php echo $an->nom?>"></td>
                    <td style="float:right"><label for "benevole">Bénévole :</label></td>
                    <td><select name="benevole"><?php echo $optionsbenevole ?></select>
                </tr>
                <tr>
                    <td><label for "prenom">Prénom :</label></td>
                    <td><input name="prenom" type="text" size=30 value="<?php echo $an->prenom?>"></td>
                </tr>
                <tr>
                    <td><label for "telephone">Téléphone fixe :</label></td>
                    <td><input name="telephone" type="text" size=30 value="<?php echo $an->telephone?>"></td>
                </tr>
                <tr>
                    <td><label for "portable">Téléphone portable :</label></td>
                    <td><input name="portable" type="text" size=30 value="<?php echo $an->portable?>"></td>
                </tr>
                <tr>
                    <td><label for "courriel">Courriel :</label></td>
                    <td><input name="courriel" type="text" size=30 value="<?php echo $an->courriel?>"></td>
                </tr>
            </table></br>
            <table  class="saisie"> 
            <table  class="saisie"> 
                        <tr>
                            <th>  </th><th>Activité</th><th>Groupe</th><th>Lieu</th><th>Jour</th><th>Début</th><th>Fin</th>
                        </tr>

            <?php 

                for ($i=0;$i<$gracts->n;$i++) 
                    {
            ?>           
                        <tr>
                            <td> <input type="hidden" name=<?php echo "id".strval($i)?> value="<?php echo $gracts->gract[$i]->id ?>"></td>
                            <td><select name=<?php echo "activite".strval($i) ?> > <?php echo $optionsac[$i] ?></select></td>
                            <td><select name=<?php echo "groupe".strval($i) ?> > <?php echo $optionsgr[$i] ?></select> </td>
                            <td><select name=<?php echo "lieu".strval($i) ?> > <?php echo $optionsli[$i] ?></select></td>
                            <td><select name=<?php echo "jour".strval($i) ?> > <?php echo $optionsjo[$i] ?></select></td>
                            <td><select name=<?php echo "debut".strval($i) ?> > <?php echo $optionsde[$i] ?></select></td>
                            <td><select name=<?php echo "fin".strval($i) ?> > <?php echo $optionsfi[$i] ?></select></td>
                        </tr>
            <?php   
                    } 

            ?>
            </table></br>
<!--             <input type="submit" name="modif" value="MODIFIER"> -->
        </form> </br>
<!--        <button class="bouton"  style="float:right" onclick="supprim(<?php echo $id ?>)">SUPPRIMER</button> -->

    </fieldset>
</div>
</body>
</html>

