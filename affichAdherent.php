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
    <script>
		jQuery(document).ready(function(){
  			console.log("jQuery est prêt !");
		});  		
    	function imprim(id) {
			jQuery.msgBox({ type: "confirm",
				title: "Impression",
				content: "Quel format d\'impression voulez-vous ?",
				buttons: [{ value: "Annuler" }, { value: "Simple"},{ value: "Complet"}],
	            success: function(result)  {
		        	if (result!="Annuler") {
 						var formulaire = document.createElement('form');
			    		formulaire.setAttribute('target','_blank');
			    		formulaire.setAttribute('action','imprimAdherent.php');
			    		formulaire.setAttribute('method', 'post');
			    		var input0 = document.createElement('input');
			    		input0.setAttribute('type','hidden');input0.setAttribute('name','id');input0.setAttribute('value',id);
			    		formulaire.appendChild(input0);
			    		var input1 = document.createElement('input');
			    		input1.setAttribute('type','hidden');input1.setAttribute('name','forme');input1.setAttribute('value',result);
			    		formulaire.appendChild(input1);
				   		document.body.appendChild(formulaire);
			    		formulaire.submit();
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
		include("adherents.inc");
		$ad = new Adherent;
		$ad->id = $_POST['id'];
		$ad->getadh($tadh);
		$ad->getactivites($tact);
		if ($ad->particip1=="P") $particip1="checked";else $particip1="";
		if ($ad->particip2=="P") $particip2="checked";else $particip2="";
		if ($ad->particip3=="P") $particip3="checked";else $particip3="";
		if ($ad->particip4=="P") $particip4="checked";else $particip4="";
		if ($ad->particip5=="P") $particip5="checked";else $particip5="";
		if ($ad->particip6=="P") $particip6="checked";else $particip6="";
		//echo $ad->activite1."  ".$ad->activite2."  ".$activite3."<br>";
		function putSelected($opt,$sel) {
			$f=strpos($opt,$sel)+strlen($sel)+1;
			$s1=substr($opt,0,$f);
			$s2=substr($opt,$f,strlen($opt));
			return $s1." selected".$s2;
		}
        function putSelected2($opt,$sel) {
        	if ($sel=='0') return $opt;
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
		$optionstitre = putSelected($optionstitre,$ad->titre);
		$optionsqualite = putSelected($optionsqualite,$ad->qualite);
		$optionsprofession = putSelected($optionsprofession,$ad->profession);
		$optionsactivite1 = putSelected3($optionsactivite,$ad->activite1);
		$optionsactivite2 = putSelected3($optionsactivite,$ad->activite2);
		$optionsactivite3 = putSelected3($optionsactivite,$ad->activite3);
		$optionsactivite4 = putSelected3($optionsactivite,$ad->activite4);        	

		$optionsactivite5 = putSelected3($optionsactivite,$ad->activite5);
		$optionsactivite6 = putSelected3($optionsactivite,$ad->activite6);
		$optionsgroupe1 = putSelected2($optionsgroupe,$ad->groupe1);
		$optionsgroupe2 = putSelected2($optionsgroupe,$ad->groupe2);
		$optionsgroupe3 = putSelected2($optionsgroupe,$ad->groupe3);
		$optionsgroupe4 = putSelected2($optionsgroupe,$ad->groupe4);
		$optionsgroupe5 = putSelected2($optionsgroupe,$ad->groupe5);
		$optionsgroupe6 = putSelected2($optionsgroupe,$ad->groupe6);
?>		
	<div class="champ">
		<fieldset class="champemprunteurs">
			<form name="nouvelAd" action="modifAdherent.php" method="post">
				<input type="hidden" name="id" value="<?php echo $ad->id ?>">
			<table  class="saisie">
				<tr>
					<td><select id="titre" name="titre"> <?php echo $optionstitre ?></select></td>
					<td><label for="nom">Nom : </label></td>
					<td><input id="nom" type="text" size=40 name="nom" value="<?php echo $ad->nom ?>" ></td>
					<td><label for="nomjf">Nom de naissance: </label></td>
					<td><input id="nomjf" type="text" size=30 name="nomjf" value="<?php echo $ad->nomjf ?>" ></td>
					
				</tr>
				<tr>
					<td><select name="qualite"><?php echo $optionsqualite ?></select> </td>			
					<td><label for="prenom">Prénom : </label></td>
					<td><input id="prenom" type="text" size=40 name="prenom" value="<?php echo $ad->prenom ?>" ></td>
					<td><label for="numMGEN">Numéro Club : </label></td>
					<td><input id="numMGEN" type="text" size=10 name="numMGEN" value="<?php echo $ad->numMGEN ?>" ></td>
				</tr>
				<tr>					
					<td> </td>
					<td><label for="telephone">Téléphone : </label> </td>			
					<td><input id="telephone" type="text" size=15 name="telephone" value="<?php echo $ad->telephone ?>" ></td>
					<td><label for="portable">N° portable : </label></td>
					<td><input id="portable" type="text" size=15 name="portable" value="<?php echo $ad->portable ?>" ></td>
				</tr>
				<tr>					
					<td> </td>			
					<td><label for "adresse">Adresse</label></td>
					<td><input id="adresse" type="text" size=40 name="adresse" value="<?php echo $ad->adresse ?>" ></td>
					<td><label for "compadresse">Complément</label></td>
					<td><input id="compadresse" type="text" size=30 name="compadresse" value="<?php echo $ad->compadresse ?>" ></td>
				</tr>
				<tr>					
					<td> </td>			
					<td><label for "codepostal">Code postal :</label></td>
					<td><input id="codepostal" type="text" size=10 name="codepostal" value="<?php echo $ad->codepostal ?>" ></td>
					<td><label for "ville">Ville :</label></td>
					<td><input id="ville" type="text" size=30 name="ville" value="<?php echo $ad->ville ?>" ></td>
				</tr>
				<tr>					
					<td> </td>			
					<td><label for="courriel">Courriel : </label></td>
					<td><input id="courriel" type="text" name="courriel" size=40 value="<?php echo $ad->courriel ?>" ></td> 
					<td><label for "profession">Profession</label></td>
					<td><select name="profession"><?php echo $optionsprofession ?></select></td>
				</tr>
				<tr>					
					<td> </td>			
					<td><label for "assurance">Assurance :</label></td>
					<td><input id="assurance" type="text" size=30 name="assurance" value="<?php echo $ad->assurance ?>" ></td>
					<td><label for "specialite">Spécialité</label></td>
					<td><input name="specialite" size=30 type="text" value="<?php echo $ad->specialite ?>"></td>
				</tr>
				<tr>					
					<td> </td>			
					<td><label for="numeroSS">Numéro S.S. : </label>  </td>
					<td><input id="numeroSS" type="text" name="numeroSS" size=25 value="<?php echo $ad->numeroSS ?>" ></td>
					<td><label for="cotisation">Cotisation : </label></td></td>
					<td><input id="cotisationP" type="radio" name="cotisation" value=0 <?php if ($ad->cotisation=='0') echo "checked" ?> >A jour &nbsp;&nbsp;&nbsp;
					<input id="cotisationA" type="radio" name="cotisation" value=1 <?php if ($ad->cotisation!='0') echo "checked" ?>>
						<?php 
							if ($ad->cotisation!='0') echo "<span style='color:red;font-weight: bold'> EN ATTENTE</span";
							else echo "En attente";
						?> 
					</td>
				</tr>
				<tr>					
					<td> </td>			
					<td><label for="premannee">Adhérent depuis : </label></td>
					<td><input id="premannee" name="premannee" type="text" size=10 value="<?php echo $ad->premannee ?>"></td>
					<td><label for"sortie">Sortie du club : </label></td>
					<td><input type="text" size=30 name="sortie" value="<?php echo $ad->sortie ?>" ></td>
				</tr>
			</table> 
			</br></br>
			<table class="saisie">
				<tr>
					<th>Activité</th><th>Groupe</th><th>Réglée</th><th>     </th><th>Activité</th><th>Groupe</th><th>Réglée     </th>
				</tr>
				<tr>

					<td><select name="activite1"  class="selectoption"><?php echo $optionsactivite1 ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;<select name="groupe1" class="selectoption"><?php echo $optionsgroupe1 ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="particip1" value="" <?php echo $particip1 ?> ></td>
					<td></td>
					<td><select  name="activite4" class="selectoption"><?php echo $optionsactivite4 ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;<select name="groupe4" class="selectoption"><?php echo $optionsgroupe4 ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="particip4" value="" <?php echo $particip4 ?> ></td>
					<td></td>
				</tr>			
				<tr>
					<td><select name="activite2" class="selectoption"><?php echo $optionsactivite2 ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;<select name="groupe2" class="selectoption"><?php echo $optionsgroupe2 ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="particip2" value="" <?php echo $particip2 ?> ></td>
					<td></td>
					<td><select  name="activite5" class="selectoption"><?php echo $optionsactivite5 ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;<select name="groupe5" class="selectoption"><?php echo $optionsgroupe5 ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="particip5" value="" <?php echo $particip5 ?> ></td>
				</tr>			
				<tr>
					<td><select name="activite3" class="selectoption"><?php echo $optionsactivite3 ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;<select name="groupe3" class="selectoption"><?php echo $optionsgroupe3 ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="particip3" value="" <?php echo $particip3 ?> ></td>
					<td></td>
					<td><select  name="activite6" class="selectoption"><?php echo $optionsactivite6 ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;<select name="groupe6" class="selectoption"><?php echo $optionsgroupe6 ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="particip6" value="" <?php echo $particip6 ?> ></td>
				</tr>
				<tr><td> </td></tr>
				<tr>
					<td> </td>
					<td> </td>
					<td> </td>					
					<td> </td>
					<td></td>
				</tr>

			</table>
					<input id="go" type="hidden"  value="CONFIRMER">
			</form>
			
	<!--		<button id="bouton0" class="bouton"  onclick="valide()">MODIFIER</button>  -->
			<button id="bouton1" class="bouton"  onclick="imprim(<?php echo $ad->id ?>)">IMPRIMER</button>

		</fieldset>
	</br>

	</div>  
	<div id="message"></div>
</body>
</html>