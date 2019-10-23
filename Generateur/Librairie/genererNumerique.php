<?php
function genererNumerique($nbligne, $min, $max, $nbdecimal){//remplie un tableau de nombre aléatoire entre bornes
  $NumGene = array();
  for ($j = 0; $j < $nbligne; $j++) {
    $NumGene[$j] = MDGAleatoire($min, $max, $nbdecimal);
  }
  return $NumGene;
}
?>
