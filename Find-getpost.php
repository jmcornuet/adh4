Searching 55 files for "->getpost("

/Users/jmc/Sites/adh3/ajoutActivite.php:
   19  	    include("animateurs.inc");
   20  	    $ga = new Gract;
   21: 	    $ga->getpost();
   22  	    $ga->getnouveaucode();
   23          $an = new Animateur;

/Users/jmc/Sites/adh3/ajoutAdherent.php:
   18  	    include("adherents.inc");
   19  	    $ad = new Adherent;
   20: 	    $ad->getpost();
   21  	    $ad->getcodes();
   22  	    $ad->insere();

/Users/jmc/Sites/adh3/ajoutAnimateur.php:
   18  	    include("animateurs.inc");
   19  	    $an = new Animateur;
   20: 	    $an->getpost();
   21  	    $an->insere();
   22  	    if ($an->id>0) echo "</br></br><div class='alerte'>La fiche de $an->prenom $an->nom a été ajoutée à la base de données avec l'id $an->id </div>";

/Users/jmc/Sites/adh3/ajoutGroupe.php:
    6      include("animateurs.inc");
    7      $ga = new Gract;
    8:     $ga->getpost();
    9      $ga->activite=trim($ga->activite);
   10      $ga->codactivite=trim($ga->codactivite);

/Users/jmc/Sites/adh3/idActivite.php:
   51      $N = new MConf;   
   52      $gract=new Gract;
   53:     $gract->getpost();$gract->activite = $activite[$gract->activite];
   54      $an=new Animateurs;
   55      $an->cree();

/Users/jmc/Sites/adh3/idAdherent.php:
   50  		}
   51      $ad = new Adherent;
   52:     $ad->getpost();
   53      $ad->getcodes();
   54      //echo $ad->activites."<br>";

/Users/jmc/Sites/adh3/idAnimateur.php:
   34      include("animateurs.inc"); 		
   35      $an = new Animateur;
   36:     $an->getpost();
   37  	?>
   38    <div class="titre1">Recherche d'un animateur dans la base de données</div></br>

/Users/jmc/Sites/adh3/modifAdherent.php:
   20  	    include("adherents.inc");
   21  	    $ad = new Adherent;
   22: 	    $ad->getpost();
   23          $ad->getcodes();
   24  	    if ($ad->modifie()) echo "</br></br><div class='alerte'>La fiche de $ad->prenom $ad->nom a bien été modifiée dans la base de données </div>";

/Users/jmc/Sites/adh3/modifAnimateur.php:
   21  	    include("gract.inc");
   22  	    $an = new Animateur;
   23: 	    $an->getpost();
   24  	    $an->id = $an->idanim();
   25  	    $rep = $an->modifie();
   ..
   27  	    else {
   28  		    $gr = new Gracts;
   29: 		    $gr->getpost();
   30  		    $rep = true;
   31  	        for ($i=0;$i<$gr->n;$i++) {

/Users/jmc/Sites/adh3/modifGract.php:
   30          $ga = new Gracts;
   31          $ga->gract=array();
   32:         $ga->getpost();//echo "après getpost<br>";
   33          $ani = new Animateurs;
   34          $ani->cree();

/Users/jmc/Sites/adh3/supprimGroupe.php:
   10  
   11      $ga = new Gract;
   12:     $ga->getpost();
   13      echo $ga->activite."<br>";
   14      echo $ga->codactivite."<br>";

12 matches across 11 files
