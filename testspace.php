<?php
	function despace($s) {
		$b="";
		for ($i=0;$i<strlen($s);$i++) {
			$c=substr($s,$i,1);
			if ($c == " ") $b .="_";
			else $b .=$c;
		}
		return $b;	 
	}

	function enspace($s) {
		$b="";
		for ($i=0;$i<strlen($s);$i++) {
			$c=substr($s,$i,1);
			if ($c == "_") $b .=" ";
			else $b .=$c;
		} 
		return $b;
	}

	$m= "Il n'y a pas d'activité.<br>";
	echo $m."<br>";
	$n=despace($m);
	echo $n."<br>";
	$p=enspace($n);
	echo $p."<br>";
?>
