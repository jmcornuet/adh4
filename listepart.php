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
	<script type="text/javascript">
		function imprim() {
			var codact = document.forms["formbidon"]["codact"].value;
			var groupe = document.forms["formbidon"]["groupe"].value;
 			var formulaire = document.createElement('form');
			formulaire.setAttribute('target','_blank');
			formulaire.setAttribute('action','imprimActivite.php');
			formulaire.setAttribute('method', 'post');
    		var input0 = document.createElement('input');
    		input0.setAttribute('type','hidden');input0.setAttribute('name','activite');input0.setAttribute('value',codact);
    		formulaire.appendChild(input0);
    		var input1 = document.createElement('input');
    		input1.setAttribute('type','hidden');input1.setAttribute('name','groupe');input1.setAttribute('value',groupe);
    		formulaire.appendChild(input1);
	   		document.body.appendChild(formulaire);
    		formulaire.submit();
   		}
	</script>
	<?php 
		include("menus.php");
		include("liOptions.php");
		include ("gract.inc");
		include ("adherents.inc");
		include("animateurs.inc");
		$codact = $_POST['codactivite'];
		if ($codact==0) {
			echo "Vous n'avez pas choisi d'activité <br>";
			echo "<a href=";echo $_SERVER['HTTP_REFERER'];echo">Recommencez</a>";
		}
		$grou = $_POST['groupe'];
		$gra = new Gract;
		$gra->codactivite = $codact;
		$gra->groupe = $grou;
		$gra->getid($tact);
		$gra->getgract($tact);
		$resp = new Adherent;
		$resp->id = $gra->idresponsable;
		$resp->getadh($tadh);
		if (!$resp->prenomnom) $resp->prenomnom=$resp->prenom." ".$resp->nom;
		$an = new Animateur;
		$an->id = $gra->idanimateur;
		$an->getani($tani);//echo $an->prenom." ".$an->nom."<br>";
		if ($gra->codactivite<10) $req = "%0".strval($gra->codactivite)."-".strval($grou)."%";
		else $req = "%".strval($gra->codactivite)."-".strval($grou)."%";
		$N = new MConf;
		$sql = "SELECT * FROM $tadh WHERE activites LIKE '$req' ORDER BY nom";
		//echo $sql."<br>";
		$ad = new Adherents;
		$ad->cherche($sql,$tact);

	?>
	<form name="formbidon" >
		<input type="hidden" name="codact" value="<?php echo $codact ?>" >
		<input type="hidden" name="groupe" value="<?php echo $grou ?>" >
	</form> 
<!--	<div id="controle"><div> -->
	<table>
		<tr>
			<td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;</td>
			<td></td>
			<td id="activite" style="font-size:30px;color:blue"><?php echo $gra->activite ?></td>
			<td>&nbsp;&nbsp;</td>
			<td style="text-align:right"> Groupe : </td>
			<td id="groupe" style="text-align:left"><?php echo $grou ?></td><td>&nbsp;&nbsp;</td>
			<td><button id="bouton1" class="bouton"  style="float:right" onclick="imprim()">IMPRIMER</button></td> 
		</tr>
		<tr>
			<td>&nbsp;&nbsp;</td>
			<td>Animateur : </td>
			<td style="font-size:24px"><?php echo $an->prenom." ".$an->nom ?> </td>
			<td></td> 
			<td style="text-align:right">Lieu : </td> <td style="text-align:left"><?php echo $gra->lieu."       " ?></td> 
		</tr>
		<tr>
			<td>&nbsp;&nbsp;</td>
			<td>Responsable : </td> 
			<td style="font-size:24px"> <?php echo $resp->prenomnom ?> </td>
			<td></td>
			<td style="text-align:right"> Horaire : </td><td style="text-align:left"><?php echo $gra->jour."   ".$gra->debut." - ".$gra->fin ?></td>
							
		</tr>
<!--		<tr> 
			<td>&nbsp;&nbsp;</td>
			<td style="text-align:right">Jour : </td> <td style="text-align:left"><?php echo $gra->jour."       " ?></td> 
			<td style="text-align:right">Début : </td> <td style="text-align:left"><?php echo $gra->debut."     " ?></td> 
			<td style="text-align:right">Fin : </td> <td style="text-align:left"><?php echo $gra->fin ?></td> 
		</tr> -->
	</table>
	<br>
	<table class="tablepart">
		<tr>
			<th>Numéro</th><th></th><th>NOM</th><th>PRENOM</th><th>TELEPHONE</th><th></th><th></th><th></th>
		</tr>
		<?php 
			for ($i=0;$i<$ad->n;$i++) {
				$mes = "<tr> <td>".$ad->adh[$i]->numMGEN."</td><td>".$ad->adh[$i]->qualite."</td> <td>".$ad->adh[$i]->nom."   </td><td>   ".$ad->adh[$i]->prenom."   </td><td>".$ad->adh[$i]->telephone."</td><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;</td><td>&nbsp;&nbsp;</td></tr>";
				echo $mes;
			}
		?>
	</table>
</body>
</html>