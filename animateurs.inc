<?php
require_once("MGENconfig.php");
	class Animateur {
		public $id;
		public $nom;
		public $tanirenom;
		public $telephone;
		public $taniortable;
		public $courriel;
		public $benevole;
		public $animateur;

		public function getpost() {
			$this->id=$_POST['id'];
			$this->nom=$_POST['nom'];
			$this->prenom=$_POST['prenom'];
			$this->telephone=$_POST['telephone'];
			$this->portable=$_POST['portable'];
			$this->courriel=$_POST['courriel'];
			$this->benevole=$_POST['benevole'];
			if ($_POST['animateur']) $this->animateur=$_POST['animateur'];
			else $this->animateur=$this->prenom." ".$this->nom;
		}
		public function getani($tani) {
			$M = new MConf;
			$sql = "SELECT * FROM $tani WHERE id=$this->id";
		    $reponse=$M->querydb($sql);
			$donnees=$reponse->fetch();
			if ($donnees) {
				$this->id=$donnees['id'];
				$this->nom=$donnees['nom'];
				$this->prenom=$donnees['prenom'];
				$this->telephone=$donnees['telephone'];
				$this->portable=$donnees['portable'];
				$this->courriel=$donnees['courriel'];
				$this->benevole=$donnees['benevole'];
			}
			$M->close();			
		}
		public function anim($tani) {
			$M = new MConf;
			$sql = "SELECT animateur FROM $tani WHERE id=$this->id";
		    $reponse=$M->querydb($sql);
			$donnees=$reponse->fetch();
			if ($donnees) return $donnees['animateur'];
			else return "";
			$M->close();
		}
		public function idanim($tani) {
			$M = new MConf;
			$sql = "SELECT id FROM $tani WHERE animateur='$this->animateur'";
		    $reponse=$M->querydb($sql);
			$donnees=$reponse->fetch();
			$M->close();
			if ($donnees) return $donnees['id'];
			else return "";
		}

		public function supprime($tani) {
			$M = new MConf;
			$sql = "DELETE FROM $tani WHERE id=this->id";
		    $reponse=$M->querydb($sql);
		    $M->close();
		}
		public function modifie($tani) {
			$M = new MConf;
			$this->animateur = $this->prenom." ".$this->nom;
			$sql = "UPDATE $tani SET nom='$this->nom', prenom='$this->prenom', telephone='$this->telephone', portable='$this->portable', courriel='$this->courriel', benevole='$this->benevole', animateur='$this->animateur' WHERE id=$this->id";
			//echo $sql."<br>";
		    $reponse=$M->querydb($sql);
		    //if ($reponse) echo "Modification effectuee<br>";
		    $M->close();
		    return $reponse;
		}
		public function insere($tani) {
			$M = new MConf;
			$sql = "INSERT INTO $tani (nom, prenom, telephone, portable, courriel, benevole, animateur)";
			$sql .=" VALUES ('$this->nom', '$this->prenom', '$this->telephone', '$this->portable', '$this->courriel', '$this->benevole', '$this->animateur')";
		    $reponse=$M->querydb($sql);
		    $this->id=$M->lastId();
		    $M->close();
		}

	}

	class Animateurs {
		public $ani;
		public $n;
		private $a;
		public function cree($tani) {
			$M = new MConf;
			$sql = "SELECT * FROM $tani";
	        $reponse=$M->querydb($sql);
	        $i=0;$this->ani=array();
	        while ($donnees = $reponse->fetch()) {
				$a = new Animateur;
				//echo "apres le new</br>";
				$a->id = $donnees['id'];
				$a->nom = $donnees['nom'];
				$a->prenom = $donnees['prenom'];
				$a->telephone = $donnees['telephone'];
				$a->portable = $donnees['portable'];
				$a->courriel = $donnees['courriel'];
				$a->benevole = $donnees['benevole'];
				$a->animateur = $donnees['animateur'];
				array_push($this->ani, $a);
				$i++;
			}
			$this->n=$i;
			$M->close();
		}
		public function cherche($sql) {
			$M = new MConf;
	        $reponse=$M->querydb($sql);
	        $this->n=0;$this->ani=array();
	        while ($donnees = $reponse->fetch()) {
				$a = new Animateur;
				$a->id=$donnees['id'];
				$a->nom=$donnees['nom'];
				$a->prenom=$donnees['prenom'];
				$a->telephone=$donnees['telephone'];
				$a->portable=$donnees['portable'];
				$a->courriel=$donnees['courriel'];
				$a->benevole=$donnees['benevole'];
				array_push($this->ani, $a);
				$this->n++;
			}
			$M->close();
		}
		public function getid($tanirenomnom) {
			//echo "dans getid ".$tanirenomnom."<br>";
			if ($tanirenomnom=="Animateur") return 0;
			$i=0;$trouve=false;
      		while ((!$trouve)&&($i<$this->n)) {
            	$trouve=($this->ani[$i]->prenom." ".$this->ani[$i]->nom == $tanirenomnom);
            	if ($trouve) return $this->ani[$i]->id;
            	$i++;
          	}
          	return -1;
		}
		public function getnomprenom($id) {
			$i=0;$trouve=false;
      		while ((!$trouve)&&($i<$this->n)) {
            	$trouve=($this->ani[$i]->id==$id);
            	if ($trouve) {
            		//echo $this->ani[$i]->prenom." ".$this->ani[$i]->nom."<br>";
            		return $this->ani[$i]->prenom." ".$this->ani[$i]->nom;
            	}            	
            	$i++;
          	}
          	return $rep;
		}

	}
	//echo "chargement de animateurs.inc<br>";
?>