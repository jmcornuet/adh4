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
		function SelectAnimateur(id) {
 			var formulaire = document.createElement('form');
    		formulaire.setAttribute('action', 'affichAnimateur.php');
    		formulaire.setAttribute('method', 'post');
    		var input0 = document.createElement('input');
    		input0.setAttribute('type','hidden');input0.setAttribute('name','id');input0.setAttribute('value',id);
    		formulaire.appendChild(input0);
	   		document.body.appendChild(formulaire);
    		formulaire.submit();
		}
	</script>

</head>
<body onload="resizemenu()" onresize="resizemenu()">

	<?php
		include("menus.php");
    include("animateurs.inc"); 		
    $an = new Animateur;
    $an->getpost();
	?>
  <div class="titre1">Recherche d'un animateur dans la base de données</div></br>
  <div class="resultat" id="res">
	</br>
	<?php 
   		$mes0="SELECT * FROM $tani WHERE";
      	$sql="";
        if (strlen($an->nom)>0) $sql = $mes0." nom LIKE '%".$an->nom."%'";
        if (strlen($an->telephone)>0) {
        	if (strlen($sql)<1) $sql =$mes0." telephone = '".compacte($an->telephone)."'";
        	else $sql = $sql." AND telephone='".compacte($an->telephone)."'";
        }
        if (strlen($an->portable)>0) {
          if (strlen($sql)<1) $sql =$mes0." portable = '".compacte($an->portable)."'";
          else $sql = $sql." AND portable='".compacte($an->portable)."'";
        }
        if (strlen($an->courriel)>0) {
        	if (strlen($sql)<1) $sql =$mes0." courriel LIKE'%".$an->courriel."%'";
        	else $sql = $sql." AND courriel LIKE '%".$an->courriel."%'";
        }
        if (strlen($sql)<6) $sql="SELECT * FROM $tani";
        $sql .=" ORDER BY nom";
        $an = new Animateurs;//echo $sql."<br>";
        $an->cherche($sql);
        $M = new MConf;
		    if ($an->n<1) echo "</br></br><div class='alerte'>Aucun animateur trouvé</div>";
		    else if ($an->n>1) {
			 echo "<div class='alerte'>$an->n animateurs trouvés</div></br>"; 
			 $mes ='<div id="divConteneur"> <table style="width:80%"><tr><th>Nom</th><th>Prénom</th><th>Téléphone</th><th>Portable</th><th>Courriel</th><th>Activité</th></tr>';
    	 for ($i=0;$i<$an->n;$i++) {
          $sql="SELECT activite FROM $tact WHERE idanimateur=".$an->ani[$i]->id;
          $reponse=$M->querydb($sql);$donnees=$reponse->fetch();
   			  $mes =$mes.'<tr onclick="SelectAnimateur('.$an->ani[$i]->id.')">';
          $mes =$mes.'<td class="defaut">'.$an->ani[$i]->nom.'</td>';
          $mes =$mes.'<td class="defaut">'.$an->ani[$i]->prenom.'</td>';
				  $mes =$mes.'<td class="defaut">'.$an->ani[$i]->telephone.'</td>';
          $mes =$mes.'<td class="defaut">'.$an->ani[$i]->portable.'</td>';
          $mes =$mes.'<td class="defaut">'.$an->ani[$i]->courriel.'</td>';
          $mes =$mes.'<td class="defaut">'.$donnees['activite'].'</td>';
				  $mes =$mes.'</tr>';
      }
			$mes =$mes.'</table></div>';
			echo $mes;
		} else {
      $mes  = '<form name="formanimateur" method="post" action="affichAnimateur.php">';
      $mes = $mes.'<input type="hidden" name="id" value='.$an->ani[0]->id.' >';
      $mes = $mes.'</form>';
      $mes = $mes.'<script type="text/javascript">document.formanimateur.submit();</script>';
      echo $mes;

    }
    $M->close();
		?>
	 </div>
	<div id="sortie"></div>
</body>
</html>
