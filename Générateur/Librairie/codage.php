<?php

// retourne un tableau en faisant le lien avec la colonne précédente
// qui est num�rique : exemple de formule de codage : 1;homme;2;femme

function codage($leCodage, $donnees, $nbligne,$nom,$PremierPassage,$min,$max) {
#echo  " input pour passage $PremierPassage " ;
#print_r($donnees) ;
    $decale = 0 ;
    $indice = array();

    if ($PremierPassage==0) { $decale = 1 ; } ;
    $donnees[0+$decale] = $nom ; # car en 0 c'est d�j� [reference]

    $tab_Formule = explode(";", $leCodage) ;
    
    if(substr($tab_Formule[0],0,1) == ">")
    {
        array_push($tab_Formule,">".$max);  //On ajoute le maximum à la fin du tableau pour faire le dernier intervalle
    }

    if(substr($tab_Formule[0],0,1) == "<")
    {
        array_unshift($tab_Formule,"<".$min,"minimal");  //On ajoute le minimum au début du tableau pour faire le premier intervalle
    }

    foreach($tab_Formule as $cle=>$i)
    {
        if(substr($i,0,1) == "<" || substr($i,0,1) == ">")
        {
            array_push($indice,$cle);           //Permet de savoir si c'est un intervalle ou non
        } # fin si

    } #fin pour

    if(count($indice) == 0)
    {
        for ($i = 1 + $decale ; $i <= $nbligne + $decale ; $i++) { # on commence � 2 car en 1 c'est le nom de la colonne
            for ($j = 0; $j < count($tab_Formule); $j = $j + 2) {
                if ($donnees[$i] == $tab_Formule[$j]) {
                    $donnees[$i] = $tab_Formule[$j + 1];
                } # fin si
            } # fin pour
        } # fin pour
    }
    else
    {
        for ($i = 1 + $decale ; $i <= $nbligne + $decale ; $i++) { # on commence � 2 car en 1 c'est le nom de la colonne
            for ($j = 0; $j < count($tab_Formule); $j = $j + 2) {
                if(substr($tab_Formule[$j],0,1) == "<")
                {
                    if (($donnees[$i] < intval(substr($tab_Formule[$j],1))) && ($donnees[$i] >= intval(substr($tab_Formule[$j-2],1)))) {
                        $donnees[$i] = $tab_Formule[$j + 1];
                    } # fin si
                }
                else
                {
                    if (($donnees[$i] > intval(substr($tab_Formule[$j],1))) && ($donnees[$i] <= intval(substr($tab_Formule[$j+2],1)))) {
                        $donnees[$i] = $tab_Formule[$j + 1];
                    } # fin si
                }
            } # fin pour
        } # fin pour
    }
       
#echo  " output " ;
#print_r($donnees) ;

    return $donnees;

} # fin fonction codage
?>
