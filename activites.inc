<?php
	class Activite {
		public $id;
		public $activite;
		public $tarifA;
		public $tarifC;
		public $groupe;
		public $lieu;
		public $jour;
		public $debut;
		public $fin;
		public $idanimateur;
		
		public function getact() {
			$sql = "SELECT * FROM tgract2016 WHERE id=$this->id";
			$bdd = new PDO('mysql:host=localhost;dbname=clubmgen','root','root');
		    $reponse=$bdd->query($sql);
			$donnees=$reponse->fetch();
			if ($donnees) {
				$this->id=$donnees['id'];
				$this->actvite=$donnees['activite'];
				$this->tarifA=$donnees['tarifA'];
				$this->tarifC=$donnees['tarifC'];
				$this->groupe=$donnees['groupe'];
				$this->lieu=$donnees['lieu'];
				$this->jour=$donnees['jour'];
				$this->debut=$donnees['debut'];
				$this->fin=$donnees['fin'];
				$this->idanimateur=$donnees['idanimateur'];
			}			
		}
		public function getpost() {
			$this->id=$_POST['id'];
			$this->actvite=$_POST['activite'];
			$this->tarifA=$_POST['tarifA'];
			$this->tarifC=$_POST['tarifC'];
			$this->groupe=$_POST['groupe'];
			$this->lieu=$_POST['lieu'];
			$this->jour=$_POST['jour'];
			$this->debut=$_POST['debut'];
			$this->fin=$_POST['fin'];
			$this->idanimateur=$_POST['idanimateur'];
		} 
		public function supprime() {
			$sql = "DELETE FROM tgract2016 WHERE id=this->id";
			$bdd = new PDO('mysql:host=localhost;dbname=clubmgen','root','root');
		    $reponse=$bdd->query($sql);
		    $bdd=null;
		 	return $reponse;
		}
		public function modifie() {
			$this->activite=addslashes($this->activite);
			$this->lieu=addslashes($this->lieu);
			$this->jour=addslashes($this->jour);
			$this->debut=addslashes($this->debut);
			$this->fin=addslashes($this->fin);
			$sql = "UPDATE tactivites2016 SET activite='$this->activite', tarifA=$this->tarifA, tarifC=$this->tarifC, groupe=$this->groupe,";
			$sql .="lieu='$this->lieu',jour='$this->lieu',debut='$this->debut',fin='$this->fin',idanimateur=$this->idanimateur WHERE id=$this->id";
			$bdd = new PDO('mysql:host=localhost;dbname=clubmgen','root','root');
		    $reponse=$bdd->query($sql);
		    $bdd=null;
		 	return $reponse;
		}
		public function insere() {
			$this->activite=addslashes($this->activite);
			$this->lieu=addslashes($this->lieu);
			$this->jour=addslashes($this->jour);
			$this->debut=addslashes($this->debut);
			$this->fin=addslashes($this->fin);
			$sql = "INSERT INTO tactivites2016 (activite, tarifA, tarifC, groupe,lieu,jour,debut,fin,idanimateur)";
			$sql .=" VALUES ('$this->activite',$this->tarifA,$this->tarifC,$this->groupe,'$this->lieu','$this->jour','$this->debut','$this->fin','$this->idanimateur')";
			$bdd = new PDO('mysql:host=localhost;dbname=clubmgen','root','root');
		    $reponse=$bdd->query($sql);
			$this->id=$bdd->lastInsertId();
		    $bdd=null;
		 	return $reponse;
		}

	}
	class Activites {
		public $act;
		public $n;

		public function cree($p) {
			$sql = "SELECT * FROM tactivites2016";
			$bdd = new PDO('mysql:host=localhost;dbname=clubmgen','root','root');
	        $reponse=$bdd->query($sql);
	        $i=0;$this->act=array();
	        while ($donnees = $reponse->fetch()) {
				$a = new Activite;
				$a->id = $donnees['id'];
				$a->nom = $donnees['activite'];
				$a->tarifA = $donnees['tarifA'];
				$a->tarifC = $donnees['tarifC'];
				$a->ngroupes = $donnees['ngroupes'];
				array_push($this->act, $a);
				if ($p) $this->act[$i]->ecrit();
				$i++;
			}
			$this->n=$i;
			$bdd=null;
			//echo "</br>fin de cree  $this->n</br>";
		}
		public function getid($a) {
			$i=0;$trouve=false;
      		while ((!$trouve)&&($i<$this->n)) {
            	$trouve=($this->act[$i]->nom==$a);
            	if ($trouve) return $this->act[$i]->id;
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