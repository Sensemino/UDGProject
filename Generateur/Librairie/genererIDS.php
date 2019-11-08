<?php
function genererIDS($nbligneagenerer, $nbligne, $Prefixe,$Suffixe,&$compteurPassage){//rempli un tableau de concatenations entre prefixe et suffixe
  $IDSGene = array();

  $tailleSuffixeMax = strlen($nbligne+$Suffixe); //On recupere le nombre de zeros que l'on souhaite

  for ($j = 0; $j < $nbligneagenerer; $j++) //tant qu'on a une ligne à generer
  {

    $val = $Suffixe+$compteurPassage; //Suffixe est incrementee

    $suffixeModifie = sprintf("%'.0".$tailleSuffixeMax."d",$val); //On ajoute a suffixe tous les zeros
    
    $IDSGene[$j] = $Prefixe.$suffixeModifie; //On rempli le tableau avec les valeurs concatenee

    $compteurPassage++;
  }
  return $IDSGene;
}
?>