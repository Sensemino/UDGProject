<?php

//permet de calculer une formule dans une chaîne de caractère


function matheval($equation){

  if ( $equation == "" ) 
  {
    $resultat = 0;
  }
  else 
  {
    
    error_clear_last();   //Efface la dernière erreur
    try
    {
      @eval("\$resultat=" . $equation . ";" );    //Calcul de la formule
      
      $e = error_get_last();                      // Récupère la dernière erreur
      
      if ($e !== null && $e['message'] == 'Division by zero')       //Vérifie si la dernière erreur correspond à la division par 0
      {
        echo "\nDivision par zéro pour $equation\n\n";
        $resultat = NULL;
      }# fin si
    }
    catch(ParseError $e)              //S'il y a une erreur de syntaxe dans la formule
    {
      echo "\nErreur dans la formule, vérifiez l'écriture de la formule\n";
      $resultat = NULL;
    } #fin try catch
  }#fin si

  return $resultat;
}

?>
