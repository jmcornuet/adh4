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
	<?php include("menus.php"); ?>
	<div class="titre1">Création d'une fiche Animateur</div>
	<div class="champ">
		<fieldset class="champemprunteurs">
			<form name="nouvelAnimateur" method="post" action="ajoutAnimateur.php">
			<table  class="saisie">
				<tr>
					<td><select id="titre" name="titre"><option value="Titre">Titre</option><option value="MME">Mme</option><option value="M.">M.</option></select></td>
					<td><label for="nom">Nom : </label></td>
					<td><input id="nom" type="text" size=40 name="nom" class="fichinput" onfocus="blanc(1)" onblur="test(1)"></td>
					
				</tr>
				<tr>
					<td><select id="qualite" name="benevole"><option value="Benevole">Bénévole</option><option value="oui">OUI</option><option value="non">NON</option></select> </td>			
					<td><label for="prenom">Prénom : </label></td>
					<td><input id="prenom" type="text" size=40 name="prenom" class="fichinput" onfocus="blanc(2)" onblur="test(2)"></td>
				</tr>
				<tr>					
					<td> </td>
					<td><label for="telephone">Téléphone : </label> </td>			
					<td><input id="telephone" type="text" size=15 name="telephone" class="fichinput" onfocus="blanc(4)" onblur="test(4)"></td>
					<td><label for="portable">N° portable : </label></td>
					<td><input id="portable" type="text" size=15 name="portable"></td>
				</tr>
				<tr>					
					<td> </td>			
					<td><label for="courriel">Courriel : </label></td>
					<td><input id="courriel" type="text" name="courriel" size=40></td> 
					<td></td>
					<td></td>
				</tr>
			</table>
					</br>
					<input id="go" type="hidden" value="CONFIRMER">
			</form>
				<td><button id="bouton0" class="bouton"  onclick="valideAnimateur()">CREER FICHE</button></td>
	
		</fieldset>
	</div>
	<div id="message"></div>
 </body>
 </html>
