<?php 
	session_start();
	session_regenerate_id();
	include("MGENconfig.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bibliothèque</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="bibglobal0.css" type="text/css" rel="stylesheet" media="screen"/>
</head>
<body>
<?php

$login=$_POST['ident'];
$pass=$_POST['pass'];
$lien="index.php";
$bib="bib0.php";

if ($login!="" AND $pass!="") {
	$M = new MConf;
	$sql="SELECT * FROM $M->tablaut WHERE login='$login' AND password='$pass'";
	$reponse=$M->querydb($sql);
	$donnees = $reponse->fetch();
	if ($donnees['login']) {
		$ff = fopen("../conf/tables.conf","r");
		while (!feof($ff)) {
			$a= trim(utf8_encode(fgets($ff)));
			$b=explode("=",$a);
			switch ($b[0]) {
				case "adh" : $_SESSION['tadh'] = $b[1];break;
				case "ani" : $_SESSION['tani'] = $b[1];break;
				case "act" : $_SESSION['tact'] = $b[1];break;
			}
		} 
		fclose($ff);		
		$_SESSION['prenom']=$donnees['prenom'];
		$_SESSION['niveau']=$donnees['niveau'];
		$_SESSION['nom']=$donnees['nom'];
		setlocale(LC_TIME, 'fr', 'fr_FR','fr_FR.UTF-8');
		$_SESSION['debut']=utf8_encode(strftime("%d/%m/%g_%H:%M:%S"));
		$_SESSION['version'] = "0.0.2";
		$M->close();
?>	
	<form name='demarre' method='post' action='club0.php'>	</form>
	<script type='text/javascript'>
		document.demarre.submit();
	</script>	
<?php
	}
	else die("Désolé, vous n'avez pas été reconnu(e). <a href=$lien>Essayer encore</a>");
}
else die("Désolé, vous n'avez pas été reconnu(e). <a href=$lien>Essayer encore</a>");
?>
</body>
</html>

