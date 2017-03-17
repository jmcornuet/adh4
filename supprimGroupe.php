<?php
    session_start();
    require_once("session.php");
    if (!$prenom) die();
    include("liOptions.php");
    include("gract.inc");

    $postidgr=$_POST['idgroupes'];//echo $postidgr."<br>";
    $idgroupes=explode(";",$postidgr);
    $postgr=$_POST['groupes'];//echo $postgr."<br>";
    $groupes = explode(";",$postgr);

    $ga = new Gract;
    $ga->getpost();
    //echo $ga->activite."<br>";
    //echo $ga->codactivite."<br>";
    //echo $ga->groupe."<br>";
    //echo "-".$groupes[0]."- ".$idgroupes[0]."<br>";
    //echo "-".$groupes[1]."- ".$idgroupes[1]."<br>";
    //if($ga->groupe == $groupes[1]) echo "oui<br>"; else echo "non<br>";
    $trouve=false;$i=0;//echo count($groupes)."<br>";
    while ((!$trouve)and($i<count($groupes))) {
        $trouve = ($ga->groupe == $groupes[$i]);
        if (!$trouve) $i++;
    }
    //echo $idgroupes[$i]."<br>";
    $ga->id = $idgroupes[$i];
    $newgroupes=array();
    for ($j=0;$j<count($groupes);$j++) if ($j!=$i) array_push($newgroupes,$groupes[$j]);
    if (count($newgroupes)>0) sort($newgroupes);
   
    if (($_POST['supgr'])and($ga->groupe>1)) {
        if (count($newgroupes)>0) {
            $ga->supprime();
            $ga->groupe=$newgroupes[0];
            $ga->getid();
        } else { 
            $ga->groupe=1;
            $ga->animateur='Animateur';
            $ga->lieu='';
            $ga->jour='';
            $ga->debut='';
            $ga->fin='';
            $ga->modifie();
        }
    }
    $mes  = '<form name="formgract" method="post" action="affichGract.php">'; //echo "mes1 = ".$mes."<br>";
    $mes = $mes.'<input type="hidden" name="id" value='.$ga->id.' >'; //echo "mes2 = ".$mes."<br>";
    $mes = $mes.'</form>';
    $mes = $mes.'<script type="text/javascript">document.formgract.submit();</script>';
    echo $mes; 

?>
