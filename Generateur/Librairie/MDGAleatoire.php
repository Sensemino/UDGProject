<?php
function MDGAleatoire($min, $max, $nbdecimal){//retourne un numbre aléatoire
  if ($nbdecimal > 0) {
    $val = $min + mt_rand() / mt_getrandmax() * ($max - $min);

    return number_format($val, $nbdecimal);
  } else
  return $val = rand($min, $max);


}
?>
