<?php
	require_once("MGENconfig.php");
	if (PHP_OS == "Darwin") $basedir=""; else $basedir="/var/www/html/adh/";
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
        file_put_contents($basedir."listact.txt",$options);
        $M=null;
    }

	class Gract {
		public $id;
		public $activite;
		public $codactivite;
		public $tarifA;
		public $tarifC;
		public $groupe;
		public $lieu;
		public $jour;
		public $debut;
		public $fin;
		public $idanimateur;
		public $idresponsable;
		public $animateur;
		public $activite0;
		public $groupe0;
		
		public function getgract($tact) {
			$M = new MConf; 
			$sql = "SELECT * FROM $tact WHERE id=$this->id";
		    $reponse=$M->querydb($sql);
			$donnees=$reponse->fetch();
			if ($donnees) {
				$this->id=$donnees['id'];
				$this->activite=$donnees['activite'];
				$this->codactivite=$donnees['codactivite'];
				$this->tarifA=$donnees['tarifA'];
				$this->tarifC=$donnees['tarifC'];
				$this->groupe=$donnees['groupe'];
				$this->lieu=$donnees['lieu'];
				$this->jour=$donnees['jour'];
				$this->debut=$donnees['debut'];
				$this->fin=$donnees['fin'];
				$this->idanimateur=$donnees['idanimateur'];
				$this->animateur=$donnees['animateur'];
				$this->idresponsable=$donnees['idresponsable'];
			}
			$M->close();			
		}

		public function getcodactivite($tact) {
			$M = new MConf;
			$act = addslashes($this->activite);
			$sql = "SELECT * FROM $tact WHERE activite='$act'";
		    $reponse=$M->querydb($sql);
			$donnees=$reponse->fetch();//echo "(".$donnees['codactivite'].")<br>";
			if ($donnees) $this->codactivite=$donnees['codactivite'];
			$M->close();			
		}
		public function getnouveaucode($tact) {
			$M = new MConf; 
			$sql = "SELECT codactivite FROM $tact ORDER BY codactivite DESC LIMIT 1";
			$reponse=$M->querydb($sql);
		    $donnees = $reponse->fetch();
		    $a=$donnees['codactivite'];
		    $this->codactivite = $a+1;		    
			$M->close();			
		}
		public function getid($tact) {
			$M = new MConf; 
			//echo "dans getid codactivite=".$this->codactivite."    groupe=".$this->groupe."<br>";
			$sql = "SELECT * FROM $tact WHERE codactivite=$this->codactivite AND groupe=$this->groupe";//echo $sql."<br>";
		    $reponse=$M->querydb($sql);
			$donnees=$reponse->fetch();
			if ($donnees['id']) $this->id=$donnees['id'];
			else $this->id = 0;
			//echo $this->id."<br>";
			$M->close();			
		}
		public function getpost() {
			$this->id=$_POST['id'];
			$this->activite=$_POST['activite'];
			$this->codactivite=$_POST['codactivite'];
			$this->tarifA=$_POST['tarifA'];
			$this->tarifC=$_POST['tarifC'];
			$this->groupe=$_POST['groupe'];
			$this->lieu=$_POST['lieu'];
			$this->jour=$_POST['jour'];
			$this->debut=$_POST['debut'];
			$this->fin=$_POST['fin'];
			$this->idanimateur=$_POST['idanimateur'];
			$this->idresponsable=$_POST['idresponsable'];//echo $this->idanimateur."   ".$this->idresponsable."<br>";
		}
		public function getpost2() {
			$this->activite=enspace($_POST['activite']);
			$this->codactivite=$_POST['codactivite'];
			$this->groupe=$_POST['groupe'];
			$this->lieu=$_POST['lieu'];
			$this->jour=$_POST['jour'];
			$this->debut=$_POST['debut'];
			$this->fin=$_POST['fin'];
			$this->animateur=$_POST['animateur'];
		} 
		public function supprime($tact) {
			$M = new MConf; 
			$sql = "DELETE FROM $tact WHERE id=$this->id";//echo $sql."<br>";
		    $reponse=$M->querydb($sql);//if ($reponse) echo "reponse=true<br>"; else echo "reponse=false<br>";
			$M->close();			
		 	return $reponse;
		}
		public function modifie($tact) {
			$this->activite=addslashes($this->activite);//echo $this->activite."<br>";
			//echo "idanimateur = ".$this->idanimateur."<br>";
			//echo "idresponsable = ".$this->idresponsable."<br>";
			//echo "id=".$this->id."<br>";
			$M = new MConf; 
			$sql = "UPDATE $tact SET activite='$this->activite', codactivite=$this->codactivite, groupe=$this->groupe,";
			$sql .="lieu='$this->lieu',jour='$this->jour',debut='$this->debut',fin='$this->fin',idanimateur=$this->idanimateur";
			if ($this->idresponsable) $sql .=", idresponsable=$this->idresponsable";
			if ($this->tarifA) $sql .=", tarifA=$this->tarifA";
			if ($this->tarifC) $sql .=", tarifC=$this->tarifC";
			$sql .=" WHERE id=$this->id";
			//echo $sql."<br>";
		    $retour=$M->querydb($sql);
		    if ($retour) writefileact($tact);			
			$M->close();
		 	return $retour;
		}
		public function insere($tact) {
			$M = new MConf; 
			$sql0 = "INSERT INTO $tact (activite,codactivite,groupe,tarifA,tarifC,";
			$this->activite=addslashes(trim($this->activite));
			$this->groupe = intval(trim($this->groupe));
			$this->codactivite = intval(trim($this->codactivite));
			if ($this->groupe == 0) $this->groupe = 1;
			if ($this->tarifA >0) $this->tarifA = strval($this->tarifA);
			if ($this->tarifC >0) $this->tarifC = strval($this->tarifC);
			$sql1 = " VALUES ('$this->activite',$this->codactivite,$this->groupe,$this->tarifA,$this->tarifC,";
			if ($this->lieu != "lieu") {$sql0 .="lieu,"; $this->lieu=addslashes($this->lieu);$sql1 .="'$this->lieu',";}	
			if ($this->jour != "jour") {$sql0 .="jour,"; $this->jour=addslashes($this->jour);$sql1 .="'$this->jour',";}	
			if ($this->debut != "début") {$sql0 .="debut,"; $this->debut=addslashes($this->debut);$sql1 .="'$this->debut',";}	
			if ($this->fin != "fin") {$sql0 .="fin,"; $this->fin=addslashes($this->fin);$sql1 .="'$this->fin',";}	
			if ($this->idanimateur>0) {$sql0 .="idanimateur,"; $sql1 .="$this->idanimateur,";}
			if ($this->idresponsable>0) {$sql0 .="idresponsable,"; $sql1 .="$this->idresponsable,";}
	    	$sql0=substr($sql0,0,-1).")";
	    	$sql1=substr($sql1,0,-1).")";
			$sql=$sql0.$sql1;
			//echo $sql."<br>";//
		    $retour=$M->querydb($sql);
		    if ($retour) writefileact($tact);			
			$this->id=$M->lastId($tact);
			$M->close();			
		    return $retour;
		} 
	}

	class Gracts {
		public $gract;
		public $n;

		public function writefile($tact) {
			writefileact($tact);
		}

		public function cherche($sql) {
			$M = new MConf; 
	        $reponse=$M->querydb($sql);
	        $this->n=0;$this->gract=array();
	        while ($donnees = $reponse->fetch()) {
				$a = new Gract;
				$a->id=$donnees['id'];
				$a->activite=$donnees['activite'];
				$a->codactivite=$donnees['codactivite'];
				$a->tarifA=$donnees['tarifA'];
				$a->tarifC=$donnees['tarifC'];
				$a->groupe=$donnees['groupe'];
				$a->lieu=$donnees['lieu'];
				$a->jour=$donnees['jour'];
				$a->debut=$donnees['debut'];
				$a->fin=$donnees['fin'];
				$a->idanimateur=$donnees['idanimateur'];
				$a->idresponsable=$donnees['idresponsable'];
				array_push($this->gract, $a);
				$this->n++;
			}
			$M->close();			
		}
		public function cree($tact) {
			$M = new MConf; 
			$sql = "SELECT * FROM $tact";
	        $reponse=$M->querydb($sql);
	        $i=0;$this->gract=array();
	        while ($donnees = $reponse->fetch()) {
				$a = new Gract;
				$a->id = $donnees['id'];
				$a->activite = $donnees['activite'];
				$a->codactivite=$donnees['codactivite'];
				$a->tarifA = $donnees['tarifA'];
				$a->tarifC = $donnees['tarifC'];
				$a->groupe = $donnees['groupe'];
				$a->lieu = $donnees['lieu'];
				$a->jour = $donnees['jour'];
				$a->debut = $donnees['debut'];
				$a->fin = $donnees['fin'];
				$a->idanimateur = $donnees['idanimateur'];
				$a->idresponsable = $donnees['idresponsable'];
				array_push($this->gract, $a);
				$i++;
			}
			$this->n=$i;
			$M->close();			
		}

		public function cree1($tact) {
			$M = new MConf; 
			$sql = "SELECT * FROM $tact";
	        $reponse=$M->querydb($sql);
	        $i=0;$this->gract=array();
	        while ($donnees = $reponse->fetch()) {
				$a = new Gract;
				$a->id = $donnees['id'];
				$a->activite = $donnees['activite'];
				$a->groupe = $donnees['groupe'];
				$a->lieu = $donnees['lieu'];
				$a->jour = $donnees['jour'];
				$a->debut = $donnees['debut'];
				$a->fin = $donnees['fin'];
				$a->idanimateur = $donnees['idanimateur'];
				array_push($this->gract, $a);
				$i++;
			}
			$this->n=$i;
			$M->close();			
		}

		public function getpost($n) {
			//echo "dans getpost ng=".$n."<br>";
			$this->gract=array();
			for ($i=0;$i<$n;$i++) {
				$an='animateur'.strval($i);
				$a = new Gract;
				$a->activite = enspace($_POST['activite']);//echo "activite=".$a->activite."<br>";
				$a->codactivite = $_POST['codactivite'];//echo "code=".$a->codactivite."<br>";
				//$a->animateur = $_POST[$an];
				$a->tarifA = $_POST['tarifA'];
				$a->tarifC = $_POST['tarifC'];
				//echo "animateur=".$a->animateur."<br>";
				$a->idanimateur = $_POST['animateur'.strval($i)];
				$a->idresponsable = $_POST['responsable'.strval($i)];
				$a->groupe = $_POST['groupe'.strval($i)];//echo "groupe=".$a->groupe."<br>";
				$a->lieu = $_POST['lieu'.strval($i)];
				$a->jour = $_POST['jour'.strval($i)];
				$a->debut = $_POST['debut'.strval($i)];
				$a->fin = $_POST['fin'.strval($i)];
				$a->id=$_POST['id'.strval($i)];//echo $a->id."   ".$a->idanimateur."  ".$a->idresponsable."<br>";

				array_push($this->gract, $a);
			}
			$this->n = count($this->gract);
		}
		public function getpost2($n) {
			//echo "dans getpost ng=".$n."<br>";
			$this->gract=array();
			for ($i=0;$i<$n;$i++) {
//				$an='animateur'.strval($i);
				$a = new Gract;
				$a->codactivite = $_POST['codactivite'.strval($i)];//echo "getpost2 code=".$a->codactivite."<br>";echo strlen($optionsactivite)."<br>";
				$a->activite = getoption($optionsactivite,$a->codactivite);//echo "activite=".$a->activite."<br>";
				$a->groupe = $_POST['groupe'.strval($i)];//echo "groupe=".$a->groupe."<br>";
				$a->lieu = $_POST['lieu'.strval($i)];
				$a->jour = $_POST['jour'.strval($i)];
				$a->debut = $_POST['debut'.strval($i)];
				$a->fin = $_POST['fin'.strval($i)];
				$a->id=$_POST['id'.strval($i)];//echo $a->id."   ".$a->idanimateur."  ".$a->idresponsable."<br>";

				array_push($this->gract, $a);
			}
			$this->n = count($this->gract);
		}
		public function getid() {
			//echo "dans getid<br>";
			$i=0;$trouve=false;
      		while ((!$trouve)&&($i<$this->n)) {
            	$trouve=(($this->gract[$i]->activite==$this->gract[$i]->activite0)&&($this->gract[$i]->groupe==$this->gract[$i]->groupe0));
            	if ($trouve) return $this->gract[$i]->id;
            $i++;
          }
          return -1;
		}
		public function getact($id) {
			$i=0;$trouve=false;
      		while ((!$trouve)&&($i<$this->n)) {
            	$trouve=($this->act[$i]->id==$id);
            	if ($trouve) return $this->act[$i]->nom;
            $i++;
          }
          return "";
		}
	}
?>