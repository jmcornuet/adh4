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
	<div class="titre1">Recherche d'un adhérent dans la base de données</div>
	<div class="champ">
		<fieldset class="champemprunteurs">
			<form name="formemprunteurs" action="idAdherent.php" method="post">
				<input type="hidden" name="id" value="">
			<table  class="saisie">
				<tr>
					<td><select name="titre"><?php echo $optionstitre ?></select></td>
					<td><label for="nom">Nom : </label></td>
					<td><input id="nom" type="text" size=30 name="nom"></td>
						<td>            </td>
				<td><label for="nomjf">Nom de jeune-fille: </label></td>
					<td><input id="nomjf" type="text" size=30 name="nomjf"></td>
					
				</tr>
				<tr>
					<td><select name="qualite"><?php echo $optionsqualite ?></select> </td>			
					<td><label for="prenom">Prénom : </label></td>
					<td><input id="prenom" type="text" size=30 name="prenom"></td>
					<td> </td>
					<td><label for="numMGEN">Numéro Club : </label></td>
					<td><input id="numMGEN" type="text" size=10 name="numMGEN"></td>
				</tr>
				<tr>					
					<td> </td>
					<td><label for="telephone">Téléphone : </label> </td>			
					<td><input id="telephone" type="text" size=15 name="telephone"></td>
					<td> </td>
					<td><label for="portable">N° portable : </label></td>
					<td><input id="portable" type="text" size=15 name="portable"></td>
				</tr>
				<tr>					
					<td> </td>			
					<td><label for "adresse">Adresse :</label></td>
					<td><input id="adresse" type="text" size=30 name="adresse"></td>
					<td> </td>
					<td><label for "compadresse">Complément :</label></td>
					<td><input id="compadresse" type="text" size=30 name="compadresse"></td>
				</tr>
				<tr>					
					<td> </td>			
					<td><label for "codepostal">Code postal :</label></td>
					<td><input id="codepostal" type="text" size=10 name="codepostal"></td>
					<td> </td>
					<td><label for "ville">Ville :</label></td>
					<td><input id="ville" type="text" size=30 name="ville"></td>
				</tr>
				<tr>					
					<td> </td>			
					<td><label for="courriel">Courriel : </label></td>
					<td><input id="courriel" type="text" name="courriel" size=30></td> 
					<td> </td>
					<td><label for "profession">Profession :</label></td>
					<td><select name="profession"><?php echo $optionsprofession ?></select></td>
				</tr>
				<tr>					
					<td> </td>			
					<td><label for "assurance">Assurance :</label></td>
					<td><input id="assurance" type="text" size=30 name="assurance"></td>
					<td> </td>
					<td><label for "specialite">Spécialité :</label></td>
					<td><input name="specialite" type="text" size=30></td>
				</tr>
				<tr>					
					<td> </td>			
					<td><label for="numeroSS">Numéro S.S. : </label>  </td>
					<td><input id="numeroSS" type="text" name="numeroSS" size=25></td>
					<td> <input type="hidden" name="cotisation" value=""></td>
					<td><label for="cotisation">Cotisation : </label></td></td>
					<td><input id="cotisation" type="radio" name="cotisation" value="P">A jour &nbsp;&nbsp;&nbsp;
					<input id="cotisation" type="radio" name="cotisation" value="A">En attente </td>
				</tr>
				<tr>
					<td> </td>			
					<td><label for="premannee">Adhérent depuis : </label></td>
					<td><input id="premannee" name="premannee" type="text" size=10></td>
					<td> </td>			
					<td><label for="sortie">Sortie du club : </label></td>
					<td><input name="sortie" type="text" size=30></td>

				</tr>
			</table> 
			</br>
			<table class="saisie">
				<tr>
					<th>Activité</th><th>Groupe</th><th>Réglée</th><th>Attente</th><th>     </th>
					<th>Activité</th><th>Groupe</th><th>Réglée</th><th>Attente</th>
				</tr>
					<td><select name="activite1"  class="selectoption"><?php echo $optionsactivite ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;<select name="groupe1" class="selectoption"><?php echo $optionsgroupe ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p1p" value="" ></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p1a" value="" ></td>
					<td></td>
					<td><select  name="activite4" class="selectoption"><?php echo $optionsactivite ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;<select name="groupe4" class="selectoption"><?php echo $optionsgroupe ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p4p" value="" ></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p4a" value="" ></td>
				</tr>			
				<tr>
				<tr>
					<td><select name="activite2"  class="selectoption"><?php echo $optionsactivite ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;<select name="groupe2" class="selectoption"><?php echo $optionsgroupe ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p2p" value="" ></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p2a" value="" ></td>
					<td></td>
					<td><select  name="activite5" class="selectoption"><?php echo $optionsactivite ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;<select name="groupe5" class="selectoption"><?php echo $optionsgroupe ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p5p" value="" ></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p5a" value="" ></td>
				</tr>			
				<tr>
				<tr>
					<td><select name="activite3"  class="selectoption"><?php echo $optionsactivite ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;<select name="groupe3" class="selectoption"><?php echo $optionsgroupe ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p3p" value="" ></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p3a" value="" ></td>
					<td></td>
					<td><select  name="activite6" class="selectoption"><?php echo $optionsactivite ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;<select name="groupe6" class="selectoption"><?php echo $optionsgroupe ?></select></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p6p" value="" ></td>
					<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="p6a" value="" ></td>
				</tr>			
			</table>
					</br>
					<input type="submit" value="RECHERCHER">
			</form>
		</fieldset>
	</div>
 </body>
 </html>