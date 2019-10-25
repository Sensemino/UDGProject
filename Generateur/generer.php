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

require('Librairie/lib.php');

$TablesSorties = array();

/*
TablesSorties = Tableau contenant les tables déjà sorties
Elles servent dans le cas où on veut une donnée reference (tables liées), on va piocher dedans.
*/

$donnees = array();   //matrice qui contiendra les données
$DonneesRapport = array();
$numtable = 1;       //sert pour connaitre la table sur lequel on travail pour le rapport de génération
$lignemat = 0;      //nombre de colonne de la matrice
$dom = new DOMDocument();
$moduloseed=5;
$sortie = "Sorties/";

//Test du premier parametre en ligne de commande
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

//Sortie sur le second paramètre
if(isset($argv[2]))
    $sortie = $argv[2]."/";

$PositionRapport = $sortie."Rapport_De_Génération.txt";
// timestamp en millisecondes du début du script (en PHP 5)
$timestamp_debut = microtime(true);
if (!$dom->load($fichier) ||( !$dom->schemaValidate("udg.xsd"))) // validation du fichier XML
{    
    echo "le fichier XML est invalide"; 
    exit(1);
}

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

        //--------------------------------------------------------------------------------------------
        //RECUPERATION DES DONNEES
        //--------------------------------------------------------------------------------------------
            
        genererDonnees($listeData,$donnees,$DonneesRapport,$PremierPassage,$nbligneagenerer,$lignemat,$nbedepassage,$nbligne);

        //--------------------------------------------------------------------------------------------
        //ECRITURE DES DIFFERTENTS FICHIERS EN SORTIE
        //--------------------------------------------------------------------------------------------
            
        
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

            if ($ini == 0)
                echo "Aucun format de sortie choisi pour cette table \n";
        }

        //--------------------------------------------------------------------------------------------
        //GENERATION DU RAPPORT A PARTIR DES DONNEES
        //--------------------------------------------------------------------------------------------
        genererRapport($listeData,$donnees,$DonneesRapport,$PremierPassage,$nbligneagenerer);
    }

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
?>
