<?php

//--------------------------------------------------------------------------------------------
// Generation des donnees
//--------------------------------------------------------------------------------------------

function genererDonnees($listeData, &$donnees, &$DonneesRapport, $PremierPassage, $nbligneagenerer, $nbligne, &$lignemat, &$nbedepassage, $nbedepassageInitial, &$compteurPassage,$TablesSorties) {

# pour debug : echo "genererDonnees DEBUT\n";

    foreach ($listeData as $data) {

        $nbdecimal   = 0 ;
        $nbnull      = 0 ;
        $GenererDep  = 0 ;
        $typeOk      = 0 ;

        // récupération des attributs g�n�raux comme NomColonne, Type....

        $NomDonnees     = valeurAttribut($data,"NomColonne","colonnne???") ;
        $NomDonneesOrg  = valeurAttribut($data,"NomColonne","colonnnePerso???") ;
        $leType         = valeurAttribut($data,"Type","typeColonnne???") ;
        $paramnull      = valeurAttribut($data,"Null",0);
        $enMaju         = valeurAttribut($data,"EnMajuscules","non") ;
        if ($paramnull!=0) {  $nbnull = LesNulls($paramnull, $nbligneagenerer) ; } ;

        switch ($leType) {

            case 'id' :

                 $nouveauTableau = genererID($nbligneagenerer, $nbligne, $compteurPassage);
                 $typeOk = 1 ; break ;

            case "IDS" : //Génère un identifiant avec une chaine de carctère en préfixe et un entier incrémenté en suffixe

                 $Prefixe        = valeurAttribut($data,"Prefixe","") ;
                 $nbChiffres     = valeurAttribut($data,"NbChiffres",3) ;
                 $Suffixe        = valeurAttribut($data,"Suffixe",0) ;
                 $nouveauTableau = genererIDS($nbligneagenerer, $nbligne, $Prefixe, $Suffixe, $compteurPassage,$nbChiffres);

                 $typeOk = 1 ; break  ;

            case "CodeArticle":

                 $masque         = valeurAttribut($data,"Masque","XXy-19") ;
                 $nouveauTableau = genererCodeArticle($nbligneagenerer,$masque); // appel de la fonction de génération

                 $typeOk = 1 ; break ;

            case 'Numerique'://pour tout les type numériques

                 $min       = valeurAttribut($data,"Min",1) ;
                 $max       = valeurAttribut($data,"Max",100) ;
                 $nbdecimal = valeurAttribut($data,"NbDecimale",0) ;
                 $nouveauTableau = genererNumerique($nbligneagenerer, $min, $max, $nbdecimal);//appelle de la fonction de génération

                 if ($data->hasAttribute("Codage")) { $NomDonnees = "code".$NomDonneesOrg ; } ;

                 $typeOk = 1 ; break ;

            case 'Dictionnaire':

                 $dicogenera = valeurAttribut($data,"ModeGeneration","") ;
                 $NomDico    = valeurAttribut($data,"NomDictionnaire","") ;
                 $genererDep = valeurAttribut($data,"GenererDependance","False") ;
                 if ($genererDep!=0) {  $GenererDep = 1 ; } ;
                 $dicos = genererDico($nbligneagenerer, $NomDico, $GenererDep,$enMaju) ;
                 $nouveauTableau = $dicos[0];

                 $typeOk = 1 ; break ;

            case "Reference" : // Donnée réference pour les tables liées

                 $TableReference   = valeurAttribute($data,"TableReference","");
                 $ColonneReference = valeurAttribute($data,"ColonneReference","");

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
                 $typeOk = 1 ; break ;

            case "Formule"://génere un champs a partir d'une formule de la forme ax+b

                 $formule        = valeurAttribut($data,"Formule","") ;
                 $nouveauTableau = genererFormule($formule, $donnees,$nbligneagenerer);//appelle de la fonction de génération

                 $typeOk = 1 ; break ;

            case "IMC" ://formule entré en brut dans le code car on ne gére pas les priorités dans une formule comme celle de l'IMC


                 $nouveauTableau = imc($donnees, $nbligneagenerer + 1, $lignemat);//appelle d'une fonction permettant le calcul de l'IMC

                 $typeOk = 1 ; break ;

            case "DateHeure" ://Génère une date aléatoire de 0001-01-01 à 9999-12-31

                 $dhmin = valeurAttribut($data,"DateHeureMin",'1900-01-01 0:00:01') ;
                 $dhmax = valeurAttribut($data,"DateHeureMax",'3000-01-01 0:00:01') ;
                 $nbdecimal = 0 ;

                 $nouveauTableau = genererDateHeure($nbligneagenerer, $dhmin, $dhmax);

                 $typeOk = 1 ; break ;
            case "Identifiant" :    //Création d'un identifiant avec le Nom et le Prenom


                $nouveauTableau = genererIdentifiant($donnees); //appelle d'une fonction permettant le calcul de l'IMC
   
                $typeOk = 1 ; break ;

        } # fin de switch

        if ($typeOk==0) {
           echo " type : $leType non trait�. STOP.\n" ;
           exit(1) ;
        } # fin si

        ## si on arrive ici, c'est toujours la m&ecirc;me chose :

        # on ajoute le tableau qu'on vient de g�n�rer dans $donnees
        # on ajoute le nom de la colonne en en tête des donn�ees
        # si c'est le premier passage, on met la bonne valeur de reference en d�but de tableau
        #                              et on �crit les informations dans le tableau du rapport
        # on incr�mente l'indice de ligne dans $donnees

        $donnees[$lignemat] = array() ; // déclaration d'une nouvelle colonne dans la matrice
        $donnees[$lignemat] = $nouveauTableau ;
        array_unshift($donnees[$lignemat], $NomDonnees);//ajout du nom de la données en entête de la colonne

        if ($PremierPassage == 0) {
            $DonneesRapport[$lignemat]    = array();
            $DonneesRapport[$lignemat][0] = $NomDonnees;
            $DonneesRapport[$lignemat][1] = $leType;//Type de données
            array_unshift($donnees[$lignemat], array('reference' => false));
        } # fin si premier passage

        // ajout d'une colonne au cas ou l'utilisateur souhaite appliquer un codage (ex 1=homme ...)

        if ($data->hasAttribute("Codage")) {
#echo "AVANT " ;
#print_r($donnees[3]) ;
            $lignemat++;
            $donnees[$lignemat] = array() ; //création d'une colonne pour le résultat du codage
            $donnees[$lignemat] = codage($data->getAttribute("Codage"), $donnees[$lignemat - 1], $nbligneagenerer,$NomDonneesOrg,$PremierPassage,$min,$max);

#echo "APRES " ;
#print_r($donnees[3]) ;
            if ($PremierPassage == 0) {
                # pas besoin, c'est d�ja fait !
                # array_unshift($donnees[$lignemat], array('reference' => false));
#echo "APRES au PremierPassage " ;
#print_r($donnees) ;
                $DonneesRapport[$lignemat - 1]    = array();
                $DonneesRapport[$lignemat - 1][0] = $NomDonneesOrg  ;
                $DonneesRapport[$lignemat - 1][1] = $data->getAttribute("Type") ; //Type de données
            } # fin si premier passage

        } ; # fin si codage

        # s'il y a des d�pendences comme pr�nom/sexe ou code postal /ville

        if ($GenererDep) {
            $lignemat++;
            if (strtolower($NomDico) == 'prenoms') {
                $varDep = "Sexe" ;
            } # finsi

            if (strtolower($NomDico) == 'villes') {
                $varDep = 'CodePostal' ;
            } # finsi

            $donnees[$lignemat] = array();
            $donnees[$lignemat] = $dicos[1];
            array_unshift($donnees[$lignemat], $varDep);
            array_unshift($donnees[$lignemat], array('reference' => false));

            $DonneesRapport[$lignemat] = array();
            $DonneesRapport[$lignemat][0] = $varDep ;
            $DonneesRapport[$lignemat][1] = 'Dictionnaire'; // Type de données

        } # fin generer dependance

        $lignemat++;

        # et maintenant, on g�re les NULL, c'est-� dire qu'on enl�ve des donn�es,
        # sauf pour les id et les IDS


        if ($nbnull > 0) { //rentre dans le if si un nombre de null a été spécifié
            $nbnullParpassage = $nbnull / $nbedepassageInitial;//calcul le nombre de null a entrer par passage
            if ($nbedepassage > 1) { //rentre si il reste plus d'un passage
                while ($nbnullParpassage > 0) {
                    // tire une ligne aléatoirement entre 0 et le nb de ligne a générer lors de ce passage
                    $i = MDGAleatoire(0, $nbligneagenerer, 0) ;
                    $nullExist = TestNull($donnees, $i);//test la présence d'autre valeur null sur la ligne
                    if ($nullExist == "False" && $i > 0) {//si pas premier champs et qu'il y a pas de null sur la ligne rentre une valeur null
                        $donnees[$lignemat - 1][$i] = NULL;


                        if($GenererDep == 1 ){
                            $donnees[$lignemat - 2][$i] = NULL;
                        } # fin si
                        if($data->hasAttribute("codage")){
                            $donnees[$lignemat - 2][$i] = NULL;
                        } # fin si
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
                        } # fin si sur genereDep
                        if($data->hasAttribute("codage")){
                            $donnees[$lignemat - 2][$i] = NULL;
                        } # fin si sur codage
                        $nbnull -= 1;
                    } # fin si sur nullExist
                } # fintant que sur tous les nuls
            } # fin si sur nbdepassage
        } # fin si sur nbnul


    } # fin pour chaque
# pour debug : echo "genererDonnees FIN\n";
} # fin fonction genererDonnees
?>
