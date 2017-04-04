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
    <script src="fonctions.js"></script>

</head>
<body onload="resizemenu()" onresize="resizemenu()">
	<?php 
		include("menus.php");
        include("gract.inc");
        include("animateurs.inc");
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
        $gract = new Gract;
        $gract->id = $_POST['id'];//echo $gract->id."<br>";
        $gract->getgract($tact);
        $N = new MConf;
        $optionsactivite = putSelected3($optionsactivite,$gract->activite);
        $sql = "SELECT * FROM $tact WHERE codactivite='".$gract->codactivite."' ORDER BY groupe";
        $gracts = new Gracts;
        $gracts->cherche($sql);
        $optionsgr=array();$optionsli=array();$optionsjo=array();$optionsde=array();$optionsfi=array();$optionsan=array();$optionsre=array();
        $n=0;$idgroupe=array();$groupe=array();
        for ($i=0;$i<$gracts->n;$i++) {
            if ($gracts->gract[$i]->idanimateur>0) {
                $anim = getoption($optionsanimateur,$gracts->gract[$i]->idanimateur);
                if ($gracts->gract[$i]->idresponsable) {
                    $responsable = getoption($optionsresponsable,$gracts->gract[$i]->idresponsable);
                } else $responsable = "Responsable";
                //echo $responsable."<br>";die("");
                array_push($optionsgr, putSelected2($optionsgroupe,$gracts->gract[$i]->groupe));
                array_push($optionsli, putSelected($optionslieu,$gracts->gract[$i]->lieu));
                array_push($optionsjo, putSelected($optionsjour,$gracts->gract[$i]->jour));
                array_push($optionsde, putSelected($optionsdebut,$gracts->gract[$i]->debut));
                array_push($optionsfi, putSelected($optionsfin,$gracts->gract[$i]->fin));
                array_push($optionsan,putSelected3($optionsanimateur,$anim));
                array_push($optionsre,putSelected3($optionsresponsable,$responsable));
                array_push($idgroupe,$gracts->gract[$i]->id);
                array_push($groupe,$gracts->gract[$i]->groupe);
                $n++;
            }
        }
        $groupes=join(";",$groupe);
        $idgroupes=join(";",$idgroupe);
        //echo strlen($optionsre[0])."<br>FIN<br>";die("");
	?>
<div class="champ">
	<fieldset class="champemprunteurs">
		<form name="formemprunteurs" action="modifGract.php" method="post">
                <input type="hidden" name="activite" value= "<?php echo $gract->activite ?>" >
                <input type="hidden" name="codactivite" value= <?php echo $gract->codactivite ?> >
                <input type="hidden" name="idgroupes" value="<?php echo $idgroupes ?>" >
                <input type="hidden" name="groupes" value="<?php echo $groupes ?>" >
                <input type="hidden" name="ngract" value=<?php echo $n ?> >
                <input type="hidden" name="tarifA" value=<?php echo $gract->tarifA ?> >
                <input type="hidden" name="tarifC" value=<?php echo $gract->tarifC ?> >


			<table  class="saisie">
				<tr>
					<td style="font-size : 20px;color:blue"> <?php echo $gract->activite ?> </td>
                    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
					<td>&nbsp;&nbsp;Cotisation Adhérent</td>
					<td><input name="tarifA" type="text" size=5 value="<?php echo $gract->tarifA ?>"> </td>
					<td>€</td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td>&nbsp;&nbsp;Cotisation Conjoint</td>
					<td><input name="tarifC" type="text" size=5 value="<?php echo $gract->tarifC ?>"></td>
					<td>€</td>
				</tr>
			</table></br></br>
            <table  class="saisie"> 
            <?php 
                if ($n<1) {
            ?>
                        <tr>
                            <th></th><th>Animateur</th><th>Responsable</th><th>Groupe</th><th>Lieu</th><th>Jour</th><th>Début</th><th>Fin</th>
                        </tr>
                        <tr>
                            <td><input type="hidden" name="id0" value= <?php echo $gracts->gract[0]->id ?> ></td>
                            <td><select name="animateur0"> <?php echo $optionsanimateur ?></select></td>
                            <td><select name="reponsable0"> <?php echo $optionresponsable ?></select></td>
                            <td><select name="groupe0"> <?php echo $optionsgroupe ?></select> </td>
                            <td><select name="lieu0"> <?php echo $optionslieu ?></select></td>
                            <td><select name="jour0"> <?php echo $optionsjour ?></select></td>
                            <td><select name="debut0"> <?php echo $optionsdebut ?></select></td>
                            <td><select name="fin0"> <?php echo $optionsfin ?></select></td>
                        </tr>

            <?php    }

                else { 
            ?>           
                        <tr>
                        	<th></th><th>Animateur</th><th>Responsable</th><th>Groupe</th><th>Lieu</th><th>Jour</th><th>Début</th><th>Fin</th>
                        </tr>
            <?php   for ($i=0;$i<$n;$i++) { 
                        $an="animateur".strval($i);
                        $re="responsable".strval($i);
                        $gr="groupe".strval($i);
                        $li="lieu".strval($i);
                        $jo="jour".strval($i);
                        $de="debut".strval($i);
                        $fi="fin".strval($i);
                        $id="id".strval($i);
            ?>
                        <tr>
                            <td><input type="hidden" name=<?php echo $id ?>  value= <?php echo $gracts->gract[$i]->id ?> ></td>
                            <td><select name=<?php echo $an?> > <?php echo $optionsan[$i] ?></select></td>
                            <td><select name=<?php echo $re?> > <?php echo $optionsre[$i] ?></select></td>
                            <td style="float:right"><select name=<?php echo $gr?> > <?php echo $optionsgr[$i] ?></select>&nbsp;&nbsp;&nbsp; </td>
                            <td><select name=<?php echo $li?> > <?php echo $optionsli[$i] ?></select></td>
                            <td><select name=<?php echo $jo?> > <?php echo $optionsjo[$i] ?></select></td>
                            <td><select name=<?php echo $de?> > <?php echo $optionsde[$i] ?></select></td>
                            <td><select name=<?php echo $fi?>  <?php echo $optionsfi[$i] ?></select></td>
                        </tr>
            <?php   
                    }
                } 
            ?>
            </table>
        </br></br>
		</form>
	</fieldset> </br>
</div>
	<div id="notice"> </div>
</body>
</html>
