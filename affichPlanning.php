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
		$lieu = $_POST['lieu'];
		$ga = new Gracts;
		$ga->cree1($tact);
		$an = new Animateur;
		for ($i=0;$i<$ga->n;$i++) {
			$an->id = $ga->gract[$i]->idanimateur;
			$an->getani($tani);
			$ga->gract[$i]->animateur = $an->prenom." ".$an->nom;
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

		class Cellule {
			public $colonne;
			public $texte="";
			public $bordure="";
			public $couleur="";
		}


		if ($lieu != "tous") {
			if (strpos($lieu,"alle")) $titre="Planning d'utilisation de la ".$lieu;
			else if (strpos($lieu,"ridge")) $titre="Planning d'utilisation de la salle de bridge";
			else if (strpos($lieu,"ymnase")) $titre="Planning d'utilisation du gymnase";
			else if (strpos($lieu,"oyer")) $titre="Planning d'utilisation du foyer";
		} else $titre="Planning général d'utilisation des locaux";
?>
		<div class='titre1'><?php echo $titre ?> </div>
<?php
		if ($lieu != "tous") {
			$case = array();
			for ($i=0;$i<count($temps)-1;$i++) {
				/*$ca = new Cellule;
				$ca->colonne=0;
				$ca->bordure="A";
				$ca->texte=$temps[$i];//."-".$temps[$i+1];
				array_push($case,$ca);*/
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
					$ca->couleur="gris";
					if ($trouve) {
						if ($ga->gract[$k]->debut == $temps[$i]) {$ca->bordure .="T";$ca->texte = $temps[$i]." - ".$ga->gract[$k]->fin;}
						if ($ga->gract[$k]->fin == $temps[$i+1]) {$ca->bordure .="B";/*$ca->texte = $temps[$i+1];*/}
						$mid=milieu($temps,$ga->gract[$k]->debut,$ga->gract[$k]->fin);
						if ($mid-1==$i) $ca->texte=$ga->gract[$k]->activite;
						if ($mid==$i) $ca->texte="Groupe ".$ga->gract[$k]->groupe;
						if ($mid+1==$i) $ca->texte=$ga->gract[$k]->animateur;
						$ca->couleur="rose";
						if ($ga->gract[$k]->fin == $temps[$i]) $ca->couleur="gris";
					}
					array_push($case,$ca);
				}
			}
?>
		<button id="bouton1" class="bouton"  style="float:right;margin-right:10%" onclick="imprimlieu('<?php echo $lieu ?>')">IMPRIMER</button>
		<br>
		<br>
<?php
			$mes = "<table class='tablepart' style='margin-right:20px;margin-left:20px'><tr><th>Lundi</th><th>Mardi</th><th>Mercredi</th><th>Jeudi</th><th>Vendredi</th></tr>";
			$k=0;$m=count($temps)-1;
			for ($i=0;$i<$m;$i++) {
				//$mes .= "<tr><td>".$case[$k]->texte."</td>";$k++;
				for ($j=0;$j<count($jour);$j++) {
					$st="";
					$co="bgcolor=\"#E8E8E8\"";
					if (!strpos($case[$k]->bordure,"T")) $st="border-top:none;";
					else $st="text-align:center;";
					if (!strpos($case[$k]->bordure,"B")&&($i<$m-1)) $st.="border-bottom:none;";
					else $st.="text-align:center;";
					if ($case[$k]->couleur == "rose") $co="bgcolor=\"#F6C9F5\"";
 					if (strlen($st)>0) $mes .="<td ".$co." style='".$st."'>".$case[$k]->texte."</td>";
 					else $mes .="<td ".$co.">".$case[$k]->texte."</td>";
 					$k++;//echo $k."  ";
 				}
 				$mes .="</tr>";
 			}
			$mes .="</table>";
			echo $mes;

		}
	?>
	<br>

</body>
</html>


