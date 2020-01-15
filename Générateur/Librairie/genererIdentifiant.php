<?php

//Créer un identifiant avec une table Nom et Prenom de façon dynamiques

function genererIdentifiant($donnees,$NomColonneConcatene,$Concatenation) 
{
    $tableauIdentifiant = array();              //Tableau contenant les différents identifiants créé 
    $tableauNomColonne = explode(";",$NomColonneConcatene);         //Tableau contenant les noms des colonnes qui vont être concaténées
    $tableauConcatenation = explode(".",$Concatenation);            //tableau qui contient la concatenation 
    $tableauDonneePourConcatenation = array();                      //Tableau qui contient seulement les données pour la concatenation
    $premierPassage = true;                                        //Variable qui permet de savoir si c'est le premier passage
    
    for($i=0;$i<count($donnees);$i++)                   //Parcours du tableau de données pour récupérer les données des colonnes du tableauNomColonne
    {
        foreach($tableauNomColonne as $cle=>$valeur)
        {
            if(preg_match("/".$donnees[$i][1]."/mD",$tableauNomColonne[$cle]))          //On cherche le nom de la colonne dans le tableau de données pour ensuite récupérer les données
            {
                $tableauDonneeTmp = array();

                for($j = 1;$j<count($donnees[$i]);$j++)             //On mets toutes les données de la colonne dans le tableauDonneeTmp
                {
                    array_push($tableauDonneeTmp,$donnees[$i][$j]);
                } # fin pour

                array_push($tableauDonneePourConcatenation,$tableauDonneeTmp);      //On met dans le tableauDonnePourConcatanation toutes les données concernant la concatenation pour faciliter la recherche des données
                unset($tableauDonneeTmp);                   //On détruit le tableauDonneeTmp pour ensuite réécrire dedans
            } # fin si
        } # fin pour
            
    } # fin pour

    for($i = 0;$i<count($tableauConcatenation);$i++)
    {
        if($tableauConcatenation[$i] == "T")                        //Permet de savoir si on doit prendre le mot en entier 
        {
            creerConcatenation("MotComplet",$tableauNomColonne[$i],$tableauDonneePourConcatenation,$tableauIdentifiant,$premierPassage);
        }
        elseif(preg_match("/[0-9]/",$tableauConcatenation[$i]))     //Permet de savoir si il y a nombre pour connaitre combien de lettre il faut prendre du mot
        {
            creerConcatenation(intval($tableauConcatenation[$i]),$tableauNomColonne[$i],$tableauDonneePourConcatenation,$tableauIdentifiant,$premierPassage);
        }
        else                        //En cas de mauvaise saisie 
        {
            echo "\nErreur : \"$tableauConcatenation[$i]\" n'a aucune signification\n\n";
            echo "Pour prendre le mot en entier il faut utiliser \"T\" sinon écrire un nombre pour choisir le nombre de lettres voulues\n\n";
        }
        $premierPassage = false;
    }

    return $tableauIdentifiant;

} # fin fonction genererIdentifiant
?>