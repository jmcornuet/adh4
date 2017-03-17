<?php
    session_start();
    require_once("session.php");
    if (!$prenom) die();
    include("MGENconfig.php");
    $M = new MConf;
    $M->deconnexion();
    $M->close();
    $lien="index.php"; 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Club MGEN</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="bibglobal.css" type="text/css" rel="stylesheet" media="screen"/>
</head>
<body>
	<?php 
		echo "A bientôt, $prenom ! <a href=$lien>Se reconnecter ?</a>";
		session_destroy(); 
	?> 
</body>
</html>