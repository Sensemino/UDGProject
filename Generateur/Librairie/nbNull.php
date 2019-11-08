<?php
function nbNull($Tab) //retourne le nombre de "NULL" d'un tableau
{
    $nbNull=0;
    foreach($Tab as $unElt)
    {
        if(!is_numeric($unElt) && $unElt == NULL)
            {
            $nbNull++;
            }
    }
    return $nbNull;
}
?>