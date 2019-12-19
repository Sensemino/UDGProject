<?php

#############################################################################################

function genererIDS($nbligneagenerer, $nbligne, $Prefixe,$Suffixe,&$compteurPassage,$nbChiffres=3) {

// remplit un tableau de concatenations entre prefixe et suffixe

#############################################################################################

  $IDSGene = array();

  $tailleSuffixeMax = strlen($nbligne+$Suffixe) ; // On recupere le nombre de zeros que l'on souhaite

  for ($j = 0 ; $j < $nbligneagenerer; $j++) { // tant qu'on a une ligne à generer

    $val = $Suffixe + ($compteurPassage+1) ; // Suffixe est incrementee

    $suffixeModifie = sprintf("%'.0".$nbChiffres."d",$val); // On ajoute a suffixe tous les zeros

    $IDSGene[$j] = $Prefixe.$suffixeModifie; // On remplit le tableau avec les valeurs concatenee

    $compteurPassage++;

  } # fin pour j

  # print_r($IDSGene) ;

  return $IDSGene;

} # fin de fonction genererIDS

#############################################################################################

function genererID($nbligneagenerer, $nbligne, &$compteurPassage) {

// remplit un tableau de valeurs auto incrementees

#############################################################################################

  $IDGene = array();

  for ($j = 0 ; $j < $nbligneagenerer; $j++) { // tant qu'on a une ligne à generer

    $val = ($compteurPassage+1) ; // Suffixe est incrementee

    $IDGene[$j] = $val ;

    $compteurPassage++;

  } # fin pour j

  # print_r($IDGene) ;

  return $IDGene;

} # fin de fonction genererID

?>
