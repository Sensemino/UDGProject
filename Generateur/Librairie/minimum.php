<?php
function minTab($Tab) //retourne le minimum d'un tableau
{
    $min=$Tab[0];
    foreach($Tab as $unElt)
    {
        if(is_numeric($unElt) && $unElt<$min)
            $min=$unElt;
    }
    return $min;
}
?>
