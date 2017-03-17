<?php
	function arrayunique($a) {
		$b=array();
		for ($i=0;$i<count($a);$i++) {
			if ($i==0) array_push($b,$a[0]);
			$trouve=false;$j=0;
			while ((!$trouve)and($j<count($b))) {
				$trouve=($b[$j]==$a[$i]);
				if (!$trouve) $j++;
			}
			if (!$trouve) array_push($b,$a[$i]);
		}
		return $b;
	}
	$a=["1","1","2","3","3"];
	echo join(" ",arrayunique($a))."<br>";
?>