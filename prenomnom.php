<?php
ob_implicit_flush(true);
	include("MGENconfig.php");
	function transprenom($p) {
        $fp=explode(" ",$p);
        for ($j=0;$j<count($fp);$j++) {
            $p=strtolower($fp[$j]);
            $dp=explode("-",$p);
            for ($i=0;$i<count($dp);$i++) {$a=substr($dp[$i],0,1);$b=substr($dp[$i],1,100);$a=strtoupper($a);$dp[$i]=$a.$b;}
            $fp[$j]=implode("-",$dp);
        }
        $p=implode(" ",$fp);
        return $p;
    }
    function writefileadh($tadh) {
    	$M = new MConf;
    	$sql="SELECT * FROM $tadh ORDER BY nom";
    	$reponse = $M->querydb($sql);
    	$id1=array();$nom1=array();$prenom1=array();
    	while ($donnees = $reponse->fetch()) {
        	array_push($id1,$donnees['id']);
        	array_push($nom1,$donnees['nom']);
        	array_push($prenom1,$donnees['prenom']);            
    	}
    	$optionspersonne="";
    	for($i=0;$i<count($id1);$i++) {
        	$optionspersonne = $optionspersonne."<option value=".$id1[$i].">".$nom1[$i]." ".$prenom1[$i]."</option>";
    	}
    	file_put_contents("listadh.txt",$optionspersonne);
    	$M=null;
    }

    function writefileani($tani) {
        $M = new MConf;
        $sql="SELECT * FROM $tani ORDER BY nom";
        $reponse = $M->querydb($sql);
        $id1=array();$nom1=array();$prenom1=array();
        while ($donnees = $reponse->fetch()) {
            array_push($id1,$donnees['id']);
            array_push($nom1,$donnees['nom']);
            array_push($prenom1,$donnees['prenom']);            
        }
        $options="";
        for($i=0;$i<count($id1);$i++) {
            $options = $options."<option value=".$id1[$i].">".$nom1[$i]." ".$prenom1[$i]."</option>";
        }
        file_put_contents("listani.txt",$options);
        $M=null;
    }
    function arrayunique($a) {
        $b=array();
        for ($i=0;$i<count($a);$i++) {
            if ($i==0) array_push($b,$a[0]);
            else {
                $trouve=false;$j=0;
                while ((!$trouve)and($j<count($b))) {
                    $trouve=($b[$j]==$a[$i]);
                    if (!$trouve) $j++;
                }
                if (!$trouve) array_push($b,$a[$i]);
            }
        }
        return $b;
    }
    function writefileact($tact) {
        $M = new MConf;
        $sql="SELECT * FROM $tact ORDER BY activite";
        $reponse = $M->querydb($sql);
        $codactivite=array();$activite=array();
        while ($donnees = $reponse->fetch()) {
            array_push($codactivite,$donnees['codactivite']);
            array_push($activite,$donnees['activite']);
        }
        $codactivite=arrayunique($codactivite);
        $activite=arrayunique($activite);
        $options="";
        for($i=0;$i<count($codactivite);$i++) {
            $options = $options."<option value=".$codactivite[$i].">".$activite[$i]."</option>";
        }
        file_put_contents("listact.txt",$options);
        $M=null;
        echo $options;
    }
/*	$M = new MConf;
	for ($i=0;$i<1200;$i++) {
		$sql="SELECT * FROM tadh2016 WHERE id=$i";
		$reponse =$M->querydb($sql);
		if ($donnees = $reponse->fetch()) {
			$prenom = addslashes(transprenom($donnees['prenom']));
			$nom = addslashes(transprenom($donnees['nom']));
			$prenomnom = $prenom." ".$nom;
			$sql="UPDATE tadh2016 SET prenomnom='".$prenomnom."' WHERE id=$i";
			$reponse =$M->querydb($sql);
			echo $i."   ".$prenomnom."<br>"; 
		}
	}
	$M=null;*/
	//writefileadh("tadh2016");
    //writefileani("tanimateurs2016");
    writefileact("tgract2016");
	echo "FIN<br>";
?>