
<?php
     include("MGENconfig.php");
     function dbf2mysql($file) {
          echo "début de dbf2mysql<br>";
          $table = 'tadhimport';
          $iconvFrom  = '866';
          $iconvTo    = 'UTF-8';
          $delimetr   = ',';
          $rep=$file; echo $rep."<br>";
          $db = dbase_open($file, 0);
          if (!$db) echo "Impossible d'ouvrir la table $file <br>";
          if ($db) {
               $info = dbase_get_header_info($db); print_r($info); 
               $fields = dbase_numfields($db);
               $records = dbase_numrecords($db);
               $sql = array();
               $sql[] = 'CREATE TABLE `' . $table . '` (';
               $columns = array();
               foreach ($info as $i) {
                    if ($i['type'] == 'character') {
                      $type = 'VARCHAR('. $i['length'] . ')';
                    } elseif ($i['type'] == 'number') {
                      $type = 'INT(10)';
                    } elseif ($i['type'] == 'date') {
                      $type = 'DATETIME';
                    } elseif ($i['type'] == 'memo') {
                      $type = 'VARCHAR(500)';
                    }
                    $columns[] = '  `' . strtolower($i['name']) . '` ' . $type;
               }
               $sql[] = implode(',' . PHP_EOL, $columns);
               $sql[] = ');' . PHP_EOL;
               $rep = implode(PHP_EOL, $sql);
          }
          return $rep;  
     }

     $dossier = 'upload/';
     $fichier = basename($_FILES['avatar']['name']);
     $taille_maxi = 500000;
     $taille = filesize($_FILES['avatar']['tmp_name']);
     $extensions = array('.dbf', '.csv','.sql');
     $extension = strrchr($_FILES['avatar']['name'], '.'); 
     //Début des vérifications de sécurité...
     if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
     {
          $erreur = 'Vous devez uploader un fichier de type .dbf, .csv ou .sql';
     }
     if($taille>$taille_maxi)
     {
          $erreur = 'Le fichier est trop gros...';
     }
     if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
     {
          //On formate le nom du fichier ici...
          $fichier = strtr($fichier, 
               'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
               'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
          $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
          if(move_uploaded_file($_FILES['avatar']['tmp_name'], $dossier . $fichier)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
          {
               echo 'Upload effectué avec succès ! <br>';
               $sql = dbf2mysql($dossier . $fichier);
               echo $sql."<br>";
               /*$M = new MConf;
               $reponse = $M->querydb($sql);
               if($reponse) echo "Table insérée avec succès <br>";*/
          }
          else //Sinon (la fonction renvoie FALSE).
          {
               echo 'Echec de l\'upload !';
          }
     }
     else
     {
          echo $erreur;
     }
?>