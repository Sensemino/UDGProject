<?php
function imc($donnees,$nbligne,$lignemat) //Calcul de l'imc (poids / taille^2)
{
  $i = 0;
  $j = 0;
  $indexPoids = 0;            //Permet de connaître l'emplacement dans le tableau de la table poids
  $indexTaille = 0;           //idem mais pour la taille
  $resultatIMC = array();
  $donneesPoids = array();
  $donneesTailles = array();

  // Gestion de l'écriture des nom de tables pour correspondre à "Taille(s)" et "Poids"
  foreach($donnees as $indicePremiereColonne=>$premiereColonne)
  {
      foreach($premiereColonne as $indiceDeuxiemeColonne=>$deuxiemeColonne2)
      {
      if (is_string($deuxiemeColonne2) && !preg_match('#^[0-9,\s\.-]+$#', $deuxiemeColonne2))
      {
          $donnees[$indicePremiereColonne][$indiceDeuxiemeColonne] = strtolower($donnees[$indicePremiereColonne][$indiceDeuxiemeColonne]);
          $donnees[$indicePremiereColonne][$indiceDeuxiemeColonne] = ucfirst($donnees[$indicePremiereColonne][$indiceDeuxiemeColonne]);
      }
      }
  }

  // Gestion des colonne où doit apparaitre 'Poids' et 'Taille'
  for($i = 0;$i<$lignemat;$i++)
  {
    for($j = 0;$j<=$nbligne;$j++)
    {
      if($donnees[$i][$j] == 'Poids' )
      {
        $indexPoids = $j;
      }
      if($donnees[$i][$j] == 'Taille' || $donnees[$i][$j] == 'Tailles')
      {
        $indexTaille = $j;
      }
    }
    for($j = 0;$j<=$nbligne;$j++)
    {
      if($donnees[$i][$indexPoids] == 'Poids' && is_numeric($donnees[$i][$j]))
      {
        $donneesPoids[$j-2] = $donnees[$i][$j];
      }
      if($donnees[$i][$indexTaille] == 'Taille' || $donnees[$i][$j] == 'Tailles' && is_numeric($donnees[$i][$j]))
      {
        $donneesTailles[$j-2] = $donnees[$i][$j];
      }
    }
  }

  // Remplissage du tableau $resultatIMC
  for($i = 0; $i<$nbligne-1; $i++)
  {
    if($donneesPoids[$i] == 'NULL' || $donneesTailles[$i] == 'NULL')
    {
      $resultatIMC[$i] = 'NULL';
    }
    else
    {
      if($donneesPoids[$i] > 0 && $donneesTailles[$i] > 0)
      {
        $resultatIMC[$i] = $donneesPoids[$i]/($donneesTailles[$i]*$donneesTailles[$i]);
      }
      else
        $resultatIMC[$i] = 0;
    }
  }
  return $resultatIMC;
}
?>
