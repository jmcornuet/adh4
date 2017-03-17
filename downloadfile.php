<?php 
	if (PHP_OS == "Darwin") $mes="Location: http://localhost:8888/adh3/export/".$nomfi;
	else $mes="Location: http://192.168.1.44/adh/export/".$nomfi;
	header($mes); 
?>