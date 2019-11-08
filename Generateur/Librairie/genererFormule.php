<?php
function genererFormule($formule,$donnees,$NombreDonnee){     //calcul le résulat d'une formule de manière dynamique
  $TableauResultatFormule = array();
  $TableauFormule = (explode(" ", $formule));
  $tableauNomPerso = array();               //Tableau qui contient les différents noms persos dans la formule
  $tableauIndiceOperateur = array();        //Contient les indices pour savoir où se trouve les opérateurs dans le tableauFormule
  $tableauDonneesTables = array();          //Tableau qui contient toutes les données correspondant aux noms persos
  $tableauTableTrouve = array();            //Tableau qui permet de savoir quand le tableauDonneesTables doit prendre les données
  $operateur = '*';

  //Récupération des opérateurs et des chaines de caractères dans la formule
  foreach($TableauFormule as $indiceTableauFormule=>$valeur)
  {
    $operateur = connaitreOperateur($valeur);                             //Permet de savoir si c'est un opérateur et lequel
    if($operateur != Null)
    {
      array_push($tableauIndiceOperateur,$indiceTableauFormule);          //Récupere l'indice des opérateurs pour savoir où il se trouve dans le tableauFormule
    }
    elseif(is_string($valeur) && !preg_match('#^[0-9,\s\.-]+$#', $valeur))      //Vérifie si la formule contient une chaine de caractere qui ne contient pas de nombre
    {
      array_push($tableauNomPerso,$valeur);                 //Récupère tout les nomsPerso contenu dans la formule
    }
  }

  //Enregistre les données correspondant à la formule
  foreach($donnees as $indicePremiereColonne=>$premiereColonne)
  {
    $tableauTemporaire = array();                   //Permet d'enregistrer dans un autre tableau toutes les données
    foreach($premiereColonne as $deuxiemeColonne)
    {
      foreach($tableauNomPerso as $valeurBool)
      {
        if($deuxiemeColonne == $valeurBool)
        {
          $tableauTableTrouve[$indicePremiereColonne] = True;       //Permet de chercher toutes les données correspondant à la colonne dans $tableauNomPerso
        }
      }
      if(isset($tableauTableTrouve[$indicePremiereColonne]) && $tableauTableTrouve[$indicePremiereColonne] = True)
        {
          array_push($tableauTemporaire,$deuxiemeColonne);          //Enregistre toutes les données de la colonne trouvée
        }
    }
    $tableauTableTrouve[$indicePremiereColonne] = False;
    if($tableauTemporaire != Null)
    {
      array_push($tableauDonneesTables,$tableauTemporaire);               //Enregistre toutes les données de la colonne plus le nom de la colonne
    }
  }

  //réalisation du calcul
  for($i=0;$i<$NombreDonnee;$i++)
  {
    $premierPassage = 1;
    foreach($TableauFormule as $indiceTableauFormule=>$valeur)      //Parcours le tableau formule
    {
      if($premierPassage == 1)
      {
        if(!preg_match('#^[0-9,\s\.-]+$#', $valeur) && is_string($valeur))    //Vérifie si c'est une chaine de caractère
        {
          foreach($tableauDonneesTables as $donneesColonne)           //Parcours le tableau avec les données
          {
            if($TableauFormule[$indiceTableauFormule] == $donneesColonne[0] && $donneesColonne[$i+1] != Null)     //Cherche le nom perso de la colonne pour ensuite rentrer les données
            {
              $TableauResultatFormule[$i] = $donneesColonne[$i+1];          //Enregistre les données
            }
          }
        }
        elseif(isset($TableauFormule[$indiceTableauFormule+1]))             //Vérifie si il reste un opérateur
        {
          $TableauResultatFormule[$i] = $TableauFormule[$indiceTableauFormule];       //Si ce n'est pas une chaine de caractère, enregistre simplement la constante
        }
      }
      //On doit savoir si c'est un opérateur car le nombre de calcul est effectué en fonction du nombre d'opérateur

      $operateur = connaitreOperateur($valeur);                     //Permet de savoir si c'est un opérateur
      
      if($operateur != Null && is_numeric($TableauFormule[$indiceTableauFormule+1]) && !is_null($TableauResultatFormule[$i]))   //Vérifie si c'est un opérateur et si la case suivante est une constante
      {
        $TableauResultatFormule[$i] = calculOperation($TableauFormule[$indiceTableauFormule],$TableauResultatFormule[$i],$TableauFormule[$indiceTableauFormule+1]);
      }
      elseif($operateur != Null && !is_null($TableauFormule[$indiceTableauFormule+1]))      //Si la case suivante n'est pas une constante alors cherche la donnée de la colonne correspondante
      {
        foreach($tableauDonneesTables as $donneesColonne)
        {
          if(isset($TableauFormule[$indiceTableauFormule+1]) && $TableauFormule[$indiceTableauFormule+1] == $donneesColonne[0] && $donneesColonne[$i+1] != Null)
          {
            $TableauResultatFormule[$i] = calculOperation($TableauFormule[$indiceTableauFormule],$TableauResultatFormule[$i],$donneesColonne[$i+1]);
            
          }
        }
      }
      $premierPassage++;
    }
    $premierPassage = 1;
  }
  return $TableauResultatFormule;
}
?>