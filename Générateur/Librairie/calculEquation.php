<?php

//permet de calculer une formule dans une chaîne de caractère

function matheval($equation){

  $equation = preg_replace("/[^0-9+\-.*\/()%]/","",$equation);
  $equation = preg_replace("/([+-])([0-9]+)(%)/","*(1\$1.\$2)",$equation);
  $equation = preg_replace("/([0-9]+)(%)/",".\$1",$equation);
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