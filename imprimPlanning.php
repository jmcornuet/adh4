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
	$jourm=["Lundi","Mardi","Mercredi","Jeudi","Vendredi"];
	$lieux=["Salle 15","Salle 16","Salle 17","Salle 18","Foyer","Bridge","Gymnase"];

	function ecri($t,$d,$g){
//		echo $g->activite."   ".$g->debut." - ".$g->fin."   ".$d."   ";
//		if ($t) echo "trouve=TRUE<br>"; else echo "trouve=FALSE<br>";
	}


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

	function demijournee($temps,$debut,$demi) {
		$d=array_search($debut,$temps);
		if ($demi==0) return ($d<18);
		if ($demi==1) return ($d>=18);
	}

	function fonte($pdf,$taille,$val){
              $pdf->SetFont('Arial','',$taille);
              return $pdf->Text(0,0,$val);
              }

	class Cellule {
		public $colonne;
		public $texte="";
		public $bordure="";
		public $couleur="";
		public $double;
	}
	$tempsutile = array();

	require('../fpdf.php');
	class PDF_Dash extends FPDF {
		function SetDash($black=null, $white=null) {
			if($black!==null) $s=sprintf('[%.3F %.3F] 0 d',$black*$this->k,$white*$this->k);
			else $s='[] 0 d';
			$this->_out($s);
		}
	}

	setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
	$annee = strftime("%Y");
	$mois = strftime("%B");
	if(intval($mois)<8) $saison = strval(intval($annee)-1)."-".$annee;
	else $saison = $annee."-".strval(intval($annee)+1); 
	$pdf = new PDF_Dash();
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
				$k2=$k+1;$trouve2=false;
				while (($k2<$ga->n)&&(!$trouve2)) {
					$lieuOK = ($ga->gract[$k2]->lieu == $lieu);
					if ($lieuOK) $jourOK = ($ga->gract[$k2]->jour == $jour[$j]);
					if (($lieuOK)&&($jourOK)) $trouve2 = (alieu($temps,$ga->gract[$k2]->debut,$ga->gract[$k2]->fin,$i));
					if (!$trouve2) $k2++;
				}

				$ca = new Cellule;
				$ca->colonne=$j+1;
				$ca->bordure="LR";
				$ca->couleur="gris";
				$ca->double=false;
				if ($trouve) {
					//echo $jour[$j]." ".$temps[$i]."    ".$ga->gract[$k]->activite."  groupe".$ga->gract[$k]->groupe."  ".$ga->gract[$k]->debut."-".$ga->gract[$k]->fin."<br>";
					if ($ga->gract[$k]->debut == $temps[$i]) {$ca->bordure .="T";$ca->texte = $temps[$i];}
					if ($ga->gract[$k]->fin == $temps[$i+1]) {$ca->bordure .="B";$ca->texte = $temps[$i+1];}
					$mid=milieu($temps,$ga->gract[$k]->debut,$ga->gract[$k]->fin);
					if ($mid-1==$i) $ca->texte=$ga->gract[$k]->activite." (".$ga->gract[$k]->groupe.")";
					//if ($mid==$i) $ca->texte="Groupe ".$ga->gract[$k]->groupe;
					$ca->couleur="rose";
					if (($ga->gract[$k]->fin == $temps[$i])&&(!$trouve2)) $ca->couleur="gris";
					$tu = true;
				}
				if ($trouve2) {
					if (($ga->gract[$k2]->debut == $temps[$i])&&($ga->gract[$k]->fin == $temps[$i])) {
						$ca->bordure .="T";$ca->texte = $temps[$i];
					} /*else {
						$ca->double=true;array_push($case,$ca);
						$ca = new Cellule;
						$ca->couleur="rose";
						$ca->bordure="LR";
						$ca->double=true;
						if ($ga->gract[$k2]->debut == $temps[$i]) {$ca->bordure .="T";$ca->texte = $temps[$i];}
						if ($ga->gract[$k2]->fin == $temps[$i+1]) {$ca->bordure .="B";$ca->texte = $temps[$i+1];}
						$mid=milieu($temps,$ga->gract[$k2]->debut,$ga->gract[$k2]->fin);
						if ($mid-1==$i) $ca->texte=$ga->gract[$k2]->activite." (".$ga->gract[$k2]->groupe.")";						
					}*/
				}
				array_push($case,$ca);
			}
			array_push($tempsutile,$tu);
		}
		$lastu=count($tempsutile)-1;while (!$tempsutile[$lastu]) {$lastu--;}
		if (strpos($lieu,"alle")) $titre="Planning d'occupation de la ".$lieu;
		else if (strpos($lieu,"ridge")) $titre="Planning d'occupation de la salle de bridge";
		else if (strpos($lieu,"ymnase")) $titre="Planning d'occupation du gymnase";
		else if (strpos($lieu,"oyer")) $titre="Planning d'occupation du foyer";
		$pdf->AddPage('L','A4');
		$pdf->SetFont('Times','I',10);
		$pdf->Cell(110,6,utf8_decode('Club des retraités de la MGEN section de Paris'),0,0,'L');
		$pdf->Cell(80,8,"Version ".$version,0,0,"L");
		$pdf->Cell(80,6,utf8_decode('Fiche imprimée le '.strftime("%d %B %Y")),0,1,'R');
		$pdf->SetFont('Arial','B',15);
		$pdf->Cell(50,12,"ANNEE ".$saison,0,0,'C');
		$pdf->Cell(200,12,$titre,0,1,'C');
		$pdf->SetFont('Arial','',10);

		$pdf->Cell(55,6,"Lundi",1,0,'C',false);
		$pdf->Cell(55,6,"Mardi",1,0,'C',false);
		$pdf->Cell(55,6,"Mercredi",1,0,'C',false);
		$pdf->Cell(55,6,"Jeudi",1,0,'C',false);
		$pdf->Cell(55,6,"Vendredi",1,1,'C',false);
		$pdf->Cell(55,6,"","LTR",0,'C');
		$pdf->Cell(55,6,"","LTR",0,'C');
		$pdf->Cell(55,6,"","LTR",0,'C');
		$pdf->Cell(55,6,"","LTR",0,'C');
		$pdf->Cell(55,6,"","LTR",1,'C');
		$k=0;$m=count($temps)-1;
		for ($i=0;$i<$m;$i++) {
			//$pdf->SetFont('Arial','',10);
			//$pdf->Cell(25,4,$case[$k]->texte,1,0,'L');
			$k++;
			for ($j=0;$j<count($jour);$j++) {
				if ($j<count($jour)-1) $l=0; else $l=1;
				if ($tempsutile[$i]) {
					if ($case[$k]->couleur=="gris") $pdf->SetFillColor(255,255,255); else $pdf->SetFillColor(200,200,200);
					if (strpos($case[$k]->bordure,"T")) {$pdf->SetFont('Arial','',8);$pdf->Cell(55,4,$case[$k]->texte,"LTR",$l,'L',true);}
					else if (strpos($case[$k]->bordure,"B")) {$pdf->SetFont('Arial','',8);$pdf->Cell(55,4,$case[$k]->texte,"LBR",$l,'L',true);}
					else if ($i<$lastu) {$pdf->SetFont('Arial','',10);$pdf->Cell(55,4,utf8_decode($case[$k]->texte),"LR",$l,'L',true);}
				}
				if ($i==$lastu) $pdf->Cell(55,4,'',"LBR",$l,'C');
 				$k++;//echo $k."  ";
 			}
 		}
	}else {
		$case=array();
		$lieux=["Salle 15","Salle 16","Salle 17","Salle 18","Foyer","Bridge","Gymnase"];
		for ($j=0;$j<count($jour);$j++) {
			for ($demi=0;$demi<2;$demi++) {
				for ($i=0;$i<count($lieux);$i++) {
					$ks=array();
					$k=1;$trouve=false;$trouve2=false;$trouve3=false;$trouve4=false;
					while (($k<$ga->n)&&(!$trouve)) {
						$lieuOK = ($ga->gract[$k]->lieu == $lieux[$i]);
						if ($lieuOK) $jourOK = ($ga->gract[$k]->jour == $jour[$j]);
						if (($lieuOK)&&($jourOK)) $trouve = demijournee($temps,$ga->gract[$k]->debut,$demi);
						if (!$trouve) $k++;
					}
					if ($trouve) {
						array_push($ks,$k);
						$k++;
						while (($k<$ga->n)&&(!$trouve2)) {
							$lieuOK = ($ga->gract[$k]->lieu == $lieux[$i]);
							if ($lieuOK) $jourOK = ($ga->gract[$k]->jour == $jour[$j]);
							if (($lieuOK)&&($jourOK)) $trouve2 = demijournee($temps,$ga->gract[$k]->debut,$demi);
							if (!$trouve2) $k++;
						}
					}
					if ($trouve2) {
						array_push($ks,$k);
						$k++;
						while (($k<$ga->n)&&(!$trouve3)) {
							$lieuOK = ($ga->gract[$k]->lieu == $lieux[$i]);
							if ($lieuOK) $jourOK = ($ga->gract[$k]->jour == $jour[$j]);
							if (($lieuOK)&&($jourOK)) $trouve3 = demijournee($temps,$ga->gract[$k]->debut,$demi);
							if (!$trouve3) $k++;
						}
					}
					if ($trouve3) {
						array_push($ks,$k);
						$k++;
						while (($k<$ga->n)&&(!$trouve4)) {
							$lieuOK = ($ga->gract[$k]->lieu == $lieux[$i]);
							if ($lieuOK) $jourOK = ($ga->gract[$k]->jour == $jour[$j]);
							if (($lieuOK)&&($jourOK)) $trouve4 = demijournee($temps,$ga->gract[$k]->debut,$ga->gract[$k]->fin,$demi);
							if (!$trouve4) $k++;
						}
					}
					if ($trouve4) array_push($ks,$k);
					$kt=array();
					for ($m=0;$m<count($ks);$m++) array_push($kt,array_search($ga->gract[$ks[$m]]->debut,$temps));
					//if (($j==0)&&($demi==1)) {print_r($ks);echo "<br>";print_r($kt);echo "<br>";}
					for ($m=0;$m<count($kt)-1;$m++) {
						for ($n=$m+1;$n<count($kt);$n++) {
							if ($kt[$m]>$kt[$n]) {
								$piv=$ks[$m];$ks[$m]=$ks[$n];$ks[$n]=$piv;
								$piv=$kt[$m];$kt[$m]=$kt[$n];$kt[$n]=$piv;
							}
						}
					}
					//if (($j==0)&&($demi==1)) {print_r($ks);echo "<br>";print_r($kt);echo "<br>";}
					$ca = new Cellule;
					$ca->texte="";
					$nks=count($ks);
					switch($nks) {
						case 0 :
							$ca->texte ="\n\n\n\n";
							break;
						case 1 :
							$ca->texte ="\n".$ga->gract[$ks[0]]->activite." G".$ga->gract[$ks[0]]->groupe." (".$ga->gract[$ks[0]]->debut."-".$ga->gract[$ks[0]]->fin.")\n\n\n";
							break;
						case 2 :
							$ca->texte ="\n".$ga->gract[$ks[0]]->activite." G".$ga->gract[$ks[0]]->groupe." (".$ga->gract[$ks[0]]->debut."-".$ga->gract[$ks[0]]->fin.")\n";
							$ca->texte .=$ga->gract[$ks[1]]->activite." G".$ga->gract[$ks[1]]->groupe." (".$ga->gract[$ks[1]]->debut."-".$ga->gract[$ks[1]]->fin.")\n\n";
							break;
						case 3 :
							$ca->texte =$ga->gract[$ks[0]]->activite." G".$ga->gract[$ks[0]]->groupe." (".$ga->gract[$ks[0]]->debut."-".$ga->gract[$ks[0]]->fin.")\n";
							$ca->texte .=$ga->gract[$ks[1]]->activite." G".$ga->gract[$ks[1]]->groupe." (".$ga->gract[$ks[1]]->debut."-".$ga->gract[$ks[1]]->fin.")\n";
							$ca->texte .=$ga->gract[$ks[2]]->activite." G".$ga->gract[$ks[2]]->groupe." (".$ga->gract[$ks[2]]->debut."-".$ga->gract[$ks[2]]->fin.")\n\n";
							break;
						case 4 :
							$ca->texte =$ga->gract[$ks[0]]->activite." G".$ga->gract[$ks[0]]->groupe." (".$ga->gract[$ks[0]]->debut."-".$ga->gract[$ks[0]]->fin.")\n";
							$ca->texte .=$ga->gract[$ks[1]]->activite." G".$ga->gract[$ks[1]]->groupe." (".$ga->gract[$ks[1]]->debut."-".$ga->gract[$ks[1]]->fin.")\n";
							$ca->texte .=$ga->gract[$ks[2]]->activite." G".$ga->gract[$ks[2]]->groupe." (".$ga->gract[$ks[2]]->debut."-".$ga->gract[$ks[2]]->fin.")\n";
							$ca->texte .=$ga->gract[$ks[3]]->activite." G".$ga->gract[$ks[3]]->groupe." (".$ga->gract[$ks[3]]->debut."-".$ga->gract[$ks[3]]->fin.")";
							break;


					}
					array_push($case,$ca);
				}
			}
		}
		$pdf->AddPage('L','A3');
		$pdf->SetFont('Times','I',10);
		$pdf->Cell(200,6,utf8_decode('Club des retraités de la MGEN section de Paris'),0,0,'L');
		$pdf->Cell(110,8,"Version ".$version,0,0,"L");
		$pdf->Cell(80,6,utf8_decode('Fiche imprimée le '.strftime("%d %B %Y")),0,1,'R');
		$pdf->SetFont('Arial','B',15);
		$pdf->Cell(50,12,"ANNEE ".$saison,0,0,'C');
		$pdf->Cell(340,12,"Planning d'occupation des locaux",0,1,'C');
		$pdf->SetFont('Arial','',12);

		$pdf->Cell(50,6,"Jour/Salle",1,0,'C');
		for ($i=0;$i<count($lieux)-1;$i++) $pdf->Cell(50,6,$lieux[$i],1,0,'C');$pdf->Cell(50,6,$lieux[$i],1,1,'C');
		$k=0;
		for ($j=0;$j<count($jour);$j++) {
		//matinées
			$pdf->SetFont('Arial','',18);
			$YY = $pdf->GetY();$XX = $pdf->GetX();
			$pdf->Cell(50,40,$jourm[$j],"LTR",0,'L');
			$pdf->SetXY($XX+18,$YY);
			$pdf->SetFont('Arial','',14);
			$pdf->Cell(32,20," matin",0,0,'L');
			$pdf->SetFont('Arial','',6);
			$YY = $pdf->GetY();
			$XX = $pdf->GetX();
			for ($i=0;$i<count($lieux)-1;$i++) {$pdf->MultiCell(50,5,utf8_decode($case[$k]->texte),"LTR");$k++;$pdf->SetXY($XX+($i+1)*50,$YY);}
			$pdf->MultiCell(50,5,utf8_decode($case[$k]->texte),"LTR");$k++;
			$YY = $pdf->GetY();
			$XX = $pdf->GetX();
			$pdf->SetDash(2,2); //2mm on, 2mm off
			$delta = strlen($jourm[$j])*3+3;
			$pdf->Line($XX+$delta,$YY,$XX+400,$YY);
			$pdf->SetDash();
		//après-midi
			$pdf->SetFont('Arial','',18);
			$YY = $pdf->GetY();$XX = $pdf->GetX();
			//$pdf->Cell(50,20,$jourm[$j],"LR",0,'L');
			$delta = strlen($jourm[$j])*3+3;
			$pdf->SetXY($XX+18,$YY);
			$pdf->SetFont('Arial','',14);
			$pdf->Cell(32,20,utf8_decode(" après-midi"),0,0,'L');

			$pdf->SetFont('Arial','',6);
			$YY = $pdf->GetY();
			$XX = $pdf->GetX();
			for ($i=0;$i<count($lieux)-1;$i++) {$pdf->MultiCell(50,5,utf8_decode($case[$k]->texte),"LR");$k++;$pdf->SetXY($XX+($i+1)*50,$YY);}
			$pdf->MultiCell(50,5,utf8_decode($case[$k]->texte),"LR");$k++;
			$YY = $pdf->GetY();
			$XX = $pdf->GetX();
			$pdf->SetLineWidth(0.6);
			$pdf->Line($XX,$YY,$XX+400,$YY);
			$pdf->SetLineWidth(0.2);			
		}
	}
	$pdf->Output();

?>