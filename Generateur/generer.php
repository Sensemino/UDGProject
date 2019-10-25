<?php
error_reporting(E_ALL | E_NOTICE | E_STRICT ) ;

/**
* generer.php
*
* Ce programme permet la génération de données.
* En lien direct avec le fichier Parametre.XML.
*
* @version 1.0
* @author Brice Harismendy <brice.harismendy@etud.univ-angers.fr> ,
* @author Corentin Couvry <corentin.couvry@etud.univ-angers.fr> ,
* @author Antoine Legoubé <antoine.legoube@etud.univ-angers.fr> ,
* @author Alban Baumard <alban.baumard@etud.univ-angers.fr>
*
* @project Generateur_de_donnees
*/

/**
* Déclaration de variables globales
*/
//appel des fonctions depuis le dossier script de l'interface
require('Librairie/TestNull.php');
require('Librairie/LesNulls.php');
require('Librairie/make_seed.php');
require('Librairie/MDGAleatoire.php');
require('Librairie/FoncEcrireSql.php');
require('Librairie/FoncEcrireCsv.php');
require('Librairie/FoncEcrireXml.php');
require('Librairie/FoncEcrireJson.php');
require('Librairie/genererDico.php');
require('Librairie/genererNumerique.php');
require('Librairie/genererFormule.php');
require('Librairie/genererReference.php');
require('Librairie/codage.php');
require('Librairie/imc.php');
require('Librairie/FoncEcrireRapport.php');


$TablesSorties = array();

/*
TablesSorties = Tableau contenant les tables déjà sorties
Elles servent dans le cas où on veut une donnée reference (tables liées), on va piocher dedans.
*/


if(isset($argv[1]))
{
    $fichier = $argv[1];        //récupération du fichier XML
}
else
{
    echo "Aucun fichier n'a été donné en paramètre\n";
    echo "Il faut ajouter le nom du fichier XML après le generer.php\n";
    exit(1);
}

$donnees = array();   //matrice qui contiendra les données
$DonneesRapport = array();
$numtable = 1;       //sert pour connaitre la table sur lequel on travail pour le rapport de génération
$lignemat = 0;      //nombre de colonne de la matrice
$dom = new DOMDocument();
$moduloseed=5;
$ValeurMin = 0;
$ValeurMax = 0;
$sortie = "Sorties/";
if(isset($argv[2])){
    $sortie = $argv[2]."/";
}
$PositionRapport = $sortie."Rapport_De_Génération.txt";
// timestamp en millisecondes du début du script (en PHP 5)
$timestamp_debut = microtime(true);
if (!$dom->load($fichier) ||( !$dom->schemaValidate("udg.xsd"))) {// validation du fichier XML
    echo "le fichier XML est invalide";
    exit(1);
} else {
    $fp = fopen($PositionRapport, "w+");//création ou suppression du contenu du fichier contenant le rapport
    fclose($fp);
    $listeTable = $dom->getElementsByTagName("Table");//récupération des tables
    foreach ($listeTable as $table) {//traitement des différentes tables
        $seed = null;//mise à zéro de la seed de génération
        $moduloseed = $moduloseed * $moduloseed;//sert a générer une seed unique
        $fp = fopen($PositionRapport, "a+");
        fputs($fp, "Table n°" . $numtable . "\n");//entre l'entête du rapport de génération (Table n°1 ....)
        $numtable++;
        $donnees = null;//mise a zéro de la matrice des données
        //remise a 0 des données du rapport
        $DonneesRapport = null;
        $lignemat = 0;
        $listeRows = $table->getElementsByTagName("Nbligne");//récupération du nombre de ligne pour la table en cour

        foreach ($listeRows as $rows) {

            if ($rows->hasAttribute("valeur")) {
                $nbligne = $rows->getAttribute("valeur");//on recupère le nombre de ligne a générer
            }

        }
        $listeFile = $table->getElementsByTagName("NomTable");//récupération du nom de la table
        foreach ($listeFile as $file) {

            if ($file->hasAttribute("nom")) {
                $nomfic = $file->getAttribute("nom");
            }
        }
        $listeSeed = $table->getElementsByTagName("Seed");//récupération de la seed
        foreach ($listeSeed as $valseed) {
            if ($valseed->hasAttribute("valeur")) {
                $seed = $valseed->getAttribute("valeur");
            }

        }
        if ($seed == null)
            $seed = make_seed($moduloseed);//création d'une seed si elle n'est pas dans le XML

        srand($seed);//implémentation de la seed

        //ajout de la seed
        $fp = fopen($PositionRapport, "a+");
        fputs($fp, "==================================================\n");
        fputs($fp, "Données Générales : \n");
        fputs($fp, "La seed de génération est : " . $seed . " \n");//on écrit la seed
        fputs($fp, "==================================================\n");
        fclose($fp);

        $listeData = $table->getElementsByTagName("Donnee");//récupération des différent champ a générer
        $nbligneagenerer = 100000;// initialisation du nombre de ligne a généré par passage
        $nbedepassage = $nbligne / 100000;//initialisation du nombre de passage
        $PremierPassage = 0;
        while ($nbedepassage > 0) {
            $donnees = NULL;
            $lignemat = 0;
            if ($nbedepassage < 1) {//si il reste moins d'un passage (- de 100 000 lignes) on met le nombre de ligne a généré restante
                $nbligneagenerer = $nbedepassage * 100000;
            }
            foreach ($listeData as $data) {
                $nbdecimal = 0;
                $nbnull = 0;
                $GenererDep = 0 ;
                switch ($data->getAttribute("Type")) {//récupération de l'attribut "Type"  on fait pareil pour min max ....
                    case 'Numerique'://pour tout les type numérique
                        if ($data->hasAttribute("Min")) {
                            $min = $data->getAttribute("Min");
                        }
                        if ($data->hasAttribute("Max")) {
                            $max = $data->getAttribute("Max");
                        }
                        if ($data->hasAttribute("NbDecimale")) {
                            $nbdecimal = $data->getAttribute("NbDecimale");
                        }
                        if ($data->hasAttribute("NomPerso")) {
                            $NomDonnees = $data->getAttribute("NomPerso");
                        } else {
                            $NomDonnees = $data->getAttribute("NomColonne");
                        }
                        if ($data->hasAttribute("Null")) {
                            $paramnull = $data->getAttribute("Null");
                            $nbnull = LesNulls($paramnull, $nbligneagenerer);//récupère la valeur de null souhaiter exemple pour 6% de 100 valeur retournera 6
                        }

                        $donnees[$lignemat] = array();//déclaration d'une nouvelle colonne dans la matrice
                        $donnees[$lignemat] = genererNumerique($nbligneagenerer, $min, $max, $nbdecimal);//appelle de la fonction de génération
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
                                array_unshift($donnees[$lignemat], $NomDonnees);//ajout du nom de la données en entête de la colonne
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
                            $nbnull = LesNulls($paramnull, $nbligneagenerer);//récupère la valeur de null souhaiter exemple pour 6% de 100 valeur retournera 6
                        }

                        if ($data->hasAttribute("GenererDependance")) {
                            if($data->getAttribute("GenererDependance") == "True"){
                                $GenererDep = 1;
                            }
                        }
                        $donnees[$lignemat] = array();
                        $dicos = genererDico($nbligneagenerer, $NomDico, $GenererDep);//appelle de la fonction de génération
                        $donnees[$lignemat] = $dicos[0];

                        if ($PremierPassage == 0) {
                            array_unshift($donnees[$lignemat], $NomDonnees);
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
                                $DonneesRapport[$lignemat][1] = 'Sexe';
                                $DonneesRapport[$lignemat][2] = 'Dictionnaire';//Type de données


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
                        echo("Voici : ");
                        print_r($donnees);
                        echo ("\n\n");

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

                        if ($PremierPassage == 0) {
                            array_unshift($donnees[$lignemat], $NomDonnees);
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
                            $donnees[$lignemat] = genererFormule($formule, $donnees);//appelle de la fonction de génération
                            if ($PremierPassage == 0) {
                                array_unshift($donnees[$lignemat], $NomDonnees);
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
                        if ($PremierPassage == 0) {
                            array_unshift($donnees[$lignemat], $NomDonnees);
                            $DonneesRapport[$lignemat] = array();
                            $DonneesRapport[$lignemat][0] = $NomDonnees;
                            $DonneesRapport[$lignemat][1] = $data->getAttribute("Type");//Type de données

                            array_unshift($donnees[$lignemat], array('reference' => false));
                        }
                        $lignemat++;
                        break;

                }
                if ($nbnull > 0) {//rentre dans le if si un nombre de null a été spécifié
                    $nbnullParpassage = $nbnull / ($nbligne / 100000);//calcul le nombre de null a entrer par passage
                    if ($nbedepassage > 1) {//rentre si il reste plus d'un passage
                        while ($nbnullParpassage > 0) {
                            $i = MDGAleatoire(0, $nbligneagenerer, 0);//tire une ligne aléatoirement entre 0 et le nb de ligne a générer lors de ce passage
                            $nullExist = TestNull($donnees, $i);//test la présence d'autre valeur null sur la ligne
                            if ($nullExist == "False" && $i > 0) {//si pas premier champs et et qu'il y a pas de null sur la ligne rentre une valeur null
                                $donnees[$lignemat - 1][$i] = "NULL";


                                if($GenererDep == 1 ){
                                    $donnees[$lignemat - 2][$i] = "NULL";
                                }
                                if($data->hasAttribute("codage")){
                                    $donnees[$lignemat - 2][$i] = "NULL";
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
                                $donnees[$lignemat - 1][$i] = "NULL";

                                if($GenererDep == 1){
                                    $donnees[$lignemat - 2][$i] = "NULL";
                                }
                                 if($data->hasAttribute("codage")){
                                     $donnees[$lignemat - 2][$i] = "NULL";
                                 }
                                $nbnull -= 1;
                            }
                        }
                    }

                } $nbedepassage--;
            }
            $listesortie = $table->getElementsByTagName("Sortie");
            foreach ($listesortie as $valsortie) {//foreach appellant les fonctions d'écriture en sortie
                $ini = 0;
                if ($valsortie->hasAttribute("CSV")) {
                    if ($valsortie->getAttribute("CSV") == "True") {
                        FoncEcrireCsv($donnees, $nomfic, $nbligneagenerer,$sortie);
                        $ini++;
                    }
                }
                if ($valsortie->hasAttribute("JSON")) {
                    if ($valsortie->getAttribute("JSON") == "True") {
                        FoncEcrireJson($donnees, $nomfic, $nbligneagenerer,$sortie);
                        $ini++;
                    }
                }
                if ($valsortie->hasAttribute("XML")) {
                    if ($valsortie->getAttribute("XML") == "True") {
                        FoncEcrireXml($donnees, $nomfic, $nbligneagenerer,$sortie);
                        $ini++;
                    }
                }
                if ($valsortie->hasAttribute("SQL")) {
                    if ($valsortie->getAttribute("SQL") == "True") {
                        FoncEcrireSql($donnees, $nomfic, $nbligneagenerer, $PremierPassage,$sortie);
                        $ini++;
                    }
                }

                // La table est sortie, on l'ajoute à notre tableau de données
                array_unshift($donnees, $nomfic); // On ajoute le nom de notre table au tableau de données
                array_push($TablesSorties, $donnees);

                if ($ini == 0) {
                    echo "Aucun format de sortie choisi pour cette table \n";
                }
            }


            //--------------------------------------------------------------------------------------------
            //écriture du rapport
            //--------------------------------------------------------------------------------------------
            foreach ($listeData as $data) {
                $NbNullPostGene = 0;
                $SommeDonnee = 0;
                $NombreDonnee = 0;
                switch ($data->getAttribute("Type")) {
                    case "Formule":
                    case "IMC" :
                    case 'Numerique':
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
                        $NbNullPostGene = 0;
                        while ($i < sizeof($donnees)) {//récupère le nombre de null généré
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
                        } else {//récupère la valeur minimale et maximale
                            if ($PremierPassage == 0) {
                                for ($j = 1; $j < count($donnees[$lignemat]); $j++) {
                                    if ($donnees[$lignemat][$j] != "NULL") {
                                        $ValeurMin = $donnees[$lignemat][$j];
                                        $ValeurMax = $donnees[$lignemat][$j];
                                    }
                                }

                                for ($i = 1; $i < count($donnees[$lignemat]); $i++) {
                                    if ($donnees[$lignemat][$i] != "NULL") {
                                        if ($donnees[$lignemat][$i] < $ValeurMin) {
                                            $ValeurMin = $donnees[$lignemat][$i];
                                        } elseif ($donnees[$lignemat][$i] > $ValeurMax) {
                                            $ValeurMax = $donnees[$lignemat][$i];
                                        }
                                        if (isset($donnees[$lignemat][$i])) {
                                           if (is_numeric($donnees[$lignemat][$i])) {
                                               $SommeDonnee += $donnees[$lignemat][$i];
                                            } ;
                                        } ;
                                        $NombreDonnee++;
                                    }
                                }
                            } else {
                                for ($i = 0; $i < count($donnees[$lignemat]); $i++) {
                                    if ($donnees[$lignemat][$i] != "NULL") {
                                        if ($donnees[$lignemat][$i] < $ValeurMin) {
                                            $ValeurMin = $donnees[$lignemat][$i];
                                        } elseif ($donnees[$lignemat][$i] > $ValeurMax) {
                                            $ValeurMax = $donnees[$lignemat][$i];
                                        }
                                        $SommeDonnee += $donnees[$lignemat][$i];
                                        $NombreDonnee++;
                                    }
                                }
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
                        while ($i < sizeof($donnees)) {
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
        //print_r($donnees);
        FoncEcrireRapport($DonneesRapport, $nbligne,$PositionRapport);
    }
    echo "\n";
    // timestamp en millisecondes de la fin du script
    $timestamp_fin = microtime(true);
    $difference_ms = $timestamp_fin - $timestamp_debut;
    date_default_timezone_set('Europe/Paris');
    setlocale(LC_TIME, 'fr_FR.utf8','fra');
    $nouvellesLigne = "La génération du ".strftime("%A %d %B %Y")." a durée : ".number_format($difference_ms,2)." secondes\n"."==============================================\n";
    $AncienContenu = file($PositionRapport);
    array_unshift($AncienContenu,$nouvellesLigne);
    $new_content = join('',$AncienContenu);
    $fp = fopen($PositionRapport,'w');
    $write = fwrite($fp, $new_content);
    fclose($fp);
}
?>
