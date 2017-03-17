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
	</br>
	<div class="titre1">Recherche d'un adhérent dans la base de données</div></br>
	<div class="resultat" id="res">
	<?php 
    $ad = new Adherent;
    $ad->getpost();
    $ad->activite1=$activite[intval($ad->activite1)];$ad->activite2=$activite[intval($ad->activite2)];$ad->activite3=$activite[intval($ad->activite3)];
    $ad->activite4=$activite[intval($ad->activite4)];$ad->activite5=$activite[intval($ad->activite5)];$ad->activite6=$activite[intval($ad->activite6)];
    $ad->getcodes($tact);
    $act = explode(";",substr($ad->activites,1));
    $N = new MConf;
    if ($act[0]=="00") array_shift($act);
  		   $mes0="SELECT * FROM $tadh WHERE";
      	$sql="";
      	if ($ad->titre!="Titre") $sql = $mes0." titre='".$ad->titre."'";
        if (strlen($ad->nom)>0) {
        	if (strlen($sql)<1) $sql =$mes0." nom LIKE '%".addslashes($ad->nom)."%'";
        	else $sql = $sql." AND nom LIKE '%".addslashes($ad->nom)."%'";
        }
        if (strlen($ad->nomjf)>0) {
        	if (strlen($sql)<1) $sql =$mes0." nomjf LIKE '%".addslashes($ad->nomjf)."%'";
        	else $sql = $sql." AND nomjf LIKE '%".addslashes($ad->nomjf)."%'";
        } 
        if (strlen($ad->prenom)>0) {
        	if (strlen($sql)<1) $sql =$mes0." prenom LIKE '%".addslashes($ad->prenom)."%'";
        	else $sql = $sql." AND prenom LIKE '%".addslashes($ad->prenom)."%'";
        }
        if (strlen($ad->compadresse)>0) {
        	if (strlen($sql)<1) $sql =$mes0." compadresse LIKE '%".addslashes($ad->compadresse)."%'";
        	else $sql = $sql." AND compadresse LIKE '%".addslashes($ad->compadresse)."%'";
        }
        if (strlen($ad->adresse)>0) {
        	if (strlen($sql)<1) $sql =$mes0." adresse LIKE '%".addslashes($ad->adresse)."%'";
        	else $sql = $sql." AND adresse LIKE '%".addslashes($ad->adresse)."%'";
        }
        if (strlen($ad->codepostal)>0) {
        	if (strlen($sql)<1) $sql =$mes0." codepostal LIKE '%".$ad->codepostal."%'";
        	else $sql = $sql." AND codepostal LIKE '%".$ad->codepostal."%'";
        }
        if (strlen($ad->ville)>0) {
        	if (strlen($sql)<1) $sql =$mes0." ville LIKE '%".addslashes($ad->ville)."%'";
        	else $sql = $sql." AND ville LIKE '%".addslashes($ad->ville)."%'";
        }
        if (($ad->qualite=="MME")OR($ad->qualite=="M.")) {
        	if (strlen($sql)<1) $sql =$mes0." qualite = '".$ad->qualite."'";
        	else $sql = $sql." AND qualite LIKE '".$ad->qualite."'";
        }
        if (strlen($ad->portable)>0) {
        	if (strlen($sql)<1) $sql =$mes0." portable LIKE '%".$ad->portable."%'";
        	else $sql = $sql." AND portable LIKE '%".$ad->portable."%'";
        }
        if (strlen($ad->numeroSS)>0) {
        	if (strlen($sql)<1) $sql =$mes0." numeroSS LIKE '%".$ad->numeroSS."%'";
        	else $sql = $sql." AND numeroSS LIKE '%".$ad->numeroSS."%'";
        }
        if (strlen($ad->assurance)>0) {
        	if (strlen($sql)<1) $sql =$mes0." assurance LIKE '%".$ad->assurance."%'";
        	else $sql = $sql." AND assurance LIKE '%".$ad->assurance."%'";
        }
        if ($ad->profession!="profession") {
        	if (strlen($sql)<1) $sql =$mes0." profession = '".addslashes($ad->profession)."'";
        	else $sql = $sql." AND profession LIKE '%".addslashes($ad->profession)."%'";
        }
	    if (strlen($ad->numMGEN)>0) {
            if (strlen($sql)<1) $sql =$mes0." numMGEN = '".$ad->numMGEN."'";
            else $sql = $sql." AND numMGEN = '".$ad->numMGEN."'";
       	}
        if (strlen($ad->courriel)>0) {
            if (strlen($sql)<1) $sql =$mes0." courriel LIKE '%".$ad->courriel."%'";
            else $sql = $sql." AND courriel LIKE '%".$ad->courriel."%'";
       	}
        if (strlen($ad->telephone)>0) {
            if (strlen($sql)<1) $sql =$mes0." telephone LIKE '".$ad->telephone."%'";
            else $sql = $sql." AND telephone LIKE '".$ad->telephone."%'";
       	}
       	if ($ad->cotisation=='P') {
            if (strlen($sql)<1) $sql =$mes0." cotisation = '0'";
            else $sql = $sql." AND cotisation = '0'";
       	}
       	if ($ad->cotisation=='A') {
            if (strlen($sql)<1) $sql =$mes0." cotisation <> '0'";
            else $sql = $sql." AND cotisation <> '0'";
       	}
       	if (strlen($ad->premannee)>0) {
            if (strlen($sql)<1) $sql =$mes0." premannee = '".$ad->premannee."'";
            else $sql = $sql." AND premannee = '".$ad->premannee."'";
       	}
        for ($i=0;$i<count($act);$i++) {
            if ((strlen($act[$i])==4)and(substr($act[i],3,1)=="0")) $act[$i]=substr($act[$i],0,2);
            if (strlen($sql)<1) $sql =$mes0." activites LIKE '%".$act[$i]."%'";
            else $sql = $sql." AND activites LIKE '%".$act[$i]."%'";
        }
        if (strlen($sql)<6) $sql="SELECT * FROM $tadh";
        $sql .=" ORDER BY nom";
        //echo $sql."<br>";
    $add = new Adherents;
    $add->cherche($sql,$tact);
    $N = null;
    echo $ad->n."</br>";
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
