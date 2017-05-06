<?php
	session_start();
    require_once("session.php");
	if (!$prenom) die();
	ob_implicit_flush(true);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Club MGEN</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="bibglobal0.css" type="text/css" rel="stylesheet" media="screen"/>
    <script src="fonctions.js"></script>
	<script type="text/javascript">
		function imprimlieu(lieu) {
			//document.getElementById('resu').innerHTML=lieu;
 			var formulaire = document.createElement('form');
			formulaire.setAttribute('target','_blank');
			formulaire.setAttribute('action','imprimPlanning.php');
			formulaire.setAttribute('method', 'post');
    		var input0 = document.createElement('input');
    		input0.setAttribute('type','hidden');input0.setAttribute('name','lieu');input0.setAttribute('value',lieu);
    		formulaire.appendChild(input0);
	   		document.body.appendChild(formulaire);
    		formulaire.submit();
   		}
	</script>
</head>
<body onload="resizemenu()" onresize="resizemenu()">
	<?php 
		include("menus.php");
		include("liOptions.php");
		include ("gract.inc");
		include("animateurs.inc");
		$temps=	["8h","8h15","8h30","8h45","9h","9h15","9h30","9h45","10h","10h15","10h30","10h45","11h","11h15","11h30","11h45","12h","12h15","12h30","12h45","13h",
			"13h15","13h30","13h45","14h","14h15","14h30","14h45","15h","15h15","15h30","15h45","16h","16h15","16h30","16h45","17h","17h15","17h30","17h45","18h"];
		$jour=["lundi","mardi","mercredi","jeudi","vendredi"];
		$jourm=["Lundi","Mardi","Mercredi","Jeudi","Vendredi"];
		$lieu = $_POST['lieu'];
		$ga = new Gracts;
		$ga->cree1($tact);
		$an = new Animateur;
		for ($i=0;$i<$ga->n;$i++) {
			$an->id = $ga->gract[$i]->idanimateur;
			$an->getani($tani);
			$ga->gract[$i]->animateur = $an->prenom." ".$an->nom;
		}

		function ecri($t,$d,$g){
			//echo $g->activite."   ".$g->debut." - ".$g->fin."   ".$d."   ";
			//if ($t) echo "trouve=TRUE<br>"; else echo "trouve=FALSE<br>";
		}

		function alieu($temps,$debut,$fin,$kk) {
			$d=array_search($debut,$temps);
			$f=array_search($fin,$temps);
			$rep = (($d<=$kk)&&($f>=$kk));
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
		class Cellule {
			public $colonne;
			public $texte="";
			public $bordure="";
			public $couleur="";
			public $k;

			public function ecris() {
				return "k=".$this->k."  colonne:".$this->colonne."  texte:".$this->texte."  bordure:".$this->bordure."  couleur:".$this->couleur;
			}
		}


		if ($lieu != "tous") {
			if (strpos($lieu,"alle")) $titre="Planning d'utilisation de la ".$lieu;
			else if (strpos($lieu,"ridge")) $titre="Planning d'utilisation de la salle de bridge";
			else if (strpos($lieu,"ymnase")) $titre="Planning d'utilisation du gymnase";
			else if (strpos($lieu,"oyer")) $titre="Planning d'utilisation du foyer";
		} else $titre="Planning d'occupation des locaux";
?>
		<div class='titre1'><?php echo $titre ?> </div>
		<button id="bouton1" class="bouton"  style="float:right;margin-right:10%" onclick="imprimlieu('<?php echo $lieu ?>')">IMPRIMER</button>
		<br>
		<br>
<?php
		$case = array();
		if ($lieu != "tous") {
			for ($i=0;$i<count($temps)-1;$i++) {
				for ($j=0;$j<count($jour);$j++) {
					$k=1;$trouve=false;
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
					if ($trouve) $ca->k=$k;else $ca->k=-$k;
					if ($trouve) {
						if ($ga->gract[$k]->debut == $temps[$i]) {$ca->bordure .="T";$ca->texte = $temps[$i]." - ".$ga->gract[$k]->fin;}
						if ($ga->gract[$k]->fin == $temps[$i+1]) {$ca->bordure .="B";/*$ca->texte = $temps[$i+1];*/}
						if (($trouve2)&&($ga->gract[$k2]->debut == $temps[$i])) {$ca->bordure .="T";$ca->texte = $temps[$i]." - ".$ga->gract[$k2]->fin;}
						$mid=milieu($temps,$ga->gract[$k]->debut,$ga->gract[$k]->fin);
						if ($mid-1==$i) $ca->texte=$ga->gract[$k]->activite;
						if ($mid==$i) $ca->texte="Groupe ".$ga->gract[$k]->groupe;
						if ($mid+1==$i) $ca->texte=$ga->gract[$k]->animateur;
						$ca->couleur="rose";
						if (($ga->gract[$k]->fin == $temps[$i])&&(!$trouve2)) $ca->couleur="gris";
						//if (!$trouve2) $ca->bordure="gris";
						//if (($ga->gract[$k]->fin == $temps[$i])&&($ga->gract[$k+5]->debut != $temps[$i+1])) $ca->couleur="gris";
					}
					array_push($case,$ca);
				}
			}

			//for ($i=0;$i<count($case);$i++) if ($case[$i]->colonne==1) {echo $i."  ";echo $case[$i]->ecris();echo "<br>";}

			$mes = "<table class='tablepart' style='width:90%;margin-right:20px;margin-left:20px'><tr><th>Lundi</th><th>Mardi</th><th>Mercredi</th><th>Jeudi</th><th>Vendredi</th></tr>";
			$k=0;$m=count($temps)-1;
			for ($i=0;$i<$m;$i++) {
				//$mes .= "<tr><td>".$case[$k]->texte."</td>";$k++;
				for ($j=0;$j<count($jour);$j++) {
					$st="";
					$co="bgcolor=\"#E8E8E8\"";
					if (!strpos($case[$k]->bordure,"T")) $st="border-top:none;";
					else $st="text-align:center;";
					if (!strpos($case[$k]->bordure,"B")&&($i<$m-1)) $st.="border-bottom:none;";
					//else $st.="text-align:center;";
					if ($case[$k]->couleur == "rose") $co="bgcolor=\"#F6C9F5\"";
 					if (strlen($st)>0) $mes .="<td ".$co." style='".$st."'>".$case[$k]->texte."</td>";
 					else $mes .="<td ".$co.">".$case[$k]->texte."</td>";
 					$k++;//echo $k."  ";
 				}
 				$mes .="</tr>";
 			}
			$mes .="</table>";
			echo $mes;

		} else {
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
						if ($ga->gract[$k]->id == 27) ecri($trouve,$demi,$ga->gract[$k]);
							if (!$trouve) $k++;
						}
						if ($trouve) {
							array_push($ks,$k);
							$k += 1;
							while (($k<$ga->n)&&(!$trouve2)) {
								$lieuOK = ($ga->gract[$k]->lieu == $lieux[$i]);
								if ($lieuOK) $jourOK = ($ga->gract[$k]->jour == $jour[$j]);
								if (($lieuOK)&&($jourOK)) $trouve2 = demijournee($temps,$ga->gract[$k]->debut,$demi);
						if ($ga->gract[$k]->id == 27) ecri($trouve2,$demi,$ga->gract[$k]);
								if (!$trouve2) $k++;
							}
						}
						if ($trouve2) {
							array_push($ks,$k);
							$k += 1;
							while (($k<$ga->n)&&(!$trouve3)) {
								$lieuOK = ($ga->gract[$k]->lieu == $lieux[$i]);
								if ($lieuOK) $jourOK = ($ga->gract[$k]->jour == $jour[$j]);
								if (($lieuOK)&&($jourOK)) $trouve3 = demijournee($temps,$ga->gract[$k]->debut,$demi);
						if ($ga->gract[$k]->id == 27) ecri($trouve3,$demi,$ga->gract[$k]);
								if (!$trouve3) $k++;
							}
						}
						if ($trouve3) {
							array_push($ks,$k);
							$k += 1;
							while (($k<$ga->n)&&(!$trouve4)) {
								$lieuOK = ($ga->gract[$k]->lieu == $lieux[$i]);
								if ($lieuOK) $jourOK = ($ga->gract[$k]->jour == $jour[$j]);
								if (($lieuOK)&&($jourOK)) $trouve4 = demijournee($temps,$ga->gract[$k]->debut,$demi);
						if ($ga->gract[$k]->id == 27) ecri($trouve4,$demi,$ga->gract[$k]);
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
						$ca->colonne=$j+1;
						$ca->bordure="LR";
						$ca->couleur="gris";
						$ca->texte="";
						if (count($ks)>0) {
							$ca->couleur="rose";
							for ($m=0;$m<count($ks);$m++) {
	$ca->texte .= $ga->gract[$ks[$m]]->activite." G".$ga->gract[$ks[$m]]->groupe." (".$ga->gract[$ks[$m]]->debut."-".$ga->gract[$ks[$m]]->fin.")";
								if ($m<count($ks)-1) $ca->texte .="<br>";
							}						
						}
						array_push($case,$ca);
					}
				}
			}
			$mes = "<table class='tablepart' style='width:180%;margin-right:20px;margin-left:20px'>";
			$mes .= "<tr><th  style='border-bottom-width: 3px;'>Jour/Salle</th>";
			for ($i=0;$i<count($lieux);$i++) $mes .= "<th  style='border-bottom-width: 3px;'>".$lieux[$i]."</th>";
			$mes .= "</tr>";
			$k=0;
			for ($j=0;$j<count($jour);$j++) {
				$mes .="<tr>";
				$mes .= "<td><br><span style='font-size:150%'>".$jourm[$j]."</span><br>matin<br></td>";
				for ($i=0;$i<count($lieux);$i++) {
					$mes .="<td>".$case[$k]->texte."</td>";$k++;
				}
				$mes .= "</tr>";
				$mes .= "</tr>";
				$mes .= "<td  style='border-bottom-width: 3px;'><br><span style='font-size:150%'>".$jourm[$j]."</span><br>après-midi<br></td>";
				for ($i=0;$i<count($lieux);$i++) {
					$mes .="<td style='border-bottom-width: 3px;'>".$case[$k]->texte."</td>";$k++;
				}
				$mes .= "</tr>";
			}

			$mes .="</table>";
			echo $mes;
		}
	?>
	<br>

</body>
</html>


