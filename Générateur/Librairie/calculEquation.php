<?php

//permet de calculer une formule dans une chaîne de caractère

function matheval($equation){

  if ( $equation == "" ) 
  {
    $resultat = 0;
  } 
  else 
  {
    eval("\$resultat=" . $equation . ";" );
  }
  
  return $resultat;
}

?>