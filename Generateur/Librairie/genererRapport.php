<?php
//--------------------------------------------------------------------------------------------
//GENERATION DU RAPPORT A PARTIR DES DONNEES
//--------------------------------------------------------------------------------------------
function genererRapport($listeData,$donnees,&$DonneesRapport,$PremierPassage,$nbligneagenerer){

$ValeurMin = 0;
$ValeurMax = 0;

foreach ($listeData as $data) 
{
    $SommeDonnee = 0;
    $NombreDonnee = 0;

    switch ($data->getAttribute("Type")) 
    {        
        case "Formule":
        case "IMC" :
        case 'Numerique':
            if ($data->hasAttribute("NomPerso")) //récupère le nom de la donnée
            {
                $NomDonnees = $data->getAttribute("NomPerso");
            }
            else 
            {
                $NomDonnees = $data->getAttribute("NomColonne");
            }
            $lignemat = 0;

            while ($DonneesRapport[$lignemat][0] != $NomDonnees) //placement sur la bonne colonne $lignemat de $donnees
            {
                $lignemat++;
            }

            $NbNullPostGene = 0;
            
            $lesValeurs=array_slice($donnees[$lignemat+1],2); //Recuperation des valeurs uniquement ////BIDOUILLAGE////
            
            $NbNullPostGene = nbNull($lesValeurs); //récupère le nombre de null généré

            if ($PremierPassage == 0) {
                $DonneesRapport[$lignemat][2] = $NbNullPostGene;
                $DonneesRapport[$lignemat][3] = ($NbNullPostGene / $nbligneagenerer) * 100;
            } else {
                $DonneesRapport[$lignemat][2] += $NbNullPostGene;
                $DonneesRapport[$lignemat][3] += ($NbNullPostGene / $nbligneagenerer) * 100;
            }
            if ($data->hasAttribute("Unite")) {//récupère le nom de la donnée
                $DonneesRapport[$lignemat][8] = $data->getAttribute("Unite");
            }
            if ($data->hasAttribute("codage")) {//ajout d'une colonne au cas ou l'utilisateur souhaite appliquer un codage (ex 1=homme ...)
                $lignemat++;
                if (!(isset($DonneesRapport[$lignemat][9]))) {
                    $DonneesRapport[$lignemat][9] = array();
                    $AnalyseCode = array_count_values($donnees[$lignemat]);
                    $DonneesRapport[$lignemat][9] = $AnalyseCode;
                } else {
                    $AnalyseCode = array_count_values($donnees[$lignemat]);
                    for ($i = 0; $i < sizeof($DonneesRapport[$lignemat][9]); $i++) {
                        for ($i = 0; $i < sizeof($DonneesRapport[$lignemat][9]); $i++) {
                            if (is_numeric($AnalyseCode[$i])) {
                                $DonneesRapport[$lignemat][9][$i] += $AnalyseCode[$i];
                            }
                        }
                    }
                }
            } 
            else 
            {//récupère la valeur minimale, maximale et la somme des valeurs et leur nombre  
                if ($PremierPassage == 0) 
                {
                    $ValeurMax=maxTab($lesValeurs);
                    $ValeurMin=minTab($lesValeurs);
                    $SommeDonnee=sommeTab($lesValeurs);
                    $NombreDonnee=count($lesValeurs);
                } 
                else 
                {
                
                }
            }
            $DonneesRapport[$lignemat][4] = $ValeurMin;//Minimum
            $DonneesRapport[$lignemat][5] = $ValeurMax;//Maximum
            $DonneesRapport[$lignemat][6] = $SommeDonnee;//somme de donnée
            $DonneesRapport[$lignemat][7] = $NombreDonnee;//nombre de donnée
            break;
        case 'Dictionnaire':
            if ($data->hasAttribute("NomPerso")) {//récupère le nom de la donnée
                $NomDonnees = $data->getAttribute("NomPerso");
            } else {
                $NomDonnees = $data->getAttribute("NomColonne");
            }
            $lignemat = 0;
            while ($DonneesRapport[$lignemat][0] != $NomDonnees) {
                $lignemat++;
            }
            if ($PremierPassage == 0) {
                $i = 1;
            } else {
                $i = 0;
            }
            while ($i < $nbligneagenerer) {
                if ($donnees[$lignemat][$i] == "NULL") {
                    $NbNullPostGene++;
                }
                $i++;
            }
            if ($PremierPassage == 0 and $donnees[$lignemat][$i] == "NULL") {
                $NbNullPostGene++;
            }
            if ($PremierPassage == 0) {
                $DonneesRapport[$lignemat][2] = $NbNullPostGene;
                $DonneesRapport[$lignemat][3] = ($NbNullPostGene / $nbligneagenerer) * 100;
            }

            if ($data->getAttribute("GenererDependance") == "Oui") {//ajout d'une colonne au cas ou l'utilisateur souhaite appliquer un codage (ex 1=homme ...)
                $lignemat++;
                $NbNullPostGene = 0;
                if ($PremierPassage == 0) {
                    $i = 1;
                } else {
                    $i = 0;
                }
                while ($i < $nbligneagenerer) {
                    if ($donnees[$lignemat][$i] == "NULL") {
                        $NbNullPostGene++;
                    }
                    $i++;
                }
                if ($PremierPassage == 0 and $donnees[$lignemat][$i] == "NULL") {
                    $NbNullPostGene++;
                }
                if ($PremierPassage == 0) {
                    $DonneesRapport[$lignemat][2] = $NbNullPostGene;
                    $DonneesRapport[$lignemat][3] = ($NbNullPostGene / $nbligneagenerer) * 100;
                }
            }
        break;
    }
}
$PremierPassage = 1;//on indique qu'il y a eu au moins un passage
}
?>