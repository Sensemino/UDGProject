<?php

//Créer un identifiant avec une table Nom et Prenom de façon dynamiques

function genererIdentifiant($donnees) 
{
    $tableauIdentifiant = Array();
    $colonneNomTrouve = FALSE;
    $colonnePrenomTrouve = FALSE;
    $separteur = ".";       //Permet de choisir le séparateur entre l'initial du prénom et le nom

    foreach($donnees as $indicePremiereColonne=>$premiereColonne)   
    {
        foreach($premiereColonne as $indiceDeuxiemeColonne=>$deuxiemeColonne2) 
        {
            if (is_string($deuxiemeColonne2) && !preg_match('#^[0-9,\s\.-]+$#', $deuxiemeColonne2)) 
            {
            //Permet de vérifier si c'est une chaîne de caractères qui contient des lettres
            $donnees[$indicePremiereColonne][$indiceDeuxiemeColonne] = strtolower($donnees[$indicePremiereColonne][$indiceDeuxiemeColonne]);
            $donnees[$indicePremiereColonne][$indiceDeuxiemeColonne] = ucfirst($donnees[$indicePremiereColonne][$indiceDeuxiemeColonne]);
            } # finsi
        } # fin pour chaque
    } # fin pour chaque


    for($i=0;$i<count($donnees);$i++)
    {
        for($j=1;$j<count($donnees[$i]);$j++)
        {
            if($donnees[$i][$j] == "Prenom" || $donnees[$i][$j] == "Prenoms")
            {
                $colonnePrenomTrouve = TRUE;
            }

            if($donnees[$i][$j] == "Nom" || $donnees[$i][$j] == "Noms")
            {
                $colonneNomTrouve = TRUE;
            }
        }#Fin boucle pour recherche colonne Nom et Prenom

        for($j=2;$j<count($donnees[$i]);$j++)   //On commence à deux car à 0 c'est la référence et à 1 le nom de la table
        {
            if($colonnePrenomTrouve == TRUE && isset($tableauIdentifiant[$j-2]))
            {
                $tableauIdentifiant[$j-2] = substr($donnees[$i][$j],0,1).$tableauIdentifiant[$j-2];
            }
            elseif($colonnePrenomTrouve == TRUE)
            {
                $tableauIdentifiant[$j-2] = substr($donnees[$i][$j],0,1);
            }#fin si

            if($colonneNomTrouve == TRUE && isset($tableauIdentifiant[$j-2]))
            {
                $tableauIdentifiant[$j-2] = $tableauIdentifiant[$j-2].$separteur.$donnees[$i][$j];
            }
            elseif($colonneNomTrouve == TRUE)
            {
                $tableauIdentifiant[$j-2] = $separteur.$donnees[$i][$j];
            }#fin si
        }
        $colonneNomTrouve = FALSE;
        $colonnePrenomTrouve = FALSE;
    }
  
    return $tableauIdentifiant;

} # fin fonction genererIdentifiant
?>