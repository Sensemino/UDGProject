<?php
   	
function FoncEcrireJson($donnees, $nomfic, $nbligne, $sortie, $premierpassage){ //ecriture de la sortie au format JSON

   //$reference = array();
   for ($i=0; $i < count($donnees); $i++) { 
      //array_push($reference, array_shift($donnees[$i]));
      if($premierpassage == 0) {
        array_shift($donnees[$i]);
      }
   }

   $myFile = $sortie.$nomfic.".json";

   $datafin = array();
   $en_tetes = array();


   // Dans un premier temps, on parcourt notre tableau et retire les en-tetes.
   for ($i=0; $i < count($donnees); $i++) { 
      $en_tetes[$i] = array_shift($donnees[$i]);
   }

   // On sait désormais que $donnees ne contient plus que les données sans les en-tetes.
   for ($i=0; $i < $nbligne; $i++) { 

      // C'est dans $row que nous allons écrire les données qui pour chaque en-tete contient une valeur (possiblement nulle selon le fichier de configuration)
      $row = array();

      for ($j=0; $j < count($en_tetes); $j++) { 
      
         $row[$en_tetes[$j]] = $donnees[$j][$i];         

      }

      $datafin[$i] = $row;

   }
   echo("Tableau datafin : ");
   print_r($datafin);
   echo("\n");
   echo("Tableau en_tetes : ");
   print_r($en_tetes);
   echo("\n");

   //Convert updated array to JSON
   $jsondata = json_encode($datafin, JSON_PRETTY_PRINT);

   print_r($jsondata);

   //write json data into data.json file
   file_put_contents($myFile, $jsondata, FILE_APPEND);   
}


?>