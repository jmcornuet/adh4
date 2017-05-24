<?php
    session_start();
    require_once("session.php");
    if (!$prenom) die();
	include("liOptions.php");
	include ("gract.inc");
	include ("adherents.inc");
	include("animateurs.inc");
	$version = $_SESSION['version']; 
	$codact = $_POST['activite'];//echo $iact."<br>";
	$grou = $_POST['groupe'];//echo $grou."<br>";
	$taille = $_POST['taille'];//echo $taille."<br>";
	$particip = $_POST['participation'];
	//echo $particip."<br>";
	//if ($particip==='avec') echo "avec participation";else echo "pas de participation";die("");
	$gra = new Gract;
	$gra->codactivite=$codact;
	$gra->groupe = $grou;
	$gra->getid($tact);
	$gra->getgract($tact);
	$resp = new Adherent;
	$resp->id = $gra->idresponsable;
	$resp->getadh($tadh);
	if (!$resp->prenomnom) $resp->prenomnom=$resp->prenom." ".$resp->nom;
	$an = new Animateur;
	$an->id = $gra->idanimateur;
	$an->getani($tani);
	//$reqP=$gra->codactivite."-".strval($grou)."-P";
	if ($gra->codactivite<10) $req = "%0".strval($gra->codactivite)."-".strval($grou)."%";
	else $req = "%".strval($gra->codactivite)."-".strval($grou)."%";
	$N = new MConf;
	$sql = "SELECT * FROM $tadh WHERE activites LIKE '$req' ORDER BY nom";
	$ad = new Adherents;
	$ad->cherche($sql,$tact);
	$nadh=0;$ncon=0;
	for ($i=0;$i<$ad->n;$i++) {
		if ($ad->adh[$i]->qualite=="M") $nadh++;
		else $ncon++;
	}

require('../fpdf.php');
	$annee = strftime("%Y");
	$mois = strftime("%B");
	if(intval($mois)<8) $saison = strval(intval($annee)-1)."-".$annee;
	else $saison = $annee."-".strval(intval($annee)+1); 
	$pdf = new FPDF();
	if ($taille == "Format A4") {
		$pdf->AddPage('L','A4');
		$pdf->SetFont('Times','I',10);
		$pdf->Cell(110,6,utf8_decode('Club des retraités de la MGEN section de Paris'),0,0,'L');
		//if ($particip==='avec') $pdf->Cell(80,8,"Participation",0,0);else $pdf->Cell(80,8,"Pas de participation",0,0);
		$pdf->Cell(80,8,"Version ".$version,0,0,"L");
		$pdf->Cell(80,6,utf8_decode('Fiche imprimée le '.strftime("%d %B %Y")),0,1,'R');
		$pdf->SetFont('Arial','B',15);
		$pdf->Cell(50,8,"ANNEE ".$saison,0,0,'C');
		$pdf->Cell(160,8,"",0,0);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(50,8,"Horaire : ".$gra->jour." (".$gra->debut." - ".$gra->fin.")",0,1,"L");
		$pdf->Cell(80,8,"Animateur : ".utf8_decode($an->prenom." ".$an->nom),0,0,"L");
		$pdf->Cell(130,8,"",0,0);
		$pdf->Cell(50,8,"Lieu : ".$gra->lieu,0,1,"L");
		$pdf->Cell(80,8,"Responsable : ".$resp->prenomnom,0,0,"L");
		$pdf->Cell(130,8,"",0,0);
		$pdf->Cell(50,8,"Participation Mutualistes : ".$nadh,0,1,"L");
		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(50,8,utf8_decode("Codes- P = Présent"),0,0,'L');
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(170,8,"",0,0);
		$pdf->Cell(50,8,"             Ayant-droit : ".$ncon,0,1,'L');
		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(17,8,"",0,0);
		$pdf->Cell(40,8,utf8_decode("A = Absent"),0,1,'L');

		$pdf->Ln(2);
		$pdf->SetFont('Arial','B',18);
		$pdf->Cell(50,8,"",0,0);
		$pdf->Cell(150,10,utf8_decode("LISTE DE PRESENCE - ACTIVITE ".strtoupper($gra->activite))."    Groupe ".$grou,0,0,'C');
		$pdf->Ln(12);
		$pdf->Ln(6);
		$pdf->SetFont('Arial','',12);
		$pdf->Cell(60,24,utf8_decode("NOM   Prénom"),1,0,'C');
		$pdf->Cell(20,24,utf8_decode("N° Club"),1,0,'C');
		if ($particip==='avec') {
			$pdf->Cell(24,24,"Participation",1,0,'C');
			for ($i=0;$i<13;$i++) $pdf->Cell(12,24,"",1,0,'C');
			$pdf->Cell(12,24,"",1,1,'C');			
			$pdf->SetLineWidth(0.2);
			$pdf->SetFont('Arial','',10);	
			for ($i=0;$i<$ad->n;$i++) {
				$nomprenom = $ad->adh[$i]->nom." ".$ad->adh[$i]->prenom;
				$pdf->Cell(60,8,utf8_decode($nomprenom),1,0,'L');
				$numMGEN=utf8_decode($ad->adh[$i]->numMGEN);
				if ($ad->adh[$i]->qualite=="M") $numMGEN.="M";
				else $numMGEN.="C";
				$pdf->Cell(20,8,$numMGEN,1,0,'C');
				$pdf->Cell(24,8,"",1,0,'C');
				for ($j=0;$j<13;$j++) $pdf->Cell(12,8,"",1,0,'C');
				$pdf->Cell(12,8,"",1,1,'C');			
			}
		} else {
			for ($i=0;$i<15;$i++) $pdf->Cell(12,24,"",1,0,'C');
			$pdf->Cell(12,24,"",1,1,'C');			
			$pdf->SetLineWidth(0.2);
			$pdf->SetFont('Arial','',10);	
			for ($i=0;$i<$ad->n;$i++) {
				$nomprenom = $ad->adh[$i]->nom." ".$ad->adh[$i]->prenom;
				$pdf->Cell(60,8,utf8_decode($nomprenom),1,0,'L');
				$numMGEN=utf8_decode($ad->adh[$i]->numMGEN);
				if ($ad->adh[$i]->qualite=="M") $numMGEN.="M";
				else $numMGEN.="C";
				$pdf->Cell(20,8,$numMGEN,1,0,'C');
				for ($j=0;$j<15;$j++) $pdf->Cell(12,8,"",1,0,'C');
				$pdf->Cell(12,8,"",1,1,'C');
			}
		}
	}
	if ($taille == "Format A3") {
		$pdf->AddPage('L','A3');
		$pdf->SetFont('Times','I',10);
		$pdf->Cell(210,6,utf8_decode('Club des retraités de la MGEN section de Paris'),0,0,'L');
		//if ($particip==='avec') $pdf->Cell(100,8,"Participation",0,0);else $pdf->Cell(100,8,"Pas de participation",0,0);
		//$pdf->Cell(100,8,"",0,0);
		$pdf->Cell(80,8,"Version ".$version,0,0,"L");
		$pdf->Cell(100,6,utf8_decode('Fiche imprimée le '.strftime("%d %B %Y")),0,1,'R');
		$pdf->SetFont('Arial','B',20);
		$pdf->Cell(50,8,"ANNEE ".$saison,0,0,'L');
		$pdf->Cell(260,8,"",0,0);
		$pdf->SetFont('Arial','',17);
		$pdf->Cell(50,8,"Horaire : ".$gra->jour." (".$gra->debut." - ".$gra->fin.")",0,1,"L");
		$pdf->Cell(80,8,"Animateur : ".utf8_decode($an->prenom." ".$an->nom),0,0,"L");
		$pdf->Cell(230,8,"",0,0);
		$pdf->Cell(50,8,"Lieu : ".$gra->lieu,0,1,"L");
		$pdf->Cell(80,8,"Responsable :",0,0,"L");
		$pdf->Cell(230,8,"",0,0);
		$pdf->Cell(50,8,"Participation Mutualistes : ".$nadh,0,1,"L");
		$pdf->SetFont('Arial','B',19);
		$pdf->Cell(50,8,utf8_decode("Codes- P = Présent"),0,0,'L');
		$pdf->SetFont('Arial','',17);
		$pdf->Cell(275,8,"",0,0);
		$pdf->Cell(50,8,"             Ayant-droit : ".$ncon,0,1,'L');
		$pdf->SetFont('Arial','B',19);
		$pdf->Cell(24,8,"",0,0);
		$pdf->Cell(40,8,utf8_decode("A = Absent"),0,1,'L');

		$pdf->Ln(2);
		$pdf->SetFont('Arial','B',23);
		$pdf->Cell(130,8,"",0,0);
		$pdf->Cell(150,10,utf8_decode("LISTE DE PRESENCE - ACTIVITE ".strtoupper($gra->activite))."    Groupe ".$grou,0,0,'C');
		$pdf->Ln(12);
		$pdf->Ln(6);
		$pdf->SetFont('Arial','',14);
		$pdf->Cell(60,24,utf8_decode("Nom   Prénom"),1,0,'C');
		$pdf->Cell(20,24,utf8_decode("N° Club"),1,0,'C');
		if ($particip==='avec') {
			$pdf->SetFont('Arial','',12);
			$pdf->Cell(24,24,"Participation",1,0,'C');
			for ($i=0;$i<23;$i++) $pdf->Cell(12,24,"",1,0,'C');
			$pdf->Cell(12,24,"",1,1,'C');			
			$pdf->SetLineWidth(0.2);
			$pdf->SetFont('Arial','',13);	
			for ($i=0;$i<$ad->n;$i++) {
				$nomprenom = $ad->adh[$i]->nom." ".$ad->adh[$i]->prenom;
				$pdf->Cell(60,8,utf8_decode($nomprenom),1,0,'L');
				$numMGEN=utf8_decode($ad->adh[$i]->numMGEN);
				if ($ad->adh[$i]->qualite=="M") $numMGEN.="M";
				else $numMGEN.="C";
				$pdf->Cell(20,8,$numMGEN,1,0,'C');
				$pdf->Cell(24,8,"",1,0,'C');
				for ($j=0;$j<23;$j++) $pdf->Cell(12,8,"",1,0,'C');
				$pdf->Cell(12,8,"",1,1,'C');			
			}
		} else {
			for ($i=0;$i<25;$i++) $pdf->Cell(12,24,"",1,0,'C');
			$pdf->Cell(12,24,"",1,1,'C');			
			$pdf->SetLineWidth(0.2);
			$pdf->SetFont('Arial','',13);	
			for ($i=0;$i<$ad->n;$i++) {
				$nomprenom = $ad->adh[$i]->nom." ".$ad->adh[$i]->prenom;
				$pdf->Cell(60,8,utf8_decode($nomprenom),1,0,'L');
				$numMGEN=utf8_decode($ad->adh[$i]->numMGEN);
				if ($ad->adh[$i]->qualite=="M") $numMGEN.="M";
				else $numMGEN.="C";
				$pdf->Cell(20,8,$numMGEN,1,0,'C');
				for ($j=0;$j<25;$j++) $pdf->Cell(12,8,"",1,0,'C');
				$pdf->Cell(12,8,"",1,1,'C');
			}
		}
	}
	$pdf->Output();

?>	
