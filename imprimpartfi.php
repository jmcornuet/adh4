<?php
    session_start();
    require_once("session.php");
    if (!$prenom) die();
	include("liOptions.php");
	include ("gract.inc");
	$version = $_SESSION['version']; 
	$g = new Gracts;
	$sql = "SELECT * FROM $tact ORDER BY activite";
	$g->cherche($sql);
	$act=array();
	for ($i=0;$i<$g->n;$i++) {
		if ($g->gract[$i]->activite !== "Pas d'activité") {
			if (stristr($g->gract[$i]->activite,"informatique")) {
				array_push($act,"Informatique;".$g->gract[$i]->tarifA.";".$g->gract[$i]->tarifC);
			} else {
				array_push($act,$g->gract[$i]->activite.";".$g->gract[$i]->tarifA.";".$g->gract[$i]->tarifC);
		}
		}
	}
	$act=arrayunique($act);
require('../fpdf.php');
	$annee = strftime("%Y");
	$mois = strftime("%B");
	if(intval($mois)<8) $saison = strval(intval($annee)-1)."-".$annee;
	else $saison = $annee."-".strval(intval($annee)+1); 
	$pdf = new FPDF();
	$pdf->AddPage('P','A4');
	$pdf->SetFont('Times','I',10);
	$pdf->Cell(90,6,utf8_decode('Club des retraités de la MGEN section de Paris'),0,0,'L');
	$pdf->Cell(40,8,"Version ".$version,0,0,"L");
	$pdf->Cell(60,6,utf8_decode('Fiche imprimée le '.strftime("%d %B %Y")),0,1,'R');
	$pdf->Ln(4);
	$pdf->SetFont('Arial','B',18);
	$pdf->Cell(190,8,"PARTICIPATION FINANCIERE AUX ACTIVITES ".$saison,0,1,'C');
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(190,8,"ADHESION : 12 euros (Mutualiste) et 22 euros (Ayant-droit)",0,1,'C');

	$pdf->Ln(4);
	$pdf->SetFont('Arial','',10);
	$pdf->Cell(55,14,utf8_decode("Activité"),1,0,'C');
	$pdf->Cell(20,14,utf8_decode("Mutualiste"),1,0,'C');
	$pdf->Cell(20,14,utf8_decode("Ayant-droit"),1,0,'C');
	$pdf->Cell(55,14,utf8_decode("Activité"),1,0,'C');
	$pdf->Cell(20,14,utf8_decode("Mutualiste"),1,0,'C');
	$pdf->Cell(20,14,utf8_decode("Ayant-droit"),1,1,'C');
	$moitie = ceil(count($act)/2);

	$pdf->SetFont('Arial','',10);
	for ($i=0;$i<$moitie;$i++) {
		$a=explode(";",$act[$i]);
		$pdf->Cell(55,8,utf8_decode($a[0]),1,0,'L');
		$pdf->Cell(20,8,utf8_decode($a[1]." euros"),1,0,'L');
		$pdf->Cell(20,8,utf8_decode($a[2]." euros"),1,0,'L');
		if ($i+$moitie<count($act)) {
			$a=explode(";",$act[$i+$moitie]);
			$pdf->Cell(55,8,utf8_decode($a[0]),1,0,'L');
			$pdf->Cell(20,8,utf8_decode($a[1]." euros"),1,0,'L');
			$pdf->Cell(20,8,utf8_decode($a[2]." euros"),1,1,'L');
		} else {
			$pdf->Cell(55,8,"",1,0,'C');
			$pdf->Cell(20,8,"",1,0,'C');
			$pdf->Cell(20,8,"",1,1,'C');
		}
	}
	$pdf->Output();

?>	
