<?php
//--------------------------------------------------------------------------------------------
// GENERATION DU RAPPORT A PARTIR DES DONNEES
//--------------------------------------------------------------------------------------------

function genererRapport($listeData,$donnees,&$DonneesRapport,$PremierPassage,$nbligneagenerer) {

    $ValeurMin = 0;
    $ValeurMax = 0;
#echo " DEBUT genererRapport le tableau DonneesRapport est " ;
#print_r($DonneesRapport) ;
    $nblignemat = count($DonneesRapport) ;
    $laColonne = 0  ;

    foreach ($listeData as $data) {

        $laColonne++  ;
        $SommeDonnee  = 0;
        $NombreDonnee = 0;

        $typeData = "???" ;
        if ($data->hasAttribute("Type")) {
            $typeData = $data->getAttribute("Type") ;
        } else {
            echo " pas de type de donnée...\n" ;
            exit(1) ;
        } ; # fin si

        # echo " typeData est $typeData \n" ;

        switch ($typeData) {

        case "Formule":
        case "IMC" :
        case "Numerique":
        case "Date" :
        case "id":
        case "IDS":
        case "CodeArticle" :

            // récupère le nom de la donnée

            #if ($data->hasAttribute("NomPerso")) {
            #    $NomDonnees = $data->getAttribute("NomPerso");
            #} else {
                $NomDonnees = $data->getAttribute("NomColonne");
            #} # fin si

            # on recherche de quelle ligne de donnees il s'agit

            $lignemat = 0;

                // placement sur la bonne colonne $lignemat de $donnees
                while ( ($DonneesRapport[$lignemat][0] != $NomDonnees) && ($lignemat<$nblignemat)) {
                    $lignemat++;
                } # fin tant que

                if ($lignemat>=$nblignemat) {
                  echo " donnee $NomDonnees non trouvée. STOP.\n" ;
                  print_r($DonneesRapport) ;
                  exit(1) ;
                } ; # fin si

                $NbNullPostGene = 0;

                $lesValeurs=array_slice($donnees[$lignemat+1],2); //Recuperation des valeurs uniquement ////BIDOUILLAGE////

                $NbNullPostGene = nbNull($lesValeurs); //récupère le nombre de null généré

                if ($PremierPassage == 0) {
                    $DonneesRapport[$lignemat][2] = $NbNullPostGene;
                    $DonneesRapport[$lignemat][3] = ($NbNullPostGene / $nbligneagenerer) * 100;
                } else {
                    $DonneesRapport[$lignemat][2] += $NbNullPostGene;
                    $DonneesRapport[$lignemat][3] += ($NbNullPostGene / $nbligneagenerer) * 100;
                } # fin si

                if ($data->hasAttribute("Unite")) {//récupère le nom de la donnée
                    $DonneesRapport[$lignemat][8] = $data->getAttribute("Unite");
                } # fin si

                // ajout d'une colonne au cas ou l'utilisateur utilise codage (ex 1=homme ...)

                if ($data->hasAttribute("codage")) {

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
                                } # fin si is_numeric
                            } # fin pour i
                        } # fin pour i
                    } # fin si

                } else {
## echo " genererRapport ligne 98 pour $typeData pour la colonne $laColonne\n" ;
                    //récupère la valeur minimale, maximale et la somme des valeurs et leur nombre

                    if ($PremierPassage == 0) {
                        $ValeurMax=maxTab($lesValeurs);
                        $ValeurMin=minTab($lesValeurs);
                        $SommeDonnee=sommeTab($lesValeurs);
                        $NombreDonnee=count($lesValeurs);
                    } # fin si premier passage

                } # fin si sur codage

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
                } # finsi

                $lignemat = 0;
                while ($DonneesRapport[$lignemat][0] != $NomDonnees) {
                    $lignemat++;
                } # fin tant que
                $NbNullPostGene = 0;

                $lesValeurs=array_slice($donnees[$lignemat+1],2); //Recuperation des valeurs uniquement ////BIDOUILLAGE////

                $NbNullPostGene = nbNull($lesValeurs); //récupère le nombre de null généré

                if ($PremierPassage == 0) {
                    $DonneesRapport[$lignemat][2] = $NbNullPostGene;
                    $DonneesRapport[$lignemat][3] = ($NbNullPostGene / $nbligneagenerer) * 100;
                } # fin si premier passage

                if ($data->getAttribute("GenererDependance") == "Oui") {
                    $lignemat++;
                    $NbNullPostGene = 0;
                    if ($PremierPassage == 0) {
                        $i = 1;
                    } else {
                        $i = 0;
                    }
                    while ($i < $nbligneagenerer) {
                        if ($donnees[$lignemat][$i] == NULL) {
                            $NbNullPostGene++;
                        }
                        $i++;
                    }
                    if ($PremierPassage == 0 and $donnees[$lignemat][$i] == NULL) {
                        $NbNullPostGene++;
                    }
                    if ($PremierPassage == 0) {
                        $DonneesRapport[$lignemat][2] = $NbNullPostGene;
                        $DonneesRapport[$lignemat][3] = ($NbNullPostGene / $nbligneagenerer) * 100;
                    }
                }
                break;
            case "CodeArticle":
            case "Reference":
                    $NomDonnees = $data->getAttribute("NomColonne");
                // placement sur la bonne colonne $lignemat de $donnees
                $lignemat = 0 ;
                while ( ($DonneesRapport[$lignemat][0] != $NomDonnees) && ($lignemat<$nblignemat)) {
                    $lignemat++;
                } # fin tant que

                if ($lignemat>=$nblignemat) {
                  echo " donnee $NomDonnees non trouvée. STOP.\n" ;
                  print_r($DonneesRapport) ;
                  exit(1) ;
                } ; # fin si
              break;
        }  # fin du switch

    } # fin pour chaque data

## print("tableau généré pour rapport") ;
## print_r($DonneesRapport) ;

} # fin fonction genererRapport
?>
