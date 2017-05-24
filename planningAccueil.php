<?php
    session_start();
    require_once("session.php");
    if (!$prenom) die();
    require_once("MGENconfig.php");
	$M = new MConf;
	$sql="SELECT * FROM $M->tablaut WHERE presence>0 ORDER BY presence";
	$reponse=$M->querydb($sql);
	$accueil=array();$presence=array();
	while ($donnees = $reponse->fetch()) {
		array_push($accueil,$donnees['prenom']." ".$donnees['nom']);
		array_push($presence,$donnees['presence']);
	}
	$M->close();

	function calaccueil($k,$presence,$accueil) {
		$pa=array();
		for ($i=0;$i<count($accueil);$i++) {
			if ($presence[$i]==$k) array_push($pa,$i);
		}
		$pac="";
		for ($i=0;$i<count($pa);$i++) {
			$pac .= utf8_decode($accueil[$pa[$i]]);
			if ($i != count($pa)-1) $pac .= " et ";
		}
		return $pac;
	} 
	require('../fpdf.php');
	$annee = strftime("%Y");
	$mois = strftime("%B");
	if(intval($mois)<8) $saison = strval(intval($annee)-1)."-".$annee;
	else $saison = $annee."-".strval(intval($annee)+1); 
	$pdf = new FPDF();
	$pdf->AddPage('L','A4');
	$pdf->SetFont('Times','I',10);
	$pdf->Cell(90,6,utf8_decode('Club des retraités de la MGEN section de Paris'),0,0,'L');
	$pdf->Cell(120,8,"Version ".$version,0,0,"C");
	$pdf->Cell(60,6,utf8_decode('Fiche imprimée le '.strftime("%d %B %Y")),0,1,'R');
	$pdf->Ln(4);
	$pdf->SetFont('Arial','B',18);
	$pdf->Cell(280,8,"PLANNING DE L'ACCUEIL ".$saison,0,1,'C');

	$pdf->Ln(4);
	$st=18;
	$sa=12;
	$pdf->SetFont('Arial','',$st);
	$pdf->Cell(30,14,"",1,0,'C');$pdf->Cell(120,14,"matin",1,0,'C');$pdf->Cell(120,14,utf8_decode("après-midi"),1,1,'C');
	$pdf->Cell(30,20,"Lundi",1,0,'L');
	$pdf->SetFont('Arial','',$sa);
	$pac = calaccueil(1,$presence,$accueil);$pdf->Cell(120,20,$pac,1,0,'C');
	$pac = calaccueil(2,$presence,$accueil);$pdf->Cell(120,20,$pac,1,1,'C');
	$pdf->SetFont('Arial','',$st);
	$pdf->Cell(30,20,"Mardi",1,0,'L');
	$pdf->SetFont('Arial','',$sa);
	$pac = calaccueil(3,$presence,$accueil);$pdf->Cell(120,20,$pac,1,0,'C');
	$pac = calaccueil(4,$presence,$accueil);$pdf->Cell(120,20,$pac,1,1,'C');
	$pdf->SetFont('Arial','',$st);
	$pdf->Cell(30,20,"Mercredi",1,0,'L');
	$pdf->SetFont('Arial','',$sa);
	$pac = calaccueil(5,$presence,$accueil);$pdf->Cell(120,20,$pac,1,0,'C');
	$pac = calaccueil(6,$presence,$accueil);$pdf->Cell(120,20,$pac,1,1,'C');
	$pdf->SetFont('Arial','',$st);
	$pdf->Cell(30,20,"Jeudi",1,0,'L');
	$pdf->SetFont('Arial','',$sa);
	$pac = calaccueil(7,$presence,$accueil);$pdf->Cell(120,20,$pac,1,0,'C');
	$pac = calaccueil(8,$presence,$accueil);$pdf->Cell(120,20,$pac,1,1,'C');
	$pdf->SetFont('Arial','',$st);
	$pdf->Cell(30,20,"Vendredi",1,0,'L');
	$pdf->SetFont('Arial','',$sa);
	$pac = calaccueil(9,$presence,$accueil);$pdf->Cell(120,20,$pac,1,0,'C');
	$pac = calaccueil(10,$presence,$accueil);$pdf->Cell(120,20,$pac,1,1,'C');
	$pdf->Output();

?>	
