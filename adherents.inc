<?php
	require_once("MGENconfig.php");
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
	class Adherent {
		public $id;
		public $titre;
		public $qualite;
		public $nom;
		public $nomjf;
		public $prenom;
		public $adresse;
		public $compadresse;
		public $codepostal;
		public $ville;
		public $telephone;
		public $portable;
		public $courriel;
		public $numMGEN;
		public $numeroSS;
		public $profession;
		public $assurance;
		public $cotisation;
		public $premannee;
		public $sortie;
		public $activites;
		public $activite1;
		public $activite2;
		public $activite3;
		public $activite4;
		public $activite5;
		public $activite6;
		public $groupe1;
		public $groupe2;
		public $groupe3;
		public $groupe4;
		public $groupe5;
		public $groupe6;
		public $particip1;
		public $particip2;
		public $particip3;
		public $particip4;
		public $particip5;
		public $particip6;

		private	function arrayunique($a) {
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

		public function getadh($tadh) {
			$M = new MConf;
			$sql = "SELECT * FROM $tadh WHERE id=$this->id";
		    $reponse=$M->querydb($sql);
			$donnees=$reponse->fetch();
			if ($donnees) {
				$this->id=$donnees['id'];
				$this->titre=$donnees['titre'];
				$this->qualite=$donnees['qualite'];
				$this->nom=$donnees['nom'];
				$this->nomjf=$donnees['nomjf'];
				$this->prenom=$donnees['prenom'];
				$this->adresse=$donnees['adresse'];
				$this->compadresse=$donnees['compadresse'];
				$this->codepostal=$donnees['codepostal'];
				$this->ville=$donnees['ville'];
				$this->telephone=$donnees['telephone'];
				$this->portable=$donnees['portable'];
				$this->courriel=$donnees['courriel'];
				$this->numMGEN=$donnees['numMGEN'];
				$this->numeroSS=$donnees['numeroSS'];
				$this->profession=$donnees['profession'];
				$this->assurance=$donnees['assurance'];
				$this->cotisation=$donnees['cotisation'];
				$this->premannee=$donnees['premannee'];
				$this->sortie=$donnees['sortie'];
				$this->activites=$donnees['activites'];
			}
			$M->close();			
		}

		public function supprime($tadh) {
			$M = new MConf;
			$sql = "DELETE FROM $tadh WHERE id=$this->id";
		    $reponse=$M->querydb($sql);
		    $M->close();
		 	return $reponse;
		}
		public function modifie($tadh) {
			$M = new MConf;
			$this->nom = addslashes(strtoupper($this->nom));
	    	$this->prenom = addslashes(transprenom($this->prenom));
	    	$this->nomjf = addslashes(strtoupper($this->nomjf));
	    	$this->adresse = addslashes(strtoupper($this->adresse));
	    	$this->compadresse = addslashes(strtoupper($this->compadresse));
	    	$this->ville = addslashes(strtoupper($this->ville));
	    	$this->assurance = addslashes(strtoupper($this->assurance));
	    	$this->profession = addslashes($this->profession);
	    	$sql = "UPDATE $tadh SET titre='$this->titre', qualite='$this->qualite', nom='$this->nom', prenom='$this->prenom', adresse='$this->adresse', codepostal=$this->codepostal, ville='$this->ville', numMGEN='$this->numMGEN', numeroSS='$this->numeroSS', profession='$this->profession', assurance='$this->assurance', cotisation=$this->cotisation, premannee=$this->premannee,activites='$this->activites',";
	
	    	if (strlen($this->nomjf)>0) {$sql .=" nomjf='$this->nomjf',";}
	    	if (strlen($this->telephone)>0) {$sql .="telephone='$this->telephone',";}
	    	if (strlen($this->portable)>0) {$sql .="portable='$this->portable',";}
	    	if (strlen($this->compadresse)>0) {$sql .="compadresse='$this->compadresse',";}
	    	if (strlen($this->courriel)>0) {$sql .="courriel='$this->courriel',";}
	    	$sql=substr($sql,0,-1)." WHERE id=$this->id";
	    	//echo $sql;
		    $reponse=$M->querydb($sql);
		    $M->close();
		 	return $reponse;
		}
		public function insere($tadh) {
			$M = new MConf;
			$this->premannee=$M->annee;
			$this->nom = addslashes(strtoupper($this->nom));
	    	$this->prenom = addslashes(transprenom($this->prenom));
	    	$this->nomjf = addslashes(strtoupper($this->nomjf));
	    	$this->adresse = addslashes(strtoupper($this->adresse));
	    	$this->compadresse = addslashes(strtoupper($this->compadresse));
	    	$this->ville = addslashes(strtoupper($this->ville));
	    	$this->assurance = addslashes(strtoupper($this->assurance));
	    	$this->profession = addslashes($this->profession);
	    	$sql0 = "INSERT INTO $tadh (";
	    	$sql1 = " VALUES (";
	    	$sql0 .="titre,qualite,nom,prenom,adresse,codepostal,ville,";
	    	$sql1 .="'$this->titre','$this->qualite','$this->nom','$this->prenom','$this->adresse',$this->codepostal,'$this->ville',";
	    	$sql0 .="numMGEN,assurance,numeroSS,profession,premannee,activites,";
	    	$sql1 .="$this->numMGEN,'$this->assurance','$this->numeroSS','$this->profession',$this->premannee,'$this->activites',";
	    	if (strlen($this->nomjf)>0) {$sql0 .="nomjf,";$sql1 .="'$this->nomjf',";}
	    	if (strlen($this->telephone)>0) {$sql0 .="telephone,";$sql1 .="'$this->telephone',";}
	    	if (strlen($this->portable)>0) {$sql0 .="portable,";$sql1 .="'$this->portable',";}
	    	if (strlen($this->compadresse)>0) {$sql0 .="compadresse,";$sql1 .="'$this->compadresse',";}
	    	if (strlen($this->courriel)>0) {$sql0 .="courriel,";$sql1 .="'$this->courriel',";}
	    	$sql0=substr($sql0,0,-1).")";
	    	$sql1=substr($sql1,0,-1).")";
			$sql=$sql0.$sql1;
			//echo $sql."<br>";
			$M = new MConf;
		    $reponse=$M->querydb($sql);
			$this->id=$M->lastId();
		    $M->close();
		}
		public function getpost() {
			$this->id = $_POST['id'];
			$this->titre = $_POST['titre'];
			$this->qualite = $_POST['qualite'];
			$this->nom = $_POST['nom'];
			$this->nomjf = $_POST['nomjf'];
			$this->prenom = $_POST['prenom'];
			$this->numMGEN = $_POST['numMGEN'];
			$this->telephone = $_POST['telephone'];
			$this->portable = $_POST['portable'];
			$this->adresse = $_POST['adresse'];
			$this->compadresse = $_POST['compadresse'];
			$this->codepostal = $_POST['codepostal'];
			$this->ville = $_POST['ville'];
			$this->courriel = $_POST['courriel'];
			$this->profession = $_POST['profession'];
			$this->assurance = $_POST['assurance'];
			$this->numeroSS = $_POST['numeroSS'];
			$this->cotisation = $_POST['cotisation'];
			$this->premannee = $_POST['premannee'];
			$this->activites = $_POST['activites'];
			$this->activite1=$_POST['activite1'];
			$this->activite2=$_POST['activite2'];
			$this->activite3=$_POST['activite3'];
			$this->activite4=$_POST['activite4'];
			$this->activite5=$_POST['activite5'];
			$this->activite6=$_POST['activite6'];
			$this->groupe1=$_POST['groupe1'];
			$this->groupe2=$_POST['groupe2'];
			$this->groupe3=$_POST['groupe3'];
			$this->groupe4=$_POST['groupe4'];
			$this->groupe5=$_POST['groupe5'];
			$this->groupe6=$_POST['groupe6'];
			if (isset($_POST['particip1'])) $this->particip1="P"; else $this->particip1="A";
			if (isset($_POST['particip2'])) $this->particip2="P"; else $this->particip2="A";
			if (isset($_POST['particip3'])) $this->particip3="P"; else $this->particip3="A";
			if (isset($_POST['particip4'])) $this->particip4="P"; else $this->particip4="A";
			if (isset($_POST['particip5'])) $this->particip5="P"; else $this->particip5="A";
			if (isset($_POST['particip6'])) $this->particip6="P"; else $this->particip6="A";
		}
		public function getcodes($tact) {
			$M = new MConf;
		 	$sql = "SELECT * FROM $tact";
		    $reponse=$M->querydb($sql);
		    $nomactivite=array();$codactivite=array();
		    while($donnees = $reponse->fetch()) {
		    	array_push($nomactivite,$donnees['activite']);
		    	array_push($codactivite,$donnees['codactivite']);
		    }
		    $M->close();
		    $nomactivite=$this->arrayunique($nomactivite);
		    $codactivite=$this->arrayunique($codactivite);
    		$act=array();$gro=array();$par=array();
    		if ($this->activite1 != "Pas d'activité") {array_push($act,$this->activite1);array_push($gro,$this->groupe1);array_push($par,$this->particip1);}
    		if ($this->activite2 != "Pas d'activité") {array_push($act,$this->activite2);array_push($gro,$this->groupe2);array_push($par,$this->particip2);}
    		if ($this->activite3 != "Pas d'activité") {array_push($act,$this->activite3);array_push($gro,$this->groupe3);array_push($par,$this->particip3);}
    		if ($this->activite4 != "Pas d'activité") {array_push($act,$this->activite4);array_push($gro,$this->groupe4);array_push($par,$this->particip4);}
    		if ($this->activite5 != "Pas d'activité") {array_push($act,$this->activite5);array_push($gro,$this->groupe5);array_push($par,$this->particip5);}
    		if ($this->activite6 != "Pas d'activité") {array_push($act,$this->activite6);array_push($gro,$this->groupe6);array_push($par,$this->particip6);}

    		$nact=count($act);
    		$this->activites="";
		    for ($i=0;$i<$nact;$i++) {
      			$trouve = false;$j=0;
      			while ((!$trouve)and($j<count($nomactivite))) {
        			$trouve=($act[$i] == $nomactivite[$j]);
			        if (!$trouve) $j++;
    			}
	      		if ($trouve) $this->activites .="=".$codactivite[$j]."-".$gro[$i]."-".$par[$i];
	      		 
    		}
    		if (strlen($this->activites)<1) $this->activites="=00";
		}
		public function getactivites($tact) {
			$M = new MConf;
		 	$sql = "SELECT * FROM $tact";
		    $reponse=$M->querydb($sql);
		    $nomactivite=array();$codactivite=array();
		    while($donnees = $reponse->fetch()) {
		    	array_push($nomactivite,$donnees['activite']);
		    	array_push($codactivite,$donnees['codactivite']);
		    }
		    $M->close();
		    $nomactivite=array_unique($nomactivite);
		    $codactivite=array_unique($codactivite);

		    $this->activite1="Pas d'activité";$this->activite2="Pas d'activité";$this->activite3="Pas d'activité";
		    $this->activite4="Pas d'activité";$this->activite5="Pas d'activité";$this->activite6="Pas d'activité";
		    $this->groupe1="0";$this->groupe2="0";$this->groupe3="0";
		    $this->groupe4="0";$this->groupe5="0";$this->groupe6="0";
    		if (substr($this->activites,0,1)=="=") $this->activites=substr($this->activites,1);
    		$c=explode("=",$this->activites);
   			if ($c[0]!="00") {
	    		for ($i=0;$i<count($c);$i++) {
	    			$trouve=false;$j=0;
	    			if (strpos($c[$i],"-")>0) {
	    				$aa=explode("-",$c[$i]);
	    				$a=$aa[0];$g=$aa[1];
	    				if (count($aa)>2) $p=$aa[2];
	    				else $p="A";
	    			} else {$a=$c[$i];$g="0";$p="A";}
	    			//echo "a=".$a."<br>";
	    			while ((!$trouve)and($j<count($codactivite))) {
	    				$trouve = ($a == $codactivite[$j]);
	    				if (!$trouve) $j++;
	    			}
	    			//echo "j=".$j."<br>";
	    			//echo $nomactivite[$j]."-".$g."<br>";
	    			switch($i) {
	    				case 0 : $this->activite1 = $nomactivite[$j];
	    						 if ($g != "0") $this->groupe1 = $g;
	    						 $this->particip1 = $p; 
	    						 break;
	    				case 1 : $this->activite2 = $nomactivite[$j];
	    						 if ($g != "0") $this->groupe2 = $g;
	    						 $this->particip2 = $p; 
	    						 break;
	    				case 2 : $this->activite3 = $nomactivite[$j];
	    						 if ($g != "0") $this->groupe3 = $g;
	    						 $this->particip3 = $p; 
	    						 break;
	    				case 3 : $this->activite4 = $nomactivite[$j];
	    						 if ($g != "0") $this->groupe4 = $g;
	    						 $this->particip4 = $p; 
	    						 break;
	    				case 4 : $this->activite5 = $nomactivite[$j];
	    						 if ($g != "0") $this->groupe5 = $g;
	    						 $this->particip5 = $p; 
	    						 break;
	    				case 5 : $this->activite6 = $nomactivite[$j];
	    						 if ($g != "0") $this->groupe6 = $g;
	    						 $this->particip6 = $p; 
	    						 break;
	    			}
	    		}	    	
	    	}
    	}
	}

	class Adherents {
		public $adh;
		public $n;
		private $a;

		public function cherche($sql,$tact) {
			$M = new MConf;
	        $reponse=$M->querydb($sql);
	        $this->n=0;$this->adh=array();
	        while ($donnees = $reponse->fetch()) {
				$a = new Adherent;
				$a->id=$donnees['id'];
				$a->titre=$donnees['titre'];
				$a->qualite=$donnees['qualite'];
				$a->nom=$donnees['nom'];
				$a->nomjf=$donnees['nomjf'];
				$a->prenom=$donnees['prenom'];
				$a->adresse=$donnees['adresse'];
				$a->compadresse=$donnees['compadresse'];
				$a->codepostal=$donnees['codepostal'];
				$a->ville=$donnees['ville'];
				$a->telephone=$donnees['telephone'];
				$a->portable=$donnees['portable'];
				$a->courriel=$donnees['courriel'];
				$a->numMGEN=$donnees['numMGEN'];
				$a->numeroSS=$donnees['numeroSS'];
				$a->profession=$donnees['profession'];
				$a->assurance=$donnees['assurance'];
				$a->cotisation=$donnees['cotisation'];
				$a->premannee=$donnees['premannee'];
				$a->sortie=$donnees['sortie'];
				$a->activites=$donnees['activites'];
				$a->getactivites($tact);
				array_push($this->adh, $a);
				$this->n++;
			}
			$M->close();
		}
	}

?>