<?php
function ecrireFichiers($table,&$TablesSorties,&$donnees,$nbligneagenerer,$sortie,$PremierPassage,$nomfic,$nomClee, $listesortie)
{
    

    foreach ($listesortie as $valsortie) {//foreach appellant les fonctions d'écriture en sortie
        $ini = 0;

        if ($valsortie->hasAttribute("CSV"))
        {
            if ($valsortie->getAttribute("CSV") == "True") 
            {
                FoncEcrireCsv($donnees, $nomfic, $nbligneagenerer,$sortie);
                $ini++;
            }
        }
        if ($valsortie->hasAttribute("JSON")) 
        {
            if ($valsortie->getAttribute("JSON") == "True") 
            {
                FoncEcrireJson($donnees, $nomfic, $nbligneagenerer,$sortie, $PremierPassage);
                $ini++;
            }
        }
        if ($valsortie->hasAttribute("XML")) 
        {
            if ($valsortie->getAttribute("XML") == "True") 
            {
                FoncEcrireXml($donnees, $nomfic, $nbligneagenerer,$sortie, $PremierPassage);
                $ini++;
            }
        }
        if ($valsortie->hasAttribute("SQL")) 
        {
            if ($valsortie->getAttribute("SQL") == "True") 
            {
                FoncEcrireSql($donnees, $nomfic, $nbligneagenerer, $PremierPassage, $sortie, $nomClee);
                $ini++;
            }
        }

        // La table est sortie, on l'ajoute à notre tableau de données
        array_unshift($donnees, $nomfic); // On ajoute le nom de notre table au debut du tableau de données
        array_push($TablesSorties, $donnees);

        if ($ini == 0)
            echo "Aucun format de sortie choisi pour cette table \n";
    }
}
?>