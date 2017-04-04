<?php
    session_start();
    require_once("session.php");
    if (!$prenom) die();
    include("gract.inc");
//    include("animateurs.inc");
//    include("liOptions.php");
    //print_r($_POST);echo "<br><br>";
    $ga = new Gract;
    $ga->getpost();

/*    echo "activite = ".$ga->activite."<br>";
    $ga->activite=trim($ga->activite);
    $ga->codactivite=trim($ga->codactivite);
    $ga->animateur=$animateur[$ga->animateur];
    echo $ga->activite."  ".$ga->codactivite." ".$ga->animateur." <br>";
    $an = new Animateur;
    $an->animateur = $ga->animateur;
    $ga->idanimateur = $an->idanim();
    echo $ga->id."  ".$ga->idanimateur."<br>";
*/
    if ($_POST['addgr']) $ga->insere($tact);
    $mes  = '<form name="formgract" method="post" action="affichGract2.php">';
    $mes = $mes.'<input type="hidden" name="id" value='.$ga->id.' >';
    $mes = $mes.'</form>';
    $mes = $mes.'<script type="text/javascript">document.formgract.submit();</script>';
    echo $mes; 

?>
