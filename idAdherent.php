<?php
    session_start();
    require_once("session.php");
    if (!$prenom) die();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Club MGEN</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="bibglobal0.css" type="text/css" rel="stylesheet" media="screen"/>
    <script src="fonctions.js"></script>

    <script>
		function SelectEmprunteur(obj) {
			obj.className="selection";
 			var elmt = document.getElementById(obj.id);
 			var formulaire = document.createElement('form');
    		formulaire.setAttribute('action', 'affichAdherent.php');
    		formulaire.setAttribute('method', 'post');
    		var input0 = document.createElement('input');
    		input0.setAttribute('type','hidden');input0.setAttribute('name','id');input0.setAttribute('value',elmt.childNodes[0].innerHTML);
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
		include("adherents.inc");
	?>
	<div class="titre1">Recherche d'un adhérent dans la base de données</div>
	<div class="resultat" id="res">
	<?php 
    $ad = new Adherent;
    $ad->getpost();
    $aa=[];
    $ad->activite1=getoption($optionsactivite,$ad->activite1);if ($ad->activite1 !="Pas d'activité") array_push($aa,$ad->activite1);
    $ad->activite2=getoption($optionsactivite,$ad->activite2);if ($ad->activite2 !="Pas d'activité") array_push($aa,$ad->activite2);
    $ad->activite3=getoption($optionsactivite,$ad->activite3);if ($ad->activite3 !="Pas d'activité") array_push($aa,$ad->activite3);
    $ad->activite4=getoption($optionsactivite,$ad->activite4);if ($ad->activite4 !="Pas d'activité") array_push($aa,$ad->activite4);
    $ad->activite5=getoption($optionsactivite,$ad->activite5);if ($ad->activite5 !="Pas d'activité") array_push($aa,$ad->activite5);
    $ad->activite6=getoption($optionsactivite,$ad->activite6);if ($ad->activite6 !="Pas d'activité") array_push($aa,$ad->activite6);
    $ad->getcodes($tact);
    //print_r($ad->activite1);echo "<br>";
    $act = explode("=",substr($ad->activites,1));
    if ($act[0]=="00") $act=[];
    else {
        $reg = $act;
        $crit = $reg;
        for ($i=0;$i<count($act);$i++) {
            $act[$i]="=".$act[$i];
            $crit[$i]=" (activité = ".$aa[$i];
            if (strstr($act[$i],"-0-")) {
                $reg[$i] = substr($act[$i],0,4).'([0-9]{1,2})';
                if (substr($act[$i],-1)!="-") $reg[$i].="-".substr($act[$i],-1);
            } else {
                $reg[$i] ='';
                $i1=strpos($act[$i], "-");$act1 = substr($act[$i],$i1+1,10);//echo '$act1 = '.$act1."<br>";
                if (strstr($act1,"-")) $act2 = substr($act1,0,strpos($act1,"-"));
                else $act2 = $act1;
                $crit[$i]=" (activite = ".$aa[$i]." groupe = ".$act2;
            }
            if (substr($act[$i],-1)=="P") $crit[$i] .=" participation réglée)";
            else if (substr($act[$i],-1)=="A") $crit[$i] .= " participation en attente)";
            else $crit[$i] .=")";
        }
    }
    //print_r($act);echo "<br>";
    //print_r($reg);echo "<br>";
    $critere="Critère(s) : ";
    $N = new MConf;
  	$mes0="SELECT * FROM $tadh WHERE";
      	$sql="";
      	if ($ad->titre!="Titre") {
            $sql = $mes0." titre='".$ad->titre."'";
            $critere .= " (titre = ".$ad->titre.")";
        }
        if (strlen($ad->nom)>0) {
        	if (strlen($sql)<1) $sql =$mes0." nom LIKE '%".addslashes($ad->nom)."%'";
        	else $sql = $sql." AND nom LIKE '%".addslashes($ad->nom)."%'";
            $critere .=" (nom contient ".$ad->nom.")";
        }
        if (strlen($ad->nomjf)>0) {
        	if (strlen($sql)<1) $sql =$mes0." nomjf LIKE '%".addslashes($ad->nomjf)."%'";
        	else $sql = $sql." AND nomjf LIKE '%".addslashes($ad->nomjf)."%'";
            $critere .=" (nom de jeune-fille contient ".$ad->nomjf.")";
        } 
        if (strlen($ad->prenom)>0) {
        	if (strlen($sql)<1) $sql =$mes0." prenom LIKE '%".addslashes($ad->prenom)."%'";
        	else $sql = $sql." AND prenom LIKE '%".addslashes($ad->prenom)."%'";
            $critere .=" (prénom contient ".$ad->prenom.")";
        }
        if (strlen($ad->compadresse)>0) {
        	if (strlen($sql)<1) $sql =$mes0." compadresse LIKE '%".addslashes($ad->compadresse)."%'";
        	else $sql = $sql." AND compadresse LIKE '%".addslashes($ad->compadresse)."%'";
            $critere .=" (complément d'adresse contient ".$ad->compadresse.")";
        }
        if (strlen($ad->adresse)>0) {
        	if (strlen($sql)<1) $sql =$mes0." adresse LIKE '%".addslashes($ad->adresse)."%'";
        	else $sql = $sql." AND adresse LIKE '%".addslashes($ad->adresse)."%'";
            $critere .=" (adresse contient ".$ad->adresse.")";

        }
        if (strlen($ad->codepostal)>0) {
        	if (strlen($sql)<1) $sql =$mes0." codepostal LIKE '%".$ad->codepostal."%'";
        	else $sql = $sql." AND codepostal LIKE '%".$ad->codepostal."%'";
            $critere .=" (code postal contient ".$ad->codepostal.")";
        }
        if (strlen($ad->ville)>0) {
        	if (strlen($sql)<1) $sql =$mes0." ville LIKE '%".addslashes($ad->ville)."%'";
        	else $sql = $sql." AND ville LIKE '%".addslashes($ad->ville)."%'";
            $critere .=" (ville contient ".$ad->ville.")";
        }
        if (($ad->qualite=="M")OR($ad->qualite=="C")) {
        	if (strlen($sql)<1) $sql =$mes0." qualite = '".$ad->qualite."'";
        	else $sql = $sql." AND qualite LIKE '%".$ad->qualite."%'";
            if ($ad->qualite=="M") $critere .=" (qualité = Mutualiste)";
            else $critere .= " (qualité = Ayant-droit)";
        }
        if (strlen($ad->portable)>0) {
        	if (strlen($sql)<1) $sql =$mes0." portable LIKE '%".$ad->portable."%'";
        	else $sql = $sql." AND portable LIKE '%".$ad->portable."%'";
            $critere .=" (portable contient ".$ad->portable.")";
        }
        if (strlen($ad->numeroSS)>0) {
        	if (strlen($sql)<1) $sql =$mes0." numeroSS LIKE '%".$ad->numeroSS."%'";
        	else $sql = $sql." AND numeroSS LIKE '%".$ad->numeroSS."%'";
            $critere .=" (numeroSS contient ".$ad->numeroSS.")";
        }
        if (strlen($ad->assurance)>0) {
        	if (strlen($sql)<1) $sql =$mes0." assurance LIKE '%".$ad->assurance."%'";
        	else $sql = $sql." AND assurance LIKE '%".$ad->assurance."%'";
            $critere .=" (assurance contient ".$ad->assurance.")";
        }
        if ($ad->profession!="profession") {
        	if (strlen($sql)<1) $sql =$mes0." profession = '".addslashes($ad->profession)."'";
        	else $sql = $sql." AND profession = '".addslashes($ad->profession)."'";
            $critere .=" (profession = ".$ad->profession.")";
        }
        if ($ad->specialite!="") {
            if (strlen($sql)<1) $sql =$mes0." specialite LIKE '%".addslashes($ad->specialite)."%'";
            else $sql = $sql." AND specialite LIKE '%".addslashes($ad->specialite)."%'";
            $critere .=" (specialite contient ".$ad->specialite.")";
        }
	    if (strlen($ad->numMGEN)>0) {
            if (strlen($sql)<1) $sql =$mes0." numMGEN = '".$ad->numMGEN."'";
            else $sql = $sql." AND numMGEN = '".$ad->numMGEN."'";
            $critere .=" (numéro MGEN = ".$ad->numMGEN.")";
       	}
        if (strlen($ad->courriel)>0) {
            if (strlen($sql)<1) $sql =$mes0." courriel LIKE '%".$ad->courriel."%'";
            else $sql = $sql." AND courriel LIKE '%".$ad->courriel."%'";
            $critere .=" (courriel contient = ".$ad->courriel.")";
       	}
        if (strlen($ad->telephone)>0) {
            if (strlen($sql)<1) $sql =$mes0." telephone LIKE '".$ad->telephone."%'";
            else $sql = $sql." AND telephone LIKE '%".$ad->telephone."%'";
            $critere .=" (téléphone contient ".$ad->telephone.")";
       	}
       	if ($ad->cotisation=='P') {
            if (strlen($sql)<1) $sql =$mes0." cotisation = '0'";
            else $sql = $sql." AND cotisation = '0'";
            $critere .=" (cotisation à jour)";
       	}
       	if ($ad->cotisation=='A') {
            if (strlen($sql)<1) $sql =$mes0." cotisation <> '0'";
            else $sql = $sql." AND cotisation <> '0'";
            $critere .=" (cotisation en attente)";
       	}
       	if (strlen($ad->premannee)>0) {
            if (strlen($sql)<1) $sql =$mes0." premannee = '".$ad->premannee."'";
            else $sql = $sql." AND premannee = '".$ad->premannee."'";
            $critere .=" (première adhésion en ".$ad->premannee.")";
       	}
        for ($i=0;$i<count($act);$i++) {
            //if ((strlen($act[$i])==4)and(substr($act[i],3,1)=="0")) $act[$i]=substr($act[$i],0,2);
            //" activites REGEXP($act[$i])";
            if ($reg[$i] =='') {
                if (strlen($sql)<1) $sql =$mes0." activites LIKE '%".$act[$i]."%'";
                else $sql = $sql." AND activites LIKE '%".$act[$i]."%'";
            } else {
                if (strlen($sql)<1) $sql =$mes0." activites REGEXP'".$reg[$i]."'";
                else $sql = $sql." AND activites REGEXP'".$reg[$i]."'";
            }
            $critere .= $crit[$i];
        }
        if (strlen($sql)<6) $sql="SELECT * FROM $tadh";
        $sql .=" ORDER BY nom";
        //echo $sql."<br>";//die();
    $add = new Adherents;
    $add->cherche($sql,$tact);
    $N = null;
    echo $critere."<br>";
    //echo $ad->n."</br>";
		if ($add->n<1) echo "</br></br><div class='alerte'>Aucune fiche trouvée</div>";
		else if ($add->n>1) {
			echo "<div class='alerte'>$add->n fiches trouvées</div></br>";
			$mes ='<div id="divConteneur"> <table style="width:80%"><tr><th>ID</th><th>Nom</th><th>Prénom</th><th>N° MGEN</th><th>Téléphone</th><th>courriel</th></tr>';
    		for ($i=0;$i<$add->n;$i++) {
				$idligne=strval($i);
				if ($add->adh[$i]->cotisation=="0") {
       				$mes =$mes.'<tr id='.$idligne.' class="defaut" onclick="SelectEmprunteur(this)">';
    				$mes =$mes.'<td class="defaut">'.$add->adh[$i]->id.'</td>';
    				$mes =$mes.'<td class="defaut" style="text-align:left">'.$add->adh[$i]->nom.'</td>';
    				$mes =$mes.'<td class="defaut" style="text-align:left">'.$add->adh[$i]->prenom.'</td>';
    				$mes =$mes.'<td class="defaut">'.$add->adh[$i]->numMGEN.'</td>';
    				$mes =$mes.'<td class="defaut">'.$add->adh[$i]->telephone.'</td>';
    				$mes =$mes.'<td class="defaut">'.$add->adh[$i]->courriel.'</td>';
    				$mes =$mes.'</tr>';
				} else {
       				$mes =$mes.'<tr id='.$idligne.' class="emprunt" onclick="SelectEmprunteur(this)">';
            $mes =$mes.'<td class="emprunt">'.$add->adh[$i]->id.'</td>';
            $mes =$mes.'<td class="emprunt">'.$add->adh[$i]->nom.'</td>';
            $mes =$mes.'<td class="emprunt">'.$add->adh[$i]->prenom.'</td>';
            $mes =$mes.'<td class="emprunt">'.$add->adh[$i]->numMGEN.'</td>';
            $mes =$mes.'<td class="emprunt">'.$add->adh[$i]->telephone.'</td>';
            $mes =$mes.'<td class="emprunt">'.$add->adh[$i]->courriel.'</td>';
    				$mes =$mes.'</tr>';       					
				}
			}
			$mes =$mes.'</table></div>';
			echo $mes;
		} 
		else {
			$mes  = '<form name="formadherent" method="post" action="affichAdherent.php">';
			$mes = $mes.'<input type="hidden" name="id" value='.$add->adh[0]->id.' >';
			$mes = $mes.'</form>';
			$mes = $mes.'<script type="text/javascript">document.formadherent.submit();</script>';
			echo $mes;

		} 
		?>
	 </div>
	<div id="sortie"></div>
</body>
</html>
