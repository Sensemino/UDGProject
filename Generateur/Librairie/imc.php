<?php
function imc($donnees,$nbligne,$lignemat) //Calcul de l'imc (poids / taille^2)
{
  $i = 0;
  $j = 0;
  $donneeRetourne = array();
  $donneesPoids = array();
  $donneesTailles = array();

  // Gestion des colonne où doit apparaitre 'Poids' et 'Taille'
  for($j = 0; $j<$lignemat; $j++)
  {
    for($i = 0; $i<$nbligne; $i++)
    {
      if($donnees[$j][0] == 'Poids' )
      {
        $donneesPoids[$i] = $donnees[$j][$i];
      }
      if($donnees[$j][0] == 'Taille')
      {
        $donneesTailles[$i] = $donnees[$j][$i];
      }
    }
  }

  // Remplissage du tableau $donneeRetourne
  for($i = 1; $i<$nbligne; $i++)
  {
    if($donneesPoids[$i] == 'NULL' || $donneesTailles[$i] == 'NULL')
    {
      $donneeRetourne[$i] = 'NULL';
    }
    else
    {
      if($donneesPoids[$i] > 0 && $donneesTailles[$i] > 0)
      {
        $donneeRetourne[$i] = $donneesPoids[$i]/($donneesTailles[$i]*$donneesTailles[$i]);
      }
      else
      $donneeRetourne[$i] = 0;
    }
  }
  return $donneeRetourne;
}
?>
