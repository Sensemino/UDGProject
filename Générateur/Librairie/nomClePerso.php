<?php
function nomClePerso($listeData)
{
    $nomCle="";

    foreach($listeData as $data)
    {
        if($data->getAttribute("Type")=="IDS")
        {
            if ($data->hasAttribute("NomPerso"))
                $nomCle = $data->getAttribute("NomPerso");
            else
                $nomCle = $data->getAttribute("NomColonne");
        }
    }
    
    return $nomCle;
}
?>