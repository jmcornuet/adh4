<?php
    session_start();
    require_once("session.php");
    if (!$prenom) die();

	include("adherents.inc");
    $ad = new Adherent;
    $ad->id = $_POST['id'];
    $ad->getadh();
    $ad->getactivites();
	function transprenom($p) {
		$fp=explode(" ",$p);
		for ($j=0;$j<count($fp);$j++) {
			$p=strtolower($fp[$j]);
			$dp=explode("-",$p);
			for ($i=0;$i<count($dp);$i++) {$a=substr($dp[$i],0,1);$b=substr($dp[$i],1,100);$a=strtoupper($a);$dp[$i]=$a.$b;}
			$fp[$j]=implode("-",$dp);
		}
		$p=implode(" ",$fp);
		return $p;
	}
require('../fpdf.php');
	setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
	$pdf = new FPDF();
	$pdf->AddPage('P','A5');
	$pdf->SetFont('Times','I',10);
	$pdf->Cell(130,6,utf8_decode('Club des retraités de la MGEN section de Paris'),0,1,'C');

	if($_POST['forme']=="Simple") {
		$pdf->Cell(100,6,utf8_decode('Fiche simple imprimée le '.strftime("%d %B %Y")),0,1,'');		
		$ad->nom = strtoupper($ad->nom);
		$ad->prenom =transprenom($ad->prenom);
		if ($ad->qualite=="M") $ad->numMGEN =$ad->numMGEN."A"; else $ad->numMGEN =$ad->numMGEN."C"; 
		$pdf->SetFont('Arial','B',20);
		$pdf->Ln(16);
		$pdf->Cell(100,10,utf8_decode($nom." ".$prenom));
		$pdf->Cell(30,10,$ad->numMGEN,1,0,'C');
		$pdf->Ln(16);
		$pdf->SetFont('Arial','',14);
		$pdf->Cell(100,6,utf8_decode($ad->adresse),0,1);
		$adresse = $ad->codepostal."  ".$ad->ville;
		$pdf->Cell(100,6,$adresse,0,1);
		$pdf->Ln(10);
		$pdf->Cell(50,6,utf8_decode("Téléphone fixe : "),0,0);
		$pdf->Cell(50,6,$ad->telephone,0,1);
		$pdf->Cell(50,6,utf8_decode("Téléphone portable : "),0,0);
		$pdf->Cell(50,6,$ad->portable,0,1);
		$pdf->Cell(50,6,"Courriel : ");
		$pdf->SetFont('Times','I',14);
		$pdf->Cell(80,6,$ad->courriel,0,1);
		$pdf->Cell(100,10,"  ",0,1);
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(50,10,"ACTIVITES",0,0);
		$pdf->Ln(10);
		$pdf->SetFont('Arial','',14);
		if ($ad->activite1 != "Pas d'activité") $pdf->Cell(100,10,utf8_decode($ad->activite1),0,1);
		if ($ad->activite2 != "Pas d'activité") $pdf->Cell(100,10,utf8_decode($ad->activite2),0,1);
		if ($ad->activite3 != "Pas d'activité") $pdf->Cell(100,10,utf8_decode($ad->activite3),0,1);
		if ($ad->activite4 != "Pas d'activité") $pdf->Cell(100,10,utf8_decode($ad->activite4),0,1);
		if ($ad->activite5 != "Pas d'activité") $pdf->Cell(100,10,utf8_decode($ad->activite5),0,1);
		if ($ad->activite6 != "Pas d'activité") $pdf->Cell(100,10,utf8_decode($ad->activite6),0,1);

	}
	if($_POST['forme']=="Complet") {
		$pdf->Cell(100,6,utf8_decode('Fiche complète imprimée le '.strftime("%d %B %Y")),0,1,'');		
		$nom = strtoupper($ad->nom);
		$prenom =transprenom($ad->prenom);
		$numMGEN = $ad->numMGEN;
		if ($ad->qualite=="M") $numMGEN =$numMGEN."A"; else $numMGEN =$numMGEN."C"; 
		$pdf->Ln(20);
		$pdf->SetFont('Arial','B',15);
		$pdf->Cell(100,10,utf8_decode($nom." ".$prenom));
		$pdf->Cell(30,10,$ad->numMGEN,1,1,'C');
		$pdf->SetFont('Arial','',12);
		if (strlen($ad->nomjf)>0) {
		$pdf->Cell(100,6,utf8_decode("née ".$ad->nomjf),0,1);	
		} else { $pdf->Cell(100,6,' ',0,1);}

		$pdf->Ln(10);
		$pdf->Cell(50,6,utf8_decode("Adresse : "),0,0);
		$pdf->Cell(50,6,utf8_decode($ad->adresse),0,1);
		$adresse = $ad->codepostal."  ".$ad->ville;
		$pdf->Cell(50,6,utf8_decode(" "),0,0);
		$pdf->Cell(50,6,$adresse,0,1);
		$pdf->Cell(50,6,utf8_decode("Téléphone fixe : "),0,0);
		$pdf->Cell(50,6,$ad->telephone,0,1);
		$pdf->Cell(50,6,utf8_decode("Téléphone portable : "),0,0);
		$pdf->Cell(50,6,$ad->portable,0,1);
		$pdf->Cell(50,6,"Courriel : ");
		$pdf->SetFont('Times','I',14);
		$pdf->Cell(80,6,$ad->courriel,0,1);
		$pdf->Cell(100,6,'  ',0,1);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(50,6,utf8_decode("Profession : "),0,0);
		$pdf->Cell(50,6,$ad->profession,0,1);
		$pdf->Cell(50,6,utf8_decode("Numéro SS : "),0,0);
		$pdf->Cell(50,6,$ad->numeroSS,0,1);
		$pdf->Cell(50,6,utf8_decode("Assurance : "),0,0);
		$pdf->Cell(50,6,$ad->assurance,0,1);
		$pdf->Cell(50,6,utf8_decode("Première inscription : "),0,0);
		$pdf->Cell(50,6,$ad->premannee,0,1);
		$pdf->Cell(100,6,"  ",0,1);
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(50,10,"ACTIVITES 2016-2017",0,0);
		$pdf->Ln(10);
		$pdf->SetFont('Arial','',14);
		if ($ad->activite1 != "Pas d'activité") $pdf->Cell(100,10,utf8_decode($ad->activite1),0,1);
		if ($ad->activite2 != "Pas d'activité") $pdf->Cell(100,10,utf8_decode($ad->activite2),0,1);
		if ($ad->activite3 != "Pas d'activité") $pdf->Cell(100,10,utf8_decode($ad->activite3),0,1);
		if ($ad->activite4 != "Pas d'activité") $pdf->Cell(100,10,utf8_decode($ad->activite4),0,1);
		if ($ad->activite5 != "Pas d'activité") $pdf->Cell(100,10,utf8_decode($ad->activite5),0,1);
		if ($ad->activite6 != "Pas d'activité") $pdf->Cell(100,10,utf8_decode($ad->activite6),0,1);
	}
	$pdf->Output();
?>
