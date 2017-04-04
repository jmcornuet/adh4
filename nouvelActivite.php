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
	<div class="titre1">Création d'une nouvelle activité</div>
	<div class="champ">
		<fieldset class="champemprunteurs">
			<form name="nouvelact" method="post" action="ajoutActivite.php">
			<table  class="saisie">
				<tr>
					<td><label for="activite">Nom de l'activité:</label></td>
					<td><input id="activite" type="text" size=40 name="activite"></td>					
				</tr>
			</table>
			<table>
				<tr>
					<td><label for="tarifA">Tarif adhérent : </label></td>
					<td><input id="tarifA" type="text" size=5 name="tarifA" ></td>
					<td></td>
					<td><label for="tarifC">Tarif conjoint : </label></td>
					<td><input id="tarifC" type="text" size=5 name="tarifC"></td>
				</tr>
			</table>
			<br><br>
			<table  class="saisie">
                <tr>
                    <th>Animateur</th><th>Responsable</th><th>Groupe</th><th>Lieu</th><th>Jour</th><th>Début</th><th>Fin</th>
                </tr>
                <tr>
                    <td><select name="idanimateur"> <?php echo $optionsanimateur ?></select></td>
                    <td><select name="idresponsable"> <?php echo $optionsresponsable ?></select></td>
                    <td><select name="groupe"> <?php echo $optionsgroupe ?></select> </td>
                    <td><select name="lieu"> <?php echo $optionslieu ?></select></td>
                    <td><select name="jour"> <?php echo $optionsjour ?></select></td>
                    <td><select name="debut"> <?php echo $optionsdebut ?></select></td>
                    <td><select name="fin"> <?php echo $optionsfin ?></select></td>
                </tr>

			</table>
					</br>
					<input type="submit" value="VALIDER">
			</form>
	
		</fieldset>
	</div>
	<div id="message"></div>
 </body>
 </html>