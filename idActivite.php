<?php
    session_start();
    require_once("session.php");
    if (!$prenom) die();
?>

<!DOCTYPE html>
<html>
<head>
    <title>club MGEN</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="bibglobal0.css" type="text/css" rel="stylesheet" media="screen"/>
    <script src="fonctions.js"></script>

    <script>
		function SelectGract(idac) {
 			var formulaire = document.createElement('form');
    		formulaire.setAttribute('action', 'affichGract.php');
    		formulaire.setAttribute('method', 'post');
    		var input0 = document.createElement('input');
    		input0.setAttribute('type','hidden');input0.setAttribute('name','id');input0.setAttribute('value',idac);
    		formulaire.appendChild(input0);
	   		document.body.appendChild(formulaire);
    		formulaire.submit();
		}
    function SelectAnimateur(idan) {
      var formulaire = document.createElement('form');
        formulaire.setAttribute('action', 'affichAnimateur.php');
        formulaire.setAttribute('method', 'post');
        var input0 = document.createElement('input');
        input0.setAttribute('type','hidden');input0.setAttribute('name','id');input0.setAttribute('value',idan);
        formulaire.appendChild(input0);
        document.body.appendChild(formulaire);
        formulaire.submit();
    }
	</script>

</head>
<body onload="resizemenu()" onresize="resizemenu()">

	<?php 
		include("menus.php");
    include("gract.inc");
    include("animateurs.inc");
    include("liOptions.php");
	?>
  <div class="titre1">Recherche d'une activité dans la base de données</div></br>
  <div class="resultat" id="res">
	</br>
	<?php 
    $N = new MConf;  
    $gract=new Gract;
    $gract->getpost();$gract->activite = $activite[$gract->activite];echo $gract->activite."<br>";
    $sql="";
      $mes0="SELECT * FROM $tact ";
      if ($gract->codactivite !=0) $sql = $mes0."WHERE codactivite='".addslashes($gract->codactivite)."'";
      if ($gract->groupe!=0) {
        if (strlen($sql)<1) $sql = $mes0."WHERE groupe=".$gract->groupe;
        else $sql = $sql." AND groupe=".$gract->groupe;
      }
      if (strlen($gract->tarifA)>0) {
        if (strlen($sql)<1) $sql = $mes0."WHERE tarifA=".$gract->tarifA;
        else $sql = $sql." AND tarifA=".$gract->tarifA;
      }
      if (strlen($gract->tarifC)>0) {
        if (strlen($sql)<1) $sql = $mes0."WHERE tarifC=".$gract->tarifC;
        else $sql = $sql." AND tarifC=".$gract->tarifC;
      }
      if ($gract->lieu!="lieu") {
        if (strlen($sql)<1) $sql = $mes0."WHERE lieu='".$gract->lieu."'";
        else $sql = $sql." AND lieu='".$gract->lieu."'";
      }
      if ($gract->jour!="jour") {
        if (strlen($sql)<1) $sql = $mes0."WHERE jour='".$gract->jour."'";
        else $sql = $sql." AND jour='".$gract->jour."'";
      }
     if ($gract->debut!="début") {
        if (strlen($sql)<1) $sql = $mes0."WHERE debut='".$gract->debut."'";
        else $sql = $sql." AND debut='".$gract->debut."'";
      }
      if ($gract->fin!="fin") {
        if (strlen($sql)<1) $sql = $mes0."WHERE fin='".$gract->fin."'";
        else $sql = $sql." AND fin='".$gract->fin."'";
      }
      if ($gract->idanimateur>0) {
        if (strlen($sql)<1) $sql = $mes0."WHERE idanimateur=".$gract->idanimateur;
        else $sql = $sql." AND idanimateur=".$gract->idanimateur;
      }
      if ($gract->idresponsable>0) {
        if (strlen($sql)<1) $sql = $mes0."WHERE idresponsable=".$gract->idresponsable;
        else $sql = $sql." AND idresponsable=".$gract->idresponsable;
      }
     if (strlen($sql)<6) $sql="SELECT * FROM $tact";
     $sql .=" ORDER BY activite";
     //echo $sql."<br>";die("");
     $ga = new Gracts;
     $ga->cherche($sql,$tact);
     $N = null;//echo "n=".$ga->n."<br>";die("");
    if ($ga->n<1) echo "</br></br><div class='alerte'>Aucune activité trouvée</div>";
    else if ($ga->n>1) {
      echo "<div class='alerte'>$ga->n fiches trouvées</div></br>";
      $mes ='<div id="divConteneur"> <table style="width:80%"><tr><th>Activité</th><th>Groupe</th><th>Lieu</th><th>Jour</th><th>Début</th><th>Fin</th><th>Animateur</th></tr>';
        for ($i=0;$i<$ga->n;$i++) {
            $idligne=strval($i);
            $anim = getoption($optionsanimateur,$ga->gract[$i]->idanimateur);
            $mes =$mes.'<tr id='.$idligne.' class="defaut">';
            $mes =$mes.'<td class="defaut" onclick="SelectGract('.strval($ga->gract[$i]->id).')">'.strval($ga->gract[$i]->activite).'</td>';
            $mes =$mes.'<td class="sans">'.strval($ga->gract[$i]->groupe).'</td>';
            $mes =$mes.'<td class="sans">'.$ga->gract[$i]->lieu.'</td>';
            $mes =$mes.'<td class="sans">'.$ga->gract[$i]->jour.'</td>';
            $mes =$mes.'<td class="sans">'.$ga->gract[$i]->debut.'</td>';
            $mes =$mes.'<td class="sans">'.$ga->gract[$i]->fin.'</td>';
            $mes =$mes.'<td class="defaut" onclick="SelectAnimateur('.strval($ga->gract[$i]->idanimateur).')">'.$anim.'</td>';
            $mes =$mes.'</tr>';
      }
      $mes =$mes.'</table></div>';
      echo $mes;
    } 
    else {
      //echo $ga->gract[0]->id."<br>";
      $mes  = '<form name="formgract" method="post" action="affichGract.php">'; //echo "mes1 = ".$mes."<br>";
      $mes = $mes.'<input type="hidden" name="id" value='.$ga->gract[0]->id.' >'; //echo "mes2 = ".$mes."<br>";
      $mes = $mes.'</form>';
      $mes = $mes.'<script type="text/javascript">document.formgract.submit();</script>';
      echo $mes;

    } 
  ?>
	<div id="sortie"></div>
</body>
</html>
