<?php
function LesNulls($null, $nbval){//retourne le nombre de "Null" souhaiter
  if (preg_match("#%#", $null)) {
    $null = str_replace("%","", $null);
    $null = $null / 100;
  }
  if ($null < 1) {
    return $nbval - (round(($nbval * (1 - $null))));
  } else {
    return round($null);
  }
}
?>
