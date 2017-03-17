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
	<div class="titre1">Recherche d'un animateur dans la base de données</div>
	<div class="champ">
		<fieldset class="champemprunteurs">
			<form name="formactivite" action="idAnimateur.php" method="post">
			<table  class="saisie">

				<tr>
					<td style="float:right">Nom : </label></td>
					<td><input type="text" size=30 name="nom"></td>
					<td style="float:right">Téléphone : </td>
					<td><input type="text" size=15 name="telephone"></td>
				</tr>
				<tr>
					<td style="float:right">Courriel : </label></td>
					<td><input type="text" size=30 name="courriel"></td>
					<td style="float:right">Portable : </td>
					<td><input type="text" size=15 name="portable"></td>
				</tr>
			</table>
					</br>
					<input type="submit" value="RECHERCHER">
			</form>
		</fieldset>
	</div>
</body>
</html>	
