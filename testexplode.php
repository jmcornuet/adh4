<?php
	$a=";a;b;c;d";
	if (substr($a,0,1)==";") $a=substr($a,1);
	$b=explode(";",$a);
	echo count($b)."\n";
?>