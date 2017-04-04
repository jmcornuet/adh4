<div id="datedujour"> &nbsp;&nbsp;
	<?php 
	//setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
	setlocale(LC_TIME,'fr_FR.utf8','fra','fr_FR.ISO8859-1');
	echo strftime("%A %d %B %Y");
	//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$prenom." aux commandes !";
	echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Version ".$version;

	$anencours = strftime("%Y");
	?>
</div>
<span id="fenetre"></span>
 <div  id='topPage'> Gestion du Club des retraités de la MGEN (section de Paris)<div>
 	<div id="menugeneral">
	<ul class="niveau1">
		<li>
			<a href="club0.php">Accueil</a>
		</li>
		<li>
			<a href="#">Adhérents</a>
			<ul>
				<li><a href="chercheAdherent.php">Chercher</a></li>
				<li><a href="modifierAdherent.php">Modifier</a></li>
				<li><a href="nouvelAdherent.php">Créer</a></li>
			</ul>
		</li>
		<li>
			<a href="#">Activités</a>
			<ul>
				<li><a href="chercheActivite.php">Chercher</a></li>
				<li><a href="modifierActivite.php">Modifier</a></li>
				<?php 
					if ($niveau>1) echo '<li><a href="#" style="background-color:#ED1E55">Créer</a></li>'; 
					else echo '<li><a href="nouvelActivite.php">Créer</a></li>';
				?>				
			</ul>
		</li>
		<li>
			<a href="#">Animateurs</a>
			<ul>
				<li><a href="chercheAnimateur.php">Chercher</a></li>
				<li><a href="modifierAnimateur.php">Modifier</a></li>
				<?php
					if ($niveau>1) echo '<li><a href="#" style="background-color:#ED1E55">Créer</a></li>';
					else echo '<li><a href="nouvelAnimateur.php">Créer</a></li>';
				?>				
			</ul>
		</li>
		<li>
			<a href="#">Outils</a>
			<ul>
				<li><a href="planning.php">Planning</a></li>
				<li><a href="#">Statistiques</a></li>
				<li><a href="participants.php">Participants</a></li>
				<li><a href="listepresence.php">Liste de présence</a></li>
			</ul>
		</li>
		<li>
			<a href="quitter.php">Quitter</a>
		</li>
	</ul>
</div>
</br></br>
