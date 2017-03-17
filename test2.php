<?php
	//include("dbf.php");
	include("liOptions.php");
/*	$ff = fopen("act.lst","r");
	$act = array();
	while (!feof($ff)) {$a= utf8_encode(fgets($ff));array_push($act,trim($a));} 
	fclose($ff);
	$code=array();
	$alphabet=["B","C","D","E","F","G"];
	$chiffres=["0","1","2","3","4","5","6","7","8","9"];
	array_push($code,"A0");array_push($code,"B0");
	for ($i=2;$i<count($act);$i++) {
		$lettre=substr($code[$i-1],0,1);$il=array_search($lettre, $alphabet);
		$chiffre=substr($code[$i-1],1,1);$ic=array_search($chiffre,$chiffres);
		if ($chiffre == "9") $code[$i] = $alphabet[$il+1]."0";
		else $code[$i] = $alphabet[$il].$chiffres[$ic+1];
	}
	//for ($i=1;$i<count($act);$i++) echo $code[$i]."   ".$act[$i]."\n";

	$db = new Dbf;
	$db->openread("fichclub.dbf");
	$db->readheader();
	echo $db->nenr." enregistrements de ".$db->tenr." octets \n";
	$db->readcol();
	for ($i=0;$i<count($db->nomcol);$i++) echo $db->nomcol[$i]."  ".$db->typcol[$i]."(".$db->loncol[$i].")\n";
	$db->readenr();
	$db->close();
*/	echo "\nfin de la lecture des enregistrements\n";
//	echo "nombre d'activites = ".count($activite)."\n";
/*	for ($i=0;$i<$db->nenr;$i++) {
		$c=$db->ad->adh[$i]->activites;echo $c."  "; 
		$m=strlen($c)/2;$i0=0;$aa="";
		for ($j=0;$j<$m;$j++) {
			$a = substr($c,$i0,2);$i0 +=2;
			$i1=array_search($a,$code);
			if($i1) {
				$k=array_search($act[$i1],$activite);
			}  
			$aa.=";".$codactivite[$k]."-1-P";
		}
		$db->adh[$i]->activites = $aa;echo $aa."\n";

	}
*/
	echo "fin\n";
?>