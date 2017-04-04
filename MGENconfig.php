<?php
//Définition de l'objet MConf qui contient le nom de certaines tables de la base de données et qui va servir à interroger les différentes tables 
	class MConf {
		public $annee = '2017';					//numéro de l'année en cours
		private $host = 'localhost';			//nom de l'hôte (toujours localhost)
		private $dbase = 'clubmgen';			//nom de la base de données
		private $ident = 'root';				//identifiant pour l'accès à la base de données (le même qu'avec phpMyAdmin)
		private $passmac = 'root';				//mot de passe sur le Mac
		private $passlinux = '182Villette';		//mot de passe sur le serveur
		public $tablaut = 'authentification';	//nom de la table contenant les login/mots de passe des utilsateurs
		private $tablog = 'tlog2016';			//nom de la table indiquant les connexions/déconnexions et les modifications des tables
		private $bdd;							//nom de l'instance de l'objet PDO qui permet l'accès à la base de données
		private $pass;							//mot de passe choisi en fonction du système (Mac ou Serveur)
		private $jour;							//jour
		private $heure;							//heure
		private $utilisateur;					//utilisateur


		private function open() {	//fonction qui ouvre l'accès à la base
			if (PHP_OS == "Darwin") $this->pass = $this->passmac;	//choix du mot de passe Mac ou pas Mac (serveur)
			else $this->pass = $this->passlinux;
			$this->bdd = new PDO('mysql:host='.$this->host.';dbname='.$this->dbase,$this->ident,$this->pass);	//instanciation d'un accès à la base
			$this->bdd->exec("SET NAMES 'utf8'");						//forçage du codage 'utf8' dans la lecture/écriture des chaînes de caractères	
		}

		private function setinfo() {	//fonction qui récupère les données à transcrire dans la table des log
				setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');			//la date et l'heure seront données en français 
				$this->jour=strftime("%d/%m/%Y");								//récupération du jour
				$this->heure=strftime("%T");									//récupération de l'heure:minute:seconde
				$this->utilisateur=$_SESSION['prenom']." ".$_SESSION['nom'];	//identité de l'utilisateur	
		}

		public function querydb($sql) {			//fonction qui permet d'effectuer toute requête (variable $sql) sur la base de données
	    	$this->open();												//ouverture de l'accès à la base
	    	$reponse=$this->bdd->query($sql);							//envoi de la requête 
	    	$noselect =strpos($sql,"SELECT")+strpos($sql,"FROM");		//variable indiquant si la requête est une lecture simple (contenant "SELECT FROM")
	    	if ($noselect<1) {											//si la requête n'est pas du type "SELECT FROM"
	    		$this->setinfo();										//récupère les données
				$sql=addslashes($sql);									// utile ?
				$sqq = "INSERT INTO $this->tablog (jour,heure,utilisateur,requete) VALUES('$this->jour','$this->heure','$this->utilisateur','$sql')"; //création de la requête
				$r=$this->bdd->query($sqq);								//envoi de la requête
			}
	    	return $reponse;											//retourne la réponse à la première requête 
	    }

	    public function lastId($table) {				//fonction qui retourne l'id de la dernière valeur insérée dans $table
			$sql="SELECT * FROM $table ORDER BY id DESC LIMIT 1";	    	
			$reponse=$this->bdd->query($sql);
	    	$donnees = $reponse->fetch();
	    	return $donnees['id'];
	    	//return $this->bdd->lastInsertId();
	    }
	    public function close() {				//fonction qui ferme l'accès à la base 
	    	$this->bdd = null;
	    }
	    public function connexion() {			//fonction qui note dans la table des log le début de la connexion d'un utilisateur
	    	$this->open();						//ouverture de l'accès à la base
	    	$this->setinfo();					//récupère les données
			$requete="DEBUT DE CONNEXION";		//message indiquant le début de la connexion
			$sessionid=session_id();			//récupération de l'id de session
			$r=$this->bdd->query("INSERT INTO $this->tablog (jour,heure,utilisateur,requete,sessionid) VALUES('$this->jour','$this->heure','$this->utilisateur','$requete','$sessionid')");
																	//envoi de la requête
	    }
	    public function deconnexion() {			//fonction qui note dans la table des log la fin de la connexion d'un utilisateur
	    	$this->open();						//ouverture de l'accès à la base
	    	$this->setinfo();					//récupère les données
			$requete="FIN DE CONNEXION";		//message indiquant la fin de la connexion		
			$sessionid=session_id();			//récupération de l'id de session
			$r=$this->bdd->query("INSERT INTO $this->tablog (jour,heure,utilisateur,requete,sessionid) VALUES('$this->jour','$this->heure','$this->utilisateur','$requete','$sessionid')");
	    }
	    public function getlog() {				//fonction qui renvoie le nom de la table des log
	    	return $this->tablog;
	    }
	}
?>