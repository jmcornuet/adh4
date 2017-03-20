<?php
	include("adherents.inc");
	$tadh = "tadh2016";
	for ($i=1;$i<1183;$i++) {
		$ad = new Adherent;
		$ad->id = $i;
		echo $i."  ";
		$ad->getadh($tadh);
		if ($ad->nom) {if($ad->modifie($tadh)) echo "modifié<br>"; else echo "ignoré<br>";} 
		$ad = null;
	}	
?>
