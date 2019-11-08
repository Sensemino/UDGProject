<?php
function genererFormule($formule,$donnees){//calcul le résulat d'une formule ax+b de manière dynamique
  $TableauResultatFormule = array();
  $TableauFormule = (explode(" ", $formule));
  $NombreDonnee = 0;
  $indiceDeuxiemeColonne = 1;
  $connaitreEmplacementTable = False;
  //récupération des données
  $a=$b=$x=1;
  $operateur = '*';
  // définition via la formule
  if(isset($TableauFormule[0])){
    $a=$TableauFormule[0];
  }
  if(isset($TableauFormule[1])){
    $x=$TableauFormule[1];
  }
  if(isset($TableauFormule[2])){
    $operateur=$TableauFormule[2];
  }
  if(isset($TableauFormule[3])){
    $b=$TableauFormule[3];
  }

  foreach($donnees as $premiereColonneTableau)
  {
    if(is_array($premiereColonneTableau))
    {
      foreach($premiereColonneTableau as $deuxiemeColonneTableau){
        if(isset($deuxiemeColonneTableau) && $deuxiemeColonneTableau == $a)
          $connaitreEmplacementTable = True;
      }
      if($connaitreEmplacementTable == True)
      {
        foreach($premiereColonneTableau as $deuxiemeColonneTableau)
        {
          $a = $deuxiemeColonneTableau;
          if(is_numeric($a))
          {
            $TableauResultatFormule[$indiceDeuxiemeColonne] = $a*$x;
            $NombreDonnee++;
            $indiceDeuxiemeColonne++;
          }
          elseif($a == NULL)
          {
            $TableauResultatFormule[$indiceDeuxiemeColonne] = NULL;
            $indiceDeuxiemeColonne++;
            $NombreDonnee++;
          }
        }
      }
    }
  }
  //réalisation du calcul
  //Ajout de b
  
    for($i=1;$i<$NombreDonnee;$i++){
      switch ($operateur){
        case '*' :
        if($b != NULL && $TableauResultatFormule[$i] != NULL){
          $TableauResultatFormule[$i]*=$b;
        }
        break;
        case '/' :
        if($b != NULL && $b>0 && $TableauResultatFormule[$i] != NULL){
          $TableauResultatFormule[$i]/=$b;
        }
        else {
          $TableauResultatFormule[$i]='/!\ div par 0 /!\ \n';
        }
        break;
        case '%' :
        if($b != NULL && $TableauResultatFormule[$i] != NULL){
          $TableauResultatFormule[$i]%=$b;
        }
        break;
        case '-' :
        if($b != NULL && $TableauResultatFormule[$i] != NULL){
          $TableauResultatFormule[$i]-=$b;
        }
        break;
        case '+' :
        if($b != NULL && $TableauResultatFormule[$i] != NULL){
          $TableauResultatFormule[$i]+=$b;
        }
        break;
      }
    }
    return $TableauResultatFormule;
  }
?>
