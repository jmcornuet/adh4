<?php
	$bdd = new PDO('mysql:host=localhost;dbname=clubmgen','root','root');
	$sql = "SELECT * FROM tgract2016";
	$reponse=$bdd->query($sql);
	$ac=array();$cod=array();
	while ($donnees = $reponse->fetch()) {
		array_push($ac,$donnees['activite']);
		if ($donnees['codactivite'] != "00") {
			array_push($cod,(";".$donnees['codactivite']."-1"));
		} else array_push($cod,"");
	}
	for ($i=0;$i<count($ac);$i++) echo $ac[$i]."(".$cod[$i].")    ";
		echo "<br>";
	//echo join(',',$cod)."<br><br>";
	//echo join(',',$ac)."<br>";
	for ($j=21;$j<1200;$j++) {
		$sql = "SELECT * FROM tadherents2016 WHERE id=$j";
	    $reponse=$bdd->query($sql);
	    if($donnees=$reponse->fetch()) {
	    	echo "récupération des activités de l'adhérent $j<br>";
	    	$newact="";
	    	$trouve=false;$i=0;
	    	while ((!$trouve)and($i<count($ac))) {
//	    		echo $i."    ".$donnees['activite1']."  VERSUS  ".$ac[$i]."<br>";
	    		$trouve = ($donnees['activite1']==$ac[$i]); 
	    		if (!$trouve) $i++;
	    	} 
	    	if ($trouve) $newact .=$cod[$i];
	    	else $newact .= ";".$donnees['activite1'];
	    	$trouve=false;$i=0;
	    	while ((!$trouve)and($i<count($ac))) {$trouve = ($donnees['activite2']==$ac[$i]); if (!$trouve) $i++;} 
	    	if ($trouve) $newact .=$cod[$i];
	    	else $newact .= ";".$donnees['activite2'];
	    	$trouve=false;$i=0;
	    	while ((!$trouve)and($i<count($ac))) {$trouve = ($donnees['activite3']==$ac[$i]); if (!$trouve) $i++;} 
	    	if ($trouve) $newact .=$cod[$i];
	    	else $newact .= ";".$donnees['activite3'];
	    	$trouve=false;$i=0;
	    	while ((!$trouve)and($i<count($ac))) {$trouve = ($donnees['activite4']==$ac[$i]); if (!$trouve) $i++;} 
	    	if ($trouve) $newact .=$cod[$i];
	    	else $newact .= ";".$donnees['activite4'];
	    	$trouve=false;$i=0;
	    	while ((!$trouve)and($i<count($ac))) {$trouve = ($donnees['activite5']==$ac[$i]); if (!$trouve) $i++;} 
	    	if ($trouve) $newact .=$cod[$i];
	    	else $newact .= ";".$donnees['activite5'];
	    	$trouve=false;$i=0;
	    	while ((!$trouve)and($i<count($ac))) {$trouve = ($donnees['activite6']==$ac[$i]); if (!$trouve) $i++;} 
	    	if ($trouve) $newact .=$cod[$i];
	    	else $newact .= ";".$donnees['activite6'];
	    	if ($newact=="") $newact=";00";
	    	echo $j."     ".$newact."<br>";
	    	$sql = "UPDATE tadh2016 SET activites='$newact' WHERE id=$j";
	    	$reponse=$bdd->query($sql);
	    	if ($reponse) echo "......................C'est fait<br><br>";
	    }
	}
    $bdd=null;
echo "programme terminé<br>"

?>