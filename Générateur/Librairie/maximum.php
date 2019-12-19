<?php
function maxTab($Tab) //retourne le maximum d'un tableau
{
    $max=$Tab[0];
    foreach($Tab as $unElt)
    {
        if($unElt>$max)
            $max=$unElt;
    }
    return $max;
}
?>