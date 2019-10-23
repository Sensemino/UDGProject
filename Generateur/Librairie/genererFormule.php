<?php
function genererFormule($formule,$donnees){//calcul le résulat d'une formule ax+b de manière dynamique
  $TableauResultatFormule = array();
  $TableauFormule = (explode(" ", $formule));
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
  //récupération des indice de colonne
  for($i = 0;$i<count($donnees)-1;$i++){
    if($donnees[$i][0]==$a){
      $pos_a = $i;
    }elseif ($donnees[$i][0]==$x) {
      $pos_x = $i;
    }elseif ($donnees[$i][0]==$b) {
      $pos_b = $i;
    }
  }
  //réalisation du calcul
  //si null prend la valeur 0
  //calcul de ax
  if (isset($pos_a) && isset($pos_x)){
    for($i=1;$i<count($donnees[$pos_x]);$i++){
      $TableauResultatFormule[$i]=$donnees[$pos_a][$i]*$donnees[$pos_x][$i];
    }
  }else{
    if(isset($pos_a)){
      for($i=1;$i<count($donnees[$pos_a]);$i++){
        $TableauResultatFormule[$i]=$donnees[$pos_a][$i]*$x;
      }}elseif(isset($pos_x)){
        for($i=1;$i<count($donnees[$pos_x]);$i++){
          $TableauResultatFormule[$i]=$donnees[$pos_x][$i]*$a;
        }
      }else {
        for($i=1;$i<count($donnees[0]);$i++){
          $TableauResultatFormule[$i]=$a*$x;
        }
      }
    }
    //ajout de b
    if($b != 1 && isset($pos_b)) {
      for($i=1;$i<count($donnees[0]);$i++){
        switch ($operateur){
          case '*' :
          $TableauResultatFormule[$i]*=$b[$i];
          break;
          case '/' :
          if($b[$i] != "NULL" && $b[$i]>0){
            $TableauResultatFormule[$i]/=$b[$i];
          }
          else {
            $TableauResultatFormule[$i]='/!\ div par 0 /!\ \n';
          }
          break;
          case '%' :
          $TableauResultatFormule[$i]%=$b[$i];
          break;
          case '-' :
          $TableauResultatFormule[$i]-=$b[$i];
          break;
          case '+' :
          $TableauResultatFormule[$i]+=$b[$i];
          break;
        }
      }
    }
    else{
      for($i=1;$i<count($donnees[0]);$i++){
        switch ($operateur){
          case '*' :
          $TableauResultatFormule[$i]*=$b;
          break;
          case '/' :
          if($b != "NULL" && $b>0){
            $TableauResultatFormule[$i]/=$b;
          }
          else {
            $TableauResultatFormule[$i]='/!\ div par 0 /!\ \n';
          }
          break;
          case '%' :
          $TableauResultatFormule[$i]%=$b;
          break;
          case '-' :
          $TableauResultatFormule[$i]-=$b;
          break;
          case '+' :
          $TableauResultatFormule[$i]+=$b;
          break;
        }
      }
    }
    return $TableauResultatFormule;
  }
?>
