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
	<?php 
		include("menus.php");
		include("liOptions.php"); 
	?>
	<div class="titre1">Recherche d'une activité dans la base de données</div>
	<div class="champ">
		<fieldset class="champemprunteurs">
			<form name="formactivite" action="idActivite.php" method="post">
			<table  class="saisie">
				<tr>
					<td><label for "activite">Activité :</label></td>
					<td><select name="codactivite"><?php echo $optionsactivite ?> </select></td>
					<td>   </td>
					<td><label for "groupe">Groupe :</label></td>
					<td><select name="groupe"><?php echo $optionsgroupe ?> </select></td>

				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td><select name="lieu"><?php echo $optionslieu ?></select></td>
					<td><select name="jour"><?php echo $optionsjour ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  </td>
					<td style="float:right">De:</td>
					<td><select name="debut"><?php echo $optionsdebut ?></select> </td>
					<td>A:</td>
					<td><select name="fin"><?php echo $optionsfin ?></select> </td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>
			<table>
				<tr>
					<td></td>
					<td>Cotisation adhérent:</td>
					<td><input id="tarifA" type="text" size=10 name="tarifA"></td>
					<td> </td>
					<td style="float:right">Cotisation Conjoint:</td>
					<td><input id="tarifC" type="text" size=10 name="tarifC"></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>Animateur:</td>
					<td><select name="idanimateur"><?php echo $optionsanimateur ?></select> 
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
				</tr>
				<tr>
					<td></td>
					<td>Responsable:</td>
					<td><select name="idresponsable"><?php echo $optionsresponsable ?></select> 
					<td></td>
					<td></td>
					<td></td>
				</tr>
			</table>
					</br>
					<input type="submit" value="RECHERCHER">
			</form>
		</fieldset>
</div>
</body>
</html>	
