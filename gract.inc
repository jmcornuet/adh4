<?php
require_once("MGENconfig.php");
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
			$sql = "SELECT codactivite FROM $tact";
			$reponse=$M->querydb($sql);
		    $codac = 0;
		    while ($donnees = $reponse->fetch()) {
		    	$a=$donnees['codactivite'];
		    	if ($a>$codac) $codac = $a;
		    }
		    $this->codactivite = $codac+1;		    
			$M->close();			
		}
		public function getid($tact) {
			$M = new MConf; 
			$this->codactivite=trim($this->codactivite);
			//echo "dans getid codactivite=".$this->codactivite."    groupe=".$this->groupe."<br>";
			$sql = "SELECT id FROM $tact WHERE codactivite='$this->codactivite' AND groupe=$this->groupe";
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
			$this->animateur=$_POST['animateur'];
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
			$sql = "DELETE FROM $tact WHERE id=$this->id";
		    $reponse=$M->querydb($sql);
			$M->close();			
		 	return $reponse;
		}
		public function modifie($tact) {
			$this->activite=addslashes($this->activite);//echo $this->activite."<br>";
			//echo $this->lieu."<br>";
			//echo "id=".$this->id."<br>";
			$M = new MConf; 
			$sql = "UPDATE $tact SET activite='$this->activite', codactivite='$this->codactivite', groupe=$this->groupe,";
			$sql .="lieu='$this->lieu',jour='$this->jour',debut='$this->debut',fin='$this->fin',idanimateur=$this->idanimateur";
			if ($this->tarifA) $sql .=", tarifA=$this->tarifA";
			if ($this->tarifC) $sql .=", tarifC=$this->tarifC";
			$sql .=" WHERE id=$this->id";
			//echo $sql."<br>";
		    $reponse=$M->querydb($sql);
			$M->close();			
		 	return $reponse;
		}
		public function insere($tact) {
			$M = new MConf; 
			$sql0 = "INSERT INTO $tact (activite,codactivite,groupe,tarifA,tarifC,";
			$this->activite=addslashes($this->activite);
			$this->groupe = strval($this->groupe);
			if ($this->groupe == 0) $this->groupe = 1;
			if ($this->tarifA >0) $this->tarifA = strval($this->tarifA);
			if ($this->tarifC >0) $this->tarifC = strval($this->tarifC);
			$sql1 = " VALUES ('$this->activite','$this->codactivite',$this->groupe,$this->tarifA,$this->tarifC,";
			if ($this->lieu != "lieu") {$sql0 .="lieu,"; $this->lieu=addslashes($this->lieu);$sql1 .="'$this->lieu',";}	
			if ($this->jour != "jour") {$sql0 .="jour,"; $this->jour=addslashes($this->jour);$sql1 .="'$this->jour',";}	
			if ($this->debut != "début") {$sql0 .="debut,"; $this->debut=addslashes($this->debut);$sql1 .="'$this->debut',";}	
			if ($this->fin != "fin") {$sql0 .="fin,"; $this->fin=addslashes($this->fin);$sql1 .="'$this->fin',";}	
			if ($this->idanimateur>0) {$sql0 .="idanimateur,"; $sql1 .="$this->idanimateur,";}
	    	$sql0=substr($sql0,0,-1).")";
	    	$sql1=substr($sql1,0,-1).")";
			$sql=$sql0.$sql1;
			//echo $sql."<br>";die("");
		    $reponse=$M->querydb($sql);
		    //echo "après réponse<br>";
			$this->id=$M->lastId();
			//echo "après lastId<br>";
			$M->close();			
		    //echo "fin de insere()<br>";
		} 
	}

	class Gracts {
		public $gract;
		public $n;

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
				$a->animateur = $_POST[$an];//echo "animateur=".$a->animateur."<br>";
				//$a->animateur = $animateur[$_POST['animateur'.strval($i)]];
				$a->groupe = $_POST['groupe'.strval($i)];//echo "groupe=".$a->groupe."<br>";
				$a->lieu = $_POST['lieu'.strval($i)];
				$a->jour = $_POST['jour'.strval($i)];
				$a->debut = $_POST['debut'.strval($i)];
				$a->fin = $_POST['fin'.strval($i)];
				$a->id=$_POST['id'.strval($i)];

				array_push($this->gract, $a);
			}
			$this->n = count($this->gract);
		}
		public function getid() {
			echo "dans getid<br>";
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