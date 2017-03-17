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
		include("liOptions.php"); 
	?>
	<div class="titre1">Recherche d'une activité dans la base de données</div>
	<div class="champ">
		<fieldset class="champemprunteurs">
			<form name="formactivite" method="post" action="listepart.php"> 
				<table  class="saisie">
					<tr>
						<td><label for "activite">Activité :</label></td>
						<td><select id="activite" name="activite"><?php echo $optionsactivite ?> </select></td>
						<td>   </td>
						<td><label for "groupe">Groupe :</label></td>
						<td><select id="groupe" name="groupe"><?php echo $optionsgroupe ?> </select></td>
					</tr>
				</table>
				<input type="submit" value="Afficher la liste des participants"> 
			</form> 
		</fieldset>
	</div>
	<div id="aaa"></div>
</body>
</html>
				