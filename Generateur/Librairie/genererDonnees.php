<?php

//--------------------------------------------------------------------------------------------
//Recuperation des donnees
//--------------------------------------------------------------------------------------------

function genererDonnees($listeData, &$donnees, &$DonneesRapport, $PremierPassage, $nbligneagenerer, $nbligne, &$lignemat, &$nbedepassage, $nbedepassageInitial, &$compteurPassage)
{
    foreach ($listeData as $data) 
    {
        $nbdecimal = 0;
        $nbnull = 0;
        $GenererDep = 0 ;
        switch ($data->getAttribute("Type")) {//récupération de l'attribut "Type"  on fait pareil pour min max ....
            case 'Numerique'://pour tout les type numérique
                if ($data->hasAttribute("Min"))
                    $min = $data->getAttribute("Min");
                if ($data->hasAttribute("Max"))
                    $max = $data->getAttribute("Max");
                if ($data->hasAttribute("NbDecimale"))
                    $nbdecimal = $data->getAttribute("NbDecimale");
                if ($data->hasAttribute("NomPerso"))
                    $NomDonnees = $data->getAttribute("NomPerso");
                else
                    $NomDonnees = $data->getAttribute("NomColonne");
                if ($data->hasAttribute("Null")) {
                    $paramnull = $data->getAttribute("Null");
                    $nbnull = LesNulls($paramnull, $nbligneagenerer);//récupère la valeur de null souhaitée exemple pour 6% de 100 valeur retournera 6
                }

                $donnees[$lignemat] = array();//déclaration d'une nouvelle colonne dans la matrice
                
                $donnees[$lignemat] = genererNumerique($nbligneagenerer, $min, $max, $nbdecimal);//appelle de la fonction de génération

                array_unshift($donnees[$lignemat], $NomDonnees);//ajout du nom de la données en entête de la colonne

                if ($data->hasAttribute("codage")) {//ajout d'une colonne au cas ou l'utilisateur souhaite appliquer un codage (ex 1=homme ...)
                    $lignemat++;
                    $donnees[$lignemat] = array();//création d'une colonne pour le résultat du codage
                    $donnees[$lignemat] = codage($data->getAttribute("codage"), $donnees[$lignemat - 1], $nbligneagenerer);

                    if ($PremierPassage == 0) {
                        array_unshift($donnees[$lignemat - 1], $NomDonnees);
                        array_unshift($donnees[$lignemat], "codage de " .$NomDonnees);
                        $DonneesRapport[$lignemat - 1] = array();
                        $DonneesRapport[$lignemat - 1][0] = $NomDonnees;
                        $DonneesRapport[$lignemat - 1][1] = $data->getAttribute("Type");//Type de données
                        $DonneesRapport[$lignemat] = array();
                        $DonneesRapport[$lignemat][0] = "codage de " . $NomDonnees;
                        $DonneesRapport[$lignemat][1] = $data->getAttribute("Type");//Type de données
                    }
                    $lignemat++;//on avance dans la matrice
                } else {
                    if ($PremierPassage == 0) {
                        $DonneesRapport[$lignemat] = array();
                        $DonneesRapport[$lignemat][0] = $NomDonnees;
                        $DonneesRapport[$lignemat][1] = $data->getAttribute("Type");//Type de données

                        array_unshift($donnees[$lignemat], array('reference' => false));
                    }
                    $lignemat++;
                }
                break;

            case 'Dictionnaire':
                if ($data->hasAttribute("ModeGeneration")) {
                    $dicogenera = $data->getAttribute("ModeGeneration");
                }
                if ($data->hasAttribute("NomPerso")) {
                    $NomDonnees = $data->getAttribute("NomPerso");
                } else {
                    $NomDonnees = $data->getAttribute("NomColonne");
                }
                $NomDico = $data->getAttribute("NomDictionnaire");
                if ($data->hasAttribute("Null")) {
                    $diconull = $data->getAttribute("Null");
                }

                if ($data->hasAttribute("Null")) {
                    $paramnull = $data->getAttribute("Null");
                    $nbnull = LesNulls($paramnull, $nbligneagenerer);//récupère la valeur de null souhaitee exemple pour 6% de 100 valeur retournera 6
                }

                if ($data->hasAttribute("GenererDependance")) {
                    if($data->getAttribute("GenererDependance") == "True"){
                        $GenererDep = 1;
                    }
                }
                $donnees[$lignemat] = array();
                $dicos = genererDico($nbligneagenerer, $NomDico, $GenererDep);//appel de la fonction de génération
                $donnees[$lignemat] = $dicos[0];
                array_unshift($donnees[$lignemat], $NomDonnees);

                if ($PremierPassage == 0) {
                    $DonneesRapport[$lignemat] = array();
                    $DonneesRapport[$lignemat][0] = $NomDonnees;
                    $DonneesRapport[$lignemat][1] = $data->getAttribute("Type");//Type de données
                    
                    array_unshift($donnees[$lignemat], array('reference' => false));
                }

                if($GenererDep) {
                    if (strtolower($NomDico) == 'prenoms') {
                        $lignemat++;
                        $donnees[$lignemat] = array();
                        $donnees[$lignemat] = $dicos[1];
                        array_unshift($donnees[$lignemat], 'Sexe');
                        array_unshift($donnees[$lignemat], array('reference' => false));

                        $DonneesRapport[$lignemat] = array();
                        $DonneesRapport[$lignemat][0] = 'Sexe';
                        $DonneesRapport[$lignemat][1] = 'Dictionnaire';//Type de données


                    }

                    if (strtolower($NomDico) == 'villes') {
                        $lignemat++;
                        $donnees[$lignemat] = array();
                        $donnees[$lignemat] = $dicos[1];
                        array_unshift($donnees[$lignemat], 'CodePostale');
                        array_unshift($donnees[$lignemat], array('reference' => false));

                        $DonneesRapport[$lignemat] = array();
                        $DonneesRapport[$lignemat][0] = 'CodePostale';
                        $DonneesRapport[$lignemat][1] = 'Dictionnaire';//Type de données
                    }


                }

                $lignemat++;
                break;

            case "Reference" : // Donnée réference pour les tables liées

                if ($data->hasAttribute("NomPerso")) {
                    $NomDonnees = $data->getAttribute("NomPerso");
                } else {
                    $NomDonnees = $data->getAttribute("NomColonne");
                }

                if ($data->hasAttribute("TableReference")) {
                    $TableReference = $data->getAttribute("TableReference");
                }

                if ($data->hasAttribute("ColonneReference")) {
                    $ColonneReference = $data->getAttribute("ColonneReference");
                }

                $donnees[$lignemat] = array();
                $donnees[$lignemat] = genererReference($TablesSorties, $nbligneagenerer + 1, $TableReference, $ColonneReference);
                array_unshift($donnees[$lignemat], $NomDonnees);

                if ($PremierPassage == 0) {
                    $DonneesRapport[$lignemat] = array();
                    $DonneesRapport[$lignemat][0] = $NomDonnees;
                    $DonneesRapport[$lignemat][1] = $data->getAttribute("Type");//Type de données

                    $reference_array = array();
                    $reference_array["reference"] = true;
                    $reference_array["TableReference"] = $TableReference;
                    $reference_array["ColonneReference"] = $ColonneReference;

                    array_unshift($donnees[$lignemat], $reference_array);
                }
                $lignemat++;
                break;

            case "Formule"://génere un champs a partir d'une formule de la forme ax+b
                if ($data->hasAttribute("NomPerso")) {
                    $NomDonnees = $data->getAttribute("NomPerso");
                } else {
                    $NomDonnees = $data->getAttribute("NomColonne");
                }
                if ($data->hasAttribute("Null")) {
                    $diconull = $data->getAttribute("Null");
                }
                if ($data->hasAttribute("Formule")) {
                    $formule = $data->getAttribute("Formule");
                    $donnees[$lignemat] = array();
                    $donnees[$lignemat] = genererFormule($formule, $donnees,$nbligneagenerer);//appelle de la fonction de génération
                    array_unshift($donnees[$lignemat], $NomDonnees);

                    if ($PremierPassage == 0) {
                        $DonneesRapport[$lignemat] = array();
                        $DonneesRapport[$lignemat][0] = $NomDonnees;
                        $DonneesRapport[$lignemat][1] = $data->getAttribute("Type");//Type de données
                        array_unshift($donnees[$lignemat], array('reference' => false));
                    }
                    $lignemat++;
                }
                break;
            case "IMC" ://formule entré en brut dans le code car on ne gére pas les priorités dans une formule comme celle de l'IMC
                if ($data->hasAttribute("NomPerso")) {
                    $NomDonnees = $data->getAttribute("NomPerso");
                } else {
                    $NomDonnees = $data->getAttribute("NomColonne");
                }
                if ($data->hasAttribute("Null")) {
                    $paramnull = $data->getAttribute("Null");
                    $nbnull = LesNulls($paramnull, $nbligneagenerer);
                }

                if ($data->hasAttribute("IMC")) {
                    $NomDonnees = $data->getAttribute("IMC");
                }
                $donnees[$lignemat] = array();
                $donnees[$lignemat] = imc($donnees, $nbligneagenerer + 1, $lignemat);//appelle d'une fonction permettant le calcul de l'IMC
                array_unshift($donnees[$lignemat], $NomDonnees);

                if ($PremierPassage == 0) {
                    $DonneesRapport[$lignemat] = array();
                    $DonneesRapport[$lignemat][0] = $NomDonnees;
                    $DonneesRapport[$lignemat][1] = $data->getAttribute("Type");//Type de données

                    array_unshift($donnees[$lignemat], array('reference' => false));
                }
                $lignemat++;
                break;
            case "DateHeure" ://Génère une date aléatoire de 0001-01-01 à 9999-12-31
            
            //$dhmin = '2019-11-06 10:00:00';
            //$dhmax = '2019-11-07 10:00:00';
            if ($data->hasAttribute("NomPerso")) {
                $NomDonnees = $data->getAttribute("NomPerso");
            } else {
                $NomDonnees = $data->getAttribute("NomColonne");
            }
            if ($data->hasAttribute("DHmin")) {
                $dhmin = $data->getAttribute("DHmin");}
            if ($data->hasAttribute("DHmax")) {
                $dhmax = $data->getAttribute("DHmax");}
            $nbdecimal = 0;

            $donnees[$lignemat] = array();//déclaration d'une nouvelle colonne dans la matrice
            $donnees[$lignemat] = genererDateHeure($nbligneagenerer, $dhmin, $dhmax);
            array_unshift($donnees[$lignemat], $NomDonnees);//ajout du nom de la données en entête de la colonne
            
            //$donnees[$lignemat] = genererNumerique($nbligneagenerer, $min, $max, $nbdecimal); //appel d'une fonction qui créera la date aléatoirement

            if ($PremierPassage == 0) {
                $DonneesRapport[$lignemat] = array();
                $DonneesRapport[$lignemat][0] = $NomDonnees;
                $DonneesRapport[$lignemat][1] = $data->getAttribute("Type");//Type de données

                array_unshift($donnees[$lignemat], array('reference' => false));
            }
            $lignemat++;

            break;

            case "IDS" : //Génère un identifiant avec une chaine de carctère en préfixe et un entier incrémenté en suffixe
            
            if ($data->hasAttribute("NomPerso")) {
                $NomDonnees = $data->getAttribute("NomPerso");
            } else {
                $NomDonnees = $data->getAttribute("NomColonne");
            }
            if ($data->hasAttribute("Prefixe")) {
                $Prefixe = $data->getAttribute("Prefixe");}
            if ($data->hasAttribute("Suffixe")) {
                $Suffixe = $data->getAttribute("Suffixe");}

            $donnees[$lignemat] = array();//déclaration d'une nouvelle colonne dans la matrice
            $donnees[$lignemat] = genererIDS($nbligneagenerer, $nbligne, $Prefixe, $Suffixe, $compteurPassage);
            array_unshift($donnees[$lignemat], $NomDonnees); //ajout du nom de la données en entête de la colonne

            if($PremierPassage == 0){ //Au premier passage
                $DonneesRapport[$lignemat] = array();
                $DonneesRapport[$lignemat][0] = $NomDonnees;
                $DonneesRapport[$lignemat][1] = $data->getAttribute("Type");//Type de données

                array_unshift($donnees[$lignemat], array('reference' => false));
            }
                
            $lignemat++;

            break;

        }
        if ($nbnull > 0) {//rentre dans le if si un nombre de null a été spécifié
            $nbnullParpassage = $nbnull / $nbedepassageInitial;//calcul le nombre de null a entrer par passage
            if ($nbedepassage > 1) {//rentre si il reste plus d'un passage
                while ($nbnullParpassage > 0) {
                    $i = MDGAleatoire(0, $nbligneagenerer, 0);//tire une ligne aléatoirement entre 0 et le nb de ligne a générer lors de ce passage
                    $nullExist = TestNull($donnees, $i);//test la présence d'autre valeur null sur la ligne
                    if ($nullExist == "False" && $i > 0) {//si pas premier champs et et qu'il y a pas de null sur la ligne rentre une valeur null
                        $donnees[$lignemat - 1][$i] = NULL;


                        if($GenererDep == 1 ){
                            $donnees[$lignemat - 2][$i] = NULL;
                        }
                        if($data->hasAttribute("codage")){
                            $donnees[$lignemat - 2][$i] = NULL;
                        }
                        $nbnull--;
                        $nbnullParpassage--;
                    }
                }
            } else {
                while ($nbnull > 0) {//rentre tout les nulls restant
                    $i = MDGAleatoire(0, $nbligneagenerer, 0);
                    $nullExist = TestNull($donnees, $i);
                    if ($nullExist == "False" && $i > 0) {
                        $donnees[$lignemat - 1][$i] = NULL;

                        if($GenererDep == 1){
                            $donnees[$lignemat - 2][$i] = NULL;
                        }
                        if($data->hasAttribute("codage")){
                            $donnees[$lignemat - 2][$i] = NULL;
                        }
                        $nbnull -= 1;
                    }
                }
            }
        }
        
    }
}
?>
