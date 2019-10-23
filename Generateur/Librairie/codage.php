<?php
function codage($codage, $donnees, $nbligne){//retourne un tableau en faisant le lien avec la colonne précédente exemple de formule 1;homme
    //dans ce cas la fonction va chercher tout les 1 dans la colonnes précédente par "homme"

    $tab_Formule = (explode(";", $codage));
    for ($i = 0; $i < $nbligne; $i++) {
        for ($j = 0; $j < count($tab_Formule); $j = $j + 2) {
            if ($donnees[$i] == $tab_Formule[$j]) {
                $donnees[$i] = $tab_Formule[$j + 1];
            }
        }
    }
    return $donnees;
}
?>
