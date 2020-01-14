<?php

//calcul le résulat d'une formule de manière dynamique

function genererFormule($formule,$donnees,$NombreDonnee) {

  $TableauResultatFormule = array();
  $tableauDonneePourFormule = array();
  $formuleTmp = $formule;

  for($i=0;$i<count($donnees);$i++)
  {
    if(preg_match("/".$donnees[$i][1]."/mD",$formule))
    {
      $tableauDonneeTmp = array();

      for($j = 1;$j<count($donnees[$i]);$j++)
      {
        array_push($tableauDonneeTmp,$donnees[$i][$j]);
      } # fin pour

      array_push($tableauDonneePourFormule,$tableauDonneeTmp);
      unset($tableauDonneeTmp);
    } # fin si
  } # fin pour

  for($i = 1;$i<=$NombreDonnee;$i++)
  {
    $tableauResultatTmp = array();
    $tableauResultatTmp = array_column($tableauDonneePourFormule,$i);

    foreach($tableauResultatTmp as $cle=>$valeur)
    {
      $formuleTmp = preg_replace("/".$tableauDonneePourFormule[$cle][0]."/mD",$valeur,$formuleTmp);
    } #fin pour

    array_push($TableauResultatFormule,matheval($formuleTmp));
    $formuleTmp = $formule;

    unset($tableauResultatTmp);
  } # fin pour

  return $TableauResultatFormule;

} # fin fonction genererFormule
?>
