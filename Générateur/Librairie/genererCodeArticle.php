<?php

function genererCaractereMasque($masque, $lettresTab) {

  $reference = "" ;

  if ($masque == 'X' || $masque == 'y') { // si c'est un X ou un y
    // on génère une lettre de l'alphabet au hasard (entre 0 et 25)
    $lettre = $lettresTab[rand(0, 25)];

    if($masque == 'y' && rand(0,1) == 1) { // si c'est un y et que l'aléatoire est égal à 1
        $lettre = strtolower($lettre); // la lettre est minuscule
    } # finsi

    $reference .= $lettre;
  } elseif($masque == '9') { // sinon si c'est un 9
    // on génère un nombre entre 0 et 9
    $reference .= rand(0,9);
  } elseif($masque == '1')  { // sinon c'est un 1
    // on génère un nombre en 1 et 9
    $reference .= rand(1,9);
  } elseif ($masque != '?') { // sinon si ce n'est pas un "?"
    $reference .= $masque; // on garde le caractère original
  } # fin si

  ## echo " a partir de $masque on produit $reference \n" ;

  return $reference;

} # fin fonction genererCaractereMasque

// retourne une référence avec un masque passé en paramètre

function genererCodeArticle($nbligne,$masque) {

  $alphabet   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $lettresTab = str_split($alphabet); // découpe la chaîne dans un tableau.

  $sortie = array() ;

  for ($i=0; $i<$nbligne ; $i++) {
    $reference = null;

    for ($j=0 ; $j<strlen($masque) ; $j++) { // on parcourt la chaîne caractère par caractère
      $reference .= genererCaractereMasque($masque[$j], $lettresTab); // on génère un caractère pour cet élément du masque
 #     if ($masque[$j+1] == '?' && rand(0,1) == 1) { // si l'élement du masque suivant est un "?" et que rand donne 1
 #       $reference .= genererCaractereMasque($masque[$j], $lettresTab); // on génère un caractère supplémentaire pour l'élément de masque courant
 #     } # fin si
    } # fin pour j
    $sortie[$i] = $reference;
  } # fin pour i

  return $sortie;

} # fin fonction genererCodeArticle

?>
