<?php
function TestNull($donnees, $numligne){//test l'existence de null sur la même ligne
  $value = "False";
  for ($j = 0; $j < count($donnees); $j++) {
    if(isset($donnees[$j][$numligne])){
      if ($donnees[$j][$numligne] == NULL) {
        $value = "True";//retourne vrai si il éxiste une valeur Null sur la ligne
      }
    }
  }
  return $value;
}
?>
