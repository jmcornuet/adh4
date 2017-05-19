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
    <script>
		jQuery(document).ready(function(){
  			console.log("jQuery est prêt !");
		});  		
    	function imprim(num) {
			var codact = document.forms["formactivite"]["activite"].value;//console.log("iact = "+iact);
			var groupe = document.forms["formactivite"]["groupe"].value;//console.log("groupe = "+groupe);
			//var participa = (num === 'avec');
			jQuery.msgBox({ type: "confirm",
				title: "Impression de la liste de présence",
				content: "Quel format d\'impression voulez-vous ?",
				buttons: [{ value: "Annuler" }, { value: "Format A4"}, {value: "Format A3"}],
	            success: function(result,values)  {
		        	if (result!="Annuler") {
						if (result=="Format A4") taille="Format A4";
						else taille="Format A3";
 						var formulaire = document.createElement('form');
			    		formulaire.setAttribute('target','_blank');
			    		formulaire.setAttribute('action','imprimliste.php');
			    		formulaire.setAttribute('method', 'post');
			    		var input0 = document.createElement('input');
			    		input0.setAttribute('type','hidden');input0.setAttribute('name','activite');input0.setAttribute('value',codact);
			    		formulaire.appendChild(input0);
			    		var input1 = document.createElement('input');
			    		input1.setAttribute('type','hidden');input1.setAttribute('name','groupe');input1.setAttribute('value',groupe);
			    		formulaire.appendChild(input1);
			    		var input2 = document.createElement('input');
			    		input2.setAttribute('type','hidden');input2.setAttribute('name','taille');input2.setAttribute('value',taille);
			    		formulaire.appendChild(input2);
			    		var input3 = document.createElement('input');
			    		input3.setAttribute('type','hidden');input3.setAttribute('name','participation');input3.setAttribute('value',num);
			    		formulaire.appendChild(input3);
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
	?>
	<div class="titre1">Impression d'une <b>Liste de présence</b> </div>
	<div class="champ">
		<fieldset class="champemprunteurs">
			<form name="formactivite" method="post" action="imprimliste.php" target="_blank"> 
				<table  class="saisie">
					<tr>
						<td><label for "activite">Activité :</label></td>
						<td><select style="float:left" id="activite" name="activite"><?php echo $optionsactivite ?> </select></td>
					</tr>
					<tr><td></td><td></td></tr>
					<tr> 
						<td><label for "groupe" style="float:right">Groupe :</label></td>
						<td><select id="groupe" name="groupe"><?php echo $optionsgroupe1 ?> </select></td>
					</tr>
					<tr><td></td><td></td></tr>
					<tr>
						<td><label for "taille">Format :</label></td>
						<td><input type="radio" name="taille" value="Format A4" checked>A4 &nbsp;&nbsp;&nbsp;
						<input type="radio" name="taille" value="Format A3">A3</td>
					<tr><td></td><td></td></tr>
					</tr>   
					<tr>
						<td><label for "participation">Colonne "participation" :</label></td>
						<td><input type="radio" name="participation" value="avec">Avec &nbsp;&nbsp;&nbsp;
						<input type="radio" name="participation" value="sans" checked>Sans</td>

					</tr>	
				</table>
					<br><br>
					<input class="bouton" type="submit" value="VALIDER">					
			</form> 
			<!--<button class="bouton"  onclick="imprim('avec')">Imprimer la liste avec la colonne "participation"</button> <br><br> 
				<button class="bouton"  onclick="imprim('sans')">Imprimer la liste sans la colonne "participation"</button> -->
		</fieldset>
	</div>
	<div id="aaa"></div>
</body>
</html>
				