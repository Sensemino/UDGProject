<?php
function sommeTab($Tab) //retourne la somme d'un tableau
{
    $somme=0;
    foreach($Tab as $unElt)
    {
        if(is_numeric($unElt))
            $somme+=$unElt;
    }
    return $somme;
}
?>
