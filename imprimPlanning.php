<?php
    session_start();
    require_once("session.php");
    if (!$prenom) die();
		include ("gract.inc");
		include("animateurs.inc");
    $lieu = $_POST['lieu'];
	$ga = new Gracts;
	$ga->cree1($tact);

	$temps=	["8h","8h15","8h30","8h45","9h","9h15","9h30","9h45","10h","10h15","10h30","10h45","11h","11h15","11h30","11h45","12h","12h15","12h30","12h45","13h",
		"13h15","13h30","13h45","14h","14h15","14h30","14h45","15h","15h15","15h30","15h45","16h","16h15","16h30","16h45","17h","17h15","17h30","17h45","18h"];
	$jour=["lundi","mardi","mercredi","jeudi","vendredi"];

	function alieu($temps,$debut,$fin,$k) {
		$d=array_search($debut,$temps);
		$f=array_search($fin,$temps);
		$rep = (($d<=$k)&&($f>=$k));
		return $rep;
	}

	function milieu($temps,$debut,$fin) {
		$d=array_search($debut,$temps);
		$f=array_search($fin,$temps);
		$m=0.5*($d+$f);
		return floor($m);			
	}

	class Cellule {
		public $colonne;
		public $texte="";
		public $bordure="";
	}
	$tempsutile = array();

	if ($lieu != "tous") {
		$case = array();
		for ($i=0;$i<count($temps)-1;$i++) {
			$tu = false;
			$ca = new Cellule;
			$ca->colonne=0;
			$ca->bordure="A";
			$ca->texte=$temps[$i];//."-".$temps[$i+1];
			array_push($case,$ca);
			for ($j=0;$j<count($jour);$j++) {
				$k=1;
				$trouve=false;
				while (($k<$ga->n)&&(!$trouve)) {
					$lieuOK = ($ga->gract[$k]->lieu == $lieu);
					if ($lieuOK) $jourOK = ($ga->gract[$k]->jour == $jour[$j]);
					if (($lieuOK)&&($jourOK)) $trouve = (alieu($temps,$ga->gract[$k]->debut,$ga->gract[$k]->fin,$i));
					if (!$trouve) $k++;
				}
				$ca = new Cellule;
				$ca->colonne=$j+1;
				$ca->bordure="LR";
				if ($trouve) {
					if ($ga->gract[$k]->debut == $temps[$i]) {$ca->bordure .="T";$ca->texte = $temps[$i];}
					if ($ga->gract[$k]->fin == $temps[$i+1]) {$ca->bordure .="B";$ca->texte = $temps[$i+1];}
					$mid=milieu($temps,$ga->gract[$k]->debut,$ga->gract[$k]->fin);
					if ($mid-1==$i) $ca->texte=$ga->gract[$k]->activite;
					if ($mid==$i) $ca->texte="Groupe ".$ga->gract[$k]->groupe;
					$tu = true;
				}
				array_push($case,$ca);
			}
			array_push($tempsutile,$tu);
		}
		$lastu=count($tempsutile)-1;while (!$tempsutile[$lastu]) {$lastu--;}
		if (strpos($lieu,"alle")) $titre="Planning d'utilisation de la ".$lieu;
		else if (strpos($lieu,"ridge")) $titre="Planning d'utilisation de la salle de bridge";
		else if (strpos($lieu,"ymnase")) $titre="Planning d'utilisation du gymnase";
		else if (strpos($lieu,"oyer")) $titre="Planning d'utilisation du foyer";
		require('../fpdf.php');
		setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
		$annee = strftime("%Y");
		$mois = strftime("%B");
		if(intval($mois)<8) $saison = strval(intval($annee)-1)."-".$annee;
		else $saison = $annee."-".strval(intval($annee)+1); 
		$pdf = new FPDF();
		$pdf->AddPage('L','A4');
		$pdf->SetFont('Times','I',10);
		$pdf->Cell(110,6,utf8_decode('Club des retraités de la MGEN section de Paris'),0,0,'L');
		//if ($particip==='avec') $pdf->Cell(80,8,"Participation",0,0);else $pdf->Cell(80,8,"Pas de participation",0,0);
		$pdf->Cell(80,8,"Version ".$version,0,0,"L");
		$pdf->Cell(80,6,utf8_decode('Fiche imprimée le '.strftime("%d %B %Y")),0,1,'R');
		$pdf->SetFont('Arial','B',15);
		$pdf->Cell(50,12,"ANNEE ".$saison,0,0,'C');
		$pdf->Cell(200,12,$titre,0,1,'C');
		$pdf->SetFont('Arial','',10);
		//$pdf->Cell(25,6,"Horaire",1,0,'C');
		$pdf->Cell(55,6,"Lundi",1,0,'C');
		$pdf->Cell(55,6,"Mardi",1,0,'C');
		$pdf->Cell(55,6,"Mercredi",1,0,'C');
		$pdf->Cell(55,6,"Jeudi",1,0,'C');
		$pdf->Cell(55,6,"Vendredi",1,1,'C');
		$k=0;$m=count($temps)-1;
		for ($i=0;$i<$m;$i++) {
			//$pdf->SetFont('Arial','',10);
			//$pdf->Cell(25,4,$case[$k]->texte,1,0,'L');
			$k++;
			for ($j=0;$j<count($jour);$j++) {
				if ($j<count($jour)-1) $l=0; else $l=1;
				//if ($tempsutile[$i]) {
					if (strpos($case[$k]->bordure,"T")) {$pdf->SetFont('Arial','',8);$pdf->Cell(55,4,$case[$k]->texte,"LTR",$l,'L');}
					else if (strpos($case[$k]->bordure,"B")) {$pdf->SetFont('Arial','',8);$pdf->Cell(55,4,$case[$k]->texte,"LBR",$l,'L');}
					else if ($i<$lastu) {$pdf->SetFont('Arial','',10);$pdf->Cell(55,4,utf8_decode($case[$k]->texte),"LR",$l,'L');}
				//}
				if ($i==$lastu) $pdf->Cell(55,4,'',"T",$l,'C');
 				$k++;//echo $k."  ";
 			}
 		}


		$pdf->Output();
	}
?>