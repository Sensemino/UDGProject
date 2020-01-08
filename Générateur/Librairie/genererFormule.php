<?php

//calcul le résulat d'une formule de manière dynamique

function genererFormule($formule,$donnees,$NombreDonnee) {

  $TableauResultatFormule = array();
  $indiceTable = 1;
  $formuleTmp = "";

  for($i = 0;$i<count($donnees);$i++)
  {

    $expression = "/".$donnees[$i][1]."/mD";        //Probleme avec plusieurs tables ne garde pas en mémoire les valeurs
    for($j = 2;$j<count($donnees[$i]);$j++)
    {
      $formuleTmp = $formule;
      $formuleTmp = preg_replace($expression,$donnees[$i][$j],$formuleTmp);
      print("$formuleTmp\n");

      array_push($TableauResultatFormule,matheval($formuleTmp));
    } # fin pour
  } # fin pour

  print_r($TableauResultatFormule);

  return $TableauResultatFormule;

} # fin fonction genererFormule
?>
