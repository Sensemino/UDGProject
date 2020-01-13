<?php

//permet de calculer une formule dans une chaîne de caractère

function matheval($equation){

  if ( $equation == "" ) 
  {
    $resultat = 0;
  }
  elseif((preg_match("/(\/\s0|\/0)\b([^\.]|\z)/",$equation)) || preg_match("/(\/\spow\(0|\/pow\(0)\b[^\.]/",$equation))
  {
    $resultat = NULL;
  } 
  else 
  {
    eval("\$resultat=" . $equation . ";" );
  }
  
  return $resultat;
}

?>