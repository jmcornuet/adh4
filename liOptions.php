<?php
	require_once("MGENconfig.php");
	function arrayunique($a) {
		$b=array();
		for ($i=0;$i<count($a);$i++) {
			if ($i==0) array_push($b,$a[0]);
			else {
				$trouve=false;$j=0;
				while ((!$trouve)and($j<count($b))) {
					$trouve=($b[$j]==$a[$i]);
					if (!$trouve) $j++;
				}
				if (!$trouve) array_push($b,$a[$i]);
			}
		}
		return $b;
	}
	function despace($s) {
		$b="";
		for ($i=0;$i<strlen($s);$i++) {
			$c=substr($s,$i,1);
			if ($c == " ") $b .="_";
			else $b .=$c;
		}
		return $b;	 
	}

	function enspace($s) {
		$b="";
		for ($i=0;$i<strlen($s);$i++) {
			$c=substr($s,$i,1);
			if ($c == "_") $b .=" ";
			else $b .=$c;
		} 
		return $b;	 
	}

	function raz($a) {
		$e="Pas d'activité";
		$b=array();
		array_push($b,$e);
		for ($i=0;$i<count($a);$i++) if ($a[$i] != $e) array_push($b,$a[$i]);
		return $b;
	}

	$M = new MConf;
 	$sql = "SELECT * FROM $tact ORDER BY activite";
    $reponse=$M->querydb($sql);

//echo "avant recuperation des activites<br>";
    $activite=array();$codactivite=array();
    while($donnees = $reponse->fetch()) {
    	array_push($activite,$donnees['activite']);
    	array_push($codactivite,$donnees['codactivite']);
    }
//for($i=0;$i<count($activite);$i++) echo $activite[$i]." ";echo "<br>";
    $activite=arrayunique($activite);
//for($i=0;$i<count($activite);$i++) echo $activite[$i]." ";echo "<br>";
    $activite=raz($activite);
    $codactivite=arrayunique($codactivite);
	$optionsactivite="";
	for($i=0;$i<count($activite);$i++) {
		if (strlen($activite[$i])>2)
		$optionsactivite = $optionsactivite."<option value=$i>$activite[$i]</option>";
	}
 	$sql = "SELECT * FROM $tani ORDER BY nom";
    $reponse=$M->querydb($sql);
	$animateur=array();
    while($donnees = $reponse->fetch()) {
    	$np=$donnees['prenom']." ".$donnees['nom'];
    	array_push($animateur,$np);
    }
	$animateur=arrayunique($animateur);
    $M->close();
	$optionsanimateur="<option value=\"Animateur\">Animateur</option>";
	for($i=0;$i<count($animateur);$i++) {
		$optionsanimateur = $optionsanimateur."<option value=$i>$animateur[$i]</option>";
	}
	$profession=["profession","non renseignée","Ens. primaire","Ens. secondaire","Ens. sup ou recherche","Administration","divers (Educ. nat.)","médicale/paramédicale","Industrie","Commerce ou artisanat","libérale","Femme au foyer"];
	$optionsprofession="";
	for ($i=0;$i<count($profession);$i++) $optionsprofession = $optionsprofession."<option value=\"$profession[$i]\" >$profession[$i]</option>";
	$optionsgroupe="";
	for ($i=0;$i<16;$i++) $optionsgroupe = $optionsgroupe."<option value=$i>$i</option>";
	$optionstitre='<option value="Titre">Titre</option><option value="MME">Mme</option><option value="M.">M.</option>';
	$optionsqualite='<option value="Qualite">Qualité</option><option value="M">Mutualiste</option><option value="C">Conjoint</option>';
	$jour=["jour","lundi","mardi","mercredi","jeudi","vendredi","tous"];
	$optionsjour="";
	for ($i=0;$i<count($jour);$i++) $optionsjour = $optionsjour."<option value=\"$jour[$i]\" >$jour[$i]</option>";
	$lieu=["lieu","Salle 5","Salle 14","Salle 15","Salle 16","Salle 17","Salle 18","Gymnase","Bridge","Foyer","Extérieur"];
	$optionslieu="";
	for ($i=0;$i<count($lieu);$i++) $optionslieu = $optionslieu."<option value=\"$lieu[$i]\" >$lieu[$i]</option>";
	$debut=["début","8h","8h15","8h30","8h45","9h","9h15","9h30","9h45","10h","10h15","10h30","10h45","11h","11h15","11h30","11h45","12h","12h15","12h30","12h45","13h",
			"13h15","13h30","13h45","14h","14h15","14h30","14h45","15h","15h15","15h30","15h45","16h","16h15","16h30","16h45","17h","17h15","17h30","17h45","18h"];
	$optionsdebut="";
	for ($i=0;$i<count($debut);$i++) $optionsdebut = $optionsdebut."<option value=\"$debut[$i]\" >$debut[$i]</option>";
	$fin=["fin","8h","8h15","8h30","9h00","9h15","9h30","9h45","10h","10h15","10h30","10h45","11h","11h15","11h30","11h45","12h","12h15","12h30","12h45","13h",
			"13h15","13h30","13h45","14h","14h15","14h30","14h45","15h","15h15","15h30","15h45","16h","16h15","16h30","16h45","17h","17h15","17h30","17h45","18h"];
	$optionsfin="";
	for ($i=0;$i<count($fin);$i++) $optionsfin = $optionsfin."<option value=\"$fin[$i]\" >$fin[$i]</option>";
?>