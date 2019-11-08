<?php
function genererIDS($nbligne, $Prefixe,$Suffixe,&$compteurPassage){//remplie un tableau de concatenatione entre prefixe et suffixe
  $IDSGene = array();

  for ($j = 0; $j < $nbligne; $j++) {
    $IDSGene[$j] = $Prefixe.($Suffixe+$compteurPassage);
    $compteurPassage++;
  }
  return $IDSGene;
}
?>
