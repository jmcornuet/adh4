<?php
	require_once("MGENconfig.php");
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

    function getoption($options,$n) {
        $a="=".strval($n).">";
        $b=substr($options,strpos($options,$a)+strlen($a));
        $c=substr($b,0,strpos($b,"<"));
        return $c;
    }
    if (PHP_OS == "Darwin") $basedir=""; else $basedir="/var/www/html/adh/"; 
	$optionsactiv=file_get_contents($basedir."listact.txt");
    $optionsactivite="<option value=0>Pas d'activité</option>".$optionsactiv;
    $optionspersonne=file_get_contents($basedir."listadh.txt");
    $optionsresponsable ="<option value=0>Responsable</option>".$optionspersonne;
    $optionsanim=file_get_contents($basedir."listani.txt");
	$optionsanimateur="<option value=0>Animateur</option>".$optionsanim;

	$profession=["profession","non renseignée","Ens. primaire","Ens. secondaire","Ens. sup ou recherche","Administration","divers (Educ. nat.)","médicale/paramédicale","Industrie","Commerce ou artisanat","libérale","Femme au foyer"];
	$optionsprofession="";
	for ($i=0;$i<count($profession);$i++) $optionsprofession = $optionsprofession."<option value=\"$profession[$i]\" >$profession[$i]</option>";
	$optionsgroupe="";
	for ($i=0;$i<16;$i++) $optionsgroupe = $optionsgroupe."<option value=$i>$i</option>";
	$optionsgroupe1="";
	for ($i=1;$i<16;$i++) $optionsgroupe1 = $optionsgroupe1."<option value=$i>$i</option>";

	$optionstitre='<option value="Titre">Titre</option><option value="MME">Mme</option><option value="M.">M.</option>';
	$optionsqualite='<option value="Qualite">Qualité</option><option value="M">Mutualiste</option><option value="C">Ayant droit</option>';
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
	//echo "fin de liOptions<br>";
?>