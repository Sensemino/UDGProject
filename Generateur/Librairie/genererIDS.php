<?php
function genererIDS($nbligneagenerer, $nbligne, $Prefixe,$Suffixe,&$compteurPassage){//rempli un tableau de concatenations entre prefixe et suffixe
  $IDSGene = array();

  $tailleSuffixeMax = strlen($nbligne+$Suffixe);

  $suffixeModifie=str_pad(strval($suffixe),$tailleSuffixeMax,0,STR_PAD_LEFT);

  print($suffixeModifie);
  for ($j = 0; $j < $nbligneagenerer; $j++) {
    
    $IDSGene[$j] = $Prefixe.($suffixeModifie+$compteurPassage);
    $compteurPassage++;
  }
  return $IDSGene;
}
?>