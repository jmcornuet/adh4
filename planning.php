<?php
    session_start();
    require_once("session.php");
    if (!$prenom) die();
	include("liOptions.php");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Club MGEN</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="bibglobal0.css" type="text/css" rel="stylesheet" media="screen"/>
    <script src="fonctions.js"></script>

</head>
<body onload="resizemenu()" onresize="resizemenu()">
	<?php 
		include("menus.php");//echo "apres menus.php<br>";
        include("gract.inc");//echo "apres gract.inc<br>";
