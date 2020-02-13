<?php

//calcul le résulat d'une formule de manière dynamique

function genererFormule($formule,$donnees,$NombreDonnee) {

  $TableauResultatFormule = array();
  $tableauDonneePourFormule = array();
  $formuleTmp = $formule;
  $Null = false;

  for($i=0;$i<count($donnees);$i++)             //Boucle pour récupérer les données correspond à la formule en fonction des nom de colonne trouvé dans la formule
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

  for($i = 1;$i<=$NombreDonnee;$i++)          //Boucle pour remplacer les noms des colonnes par les valeurs et calcul de la formule
  {
    $tableauResultatTmp = array();
    $tableauResultatTmp = array_column($tableauDonneePourFormule,$i);     //permet de récupérer toutes les données à la case $i dans le tableauDonneePourFormule

    foreach($tableauResultatTmp as $cle=>$valeur)       //boucle pour remplacer les noms des colonnes par les valeurs correspondantes
    {
      if(isset($valeur))
      {
        $formuleTmp = preg_replace("/".$tableauDonneePourFormule[$cle][0]."/mD",$valeur,$formuleTmp);
      }
      else
      {
        $Null = true;
      }
        
    } #fin pour

    if($Null != true)
    {
      array_push($TableauResultatFormule,matheval($formuleTmp));           //on met dans le tableauResultatFormule le resultat calculé par la fonction matheval
    }
    else
    {
      array_push($TableauResultatFormule,null);
    }
    $formuleTmp = $formule;                 //On réinitialise la formuleTmp pour changer les données
    $Null = false;

    unset($tableauResultatTmp);
  } # fin pour

  return $TableauResultatFormule;

} # fin fonction genererFormule
?>
