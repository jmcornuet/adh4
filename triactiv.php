<?php
	for ($i=1;$i<1200;$i++) {
		$sql = "SELECT * FROM tadherents2016 WHERE id=$i";
		$bdd = new PDO('mysql:host=localhost;dbname=clubmgen','root','root');
	    $reponse=$bdd->query($sql);
	    if($donnees=$reponse->fetch()) {
	    	echo "mise en ordre alphabétique des activités de l'adhérent $i<br>";
	    	$act=array();
	    	if ($donnees['activite1'] != "Pas d'activité") array_push($act,$donnees['activite1']);
	    	if ($donnees['activite2'] != "Pas d'activité") array_push($act,$donnees['activite2']);
	    	if ($donnees['activite3'] != "Pas d'activité") array_push($act,$donnees['activite3']);
	    	if ($donnees['activite4'] != "Pas d'activité") array_push($act,$donnees['activite4']);
	    	if ($donnees['activite5'] != "Pas d'activité") array_push($act,$donnees['activite5']);
	    	if ($donnees['activite6'] != "Pas d'activité") array_push($act,$donnees['activite6']);
	    	$n=count($act);
	    	sort($act);
	    	for ($j=$n;$j<6;$j++) array_push($act,"Pas d'activité");
	    	echo join(',',$act)."<br>";
	    	$sql = "UPDATE tadherents2016 SET activite1='addslashes($act[0])', activite2='addslashes($act[1])', activite3='addslashes($act[2])', 
	    activite4='addslashes($act[3]', activite5='addslashes($act[4])', activite6='addslashes($act[5])' WHERE id=$i";
	    	$reponse=$bdd->query($sql);
	    	if ($reponse) echo "......................C'est fait<br><br>";
	    }
	}
    $bdd=null;
echo "programme terminé<br>"

?>