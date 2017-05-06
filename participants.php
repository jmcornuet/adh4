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
	<div class="titre1">Liste des participants : choix de l'activité et du groupe</div>
	<div class="champ">
		<fieldset class="champemprunteurs">
			<form name="formactivite" method="post" action="listepart.php"> 
				<table  class="saisie">
					<tr>
						<td><label for "activite">Activité :</label></td>
						<td><select name="codactivite"><?php echo $optionsactivite ?> </select></td>
						<td>   </td>
						<td><label for "groupe">Groupe :</label></td>
						<td><select id="groupe" name="groupe"><?php echo $optionsgroupe1 ?> </select></td>
					</tr>
				</table>
				<br><br>
				<input type="submit" value="Afficher la liste des participants"> 
			</form> 
		</fieldset>
	</div>
	<div id="aaa"></div>
</body>
</html>
				