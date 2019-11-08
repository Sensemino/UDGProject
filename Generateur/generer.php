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

//Fichier XML sur le premier parmètre

if(isset($argv[1])) //Test de l'existance du premier paramètre en ligne de commande
{
    $fichier = $argv[1];        //récupération du fichier XML
}
else
{
    echo "Aucun fichier n'a été donné en paramètre\n";
    echo "Il faut ajouter le nom du fichier XML après le generer.php\n";
    exit(1);
}
if(!file_exists($fichier)) //Test pour verifier l'accès au premier paramètre en ligne de commande
{
    echo "Mauvais nom de fichier\n";   
    exit(1);
}

//Sortie sur le second paramètre 

$sortie = "Sorties/"; //dossier de sortie par défaut

if(isset($argv[2])) //Test de l'existance du second paramètre en ligne de commande
{
    if(!file_exists($argv[2])) //Test pour verifier l'accès au second paramètre en ligne de commande
    {
        echo "Dossier intouvable pour le second paramètre\n";
        echo "Il faut ajouter un nom de dossier valable pour la sortie ou ne pas en mettre pour qu'elle soit automatiquement à Generateur/Sorties\n";
        exit(1);
    }
    else
        $sortie = $argv[2]."/"; //récupération du dossier
}

$PositionRapport = $sortie."Rapport_De_Generation.txt";
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
    $listeRows = $table->getElementsByTagName("Nbligne");//récupération du nombre de ligne pour la table en cours

    $compteurPassage = 0; //variable incrementée permettant l'identification pour IDS (genererIDS.php) pour chaque table

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

    //-------------------------------------------------------------
    //Vérification et suppression des fichiers de sorties existants
    //-------------------------------------------------------------

    $listesortie = $table->getElementsByTagName("Sortie");

    foreach ($listesortie as $valsortie) {//foreach appellant les fonctions d'écriture en sortie
        if (file_exists($sortie.$nomfic.".csv") && ($valsortie->hasAttribute("CSV")) && ($valsortie->getAttribute("CSV") == "True"))
            unlink($sortie.$nomfic.".csv");
        if (file_exists($sortie.$nomfic.".xml") && ($valsortie->hasAttribute("XML")) && ($valsortie->getAttribute("XML") == "True"))
            unlink($sortie.$nomfic.".xml");
        if (file_exists($sortie.$nomfic.".sql") && ($valsortie->hasAttribute("SQL")) && ($valsortie->getAttribute("SQL") == "True"))
            unlink($sortie.$nomfic.".sql");
        if (file_exists($sortie.$nomfic.".json") && ($valsortie->hasAttribute("JSON")) && ($valsortie->getAttribute("JSON") == "True"))
            unlink($sortie.$nomfic.".json");
    }
    
    $listeData = $table->getElementsByTagName("Donnee");//récupération des différent champ a générer
    $n=10; //nombre de lignes max stockées par passage (constante)
    $nbligneagenerer = $n; // initialisation du nombre de ligne max a générer par passage qui va être modifié
    $nbedepassageInitial = $nbligne / $n; //initialisation du nombre de passage (constante)
    echo("Nombre de lignes en tout= ".$nbligne."\n");
    echo("Nombre de lignes à générer en une fois = ".$n."\n");
    echo("Nombre de passages Initial = ".$nbedepassageInitial."\n");
    $nbedepassage = $nbedepassageInitial; //on récupère le nombre de passage qui va évoluer avec la génération de donnée
    $PremierPassage = 0;
    

    while ($nbedepassage > 0) {
        $donnees = NULL;
        $lignemat = 0;
        if ($nbedepassage < 1) {//si il reste moins d'un passage (- de 100 000 lignes) on met le nombre de ligne a générer restante
            $nbligneagenerer = $nbligne % $n;
            echo("Dernier passage, il y aura ".$nbligne % $n." lignes à générer.\n");
        }
        echo("Je passe une fois ici, et je prends ".$nbligneagenerer." valeurs !\n");

        //--------------------------------------------------------------------------------------------
        //RECUPERATION DES DONNEES
        //--------------------------------------------------------------------------------------------
            
        genererDonnees($listeData, $donnees, $DonneesRapport, $PremierPassage, $nbligneagenerer, $nbligne, $lignemat, $nbedepassage, $nbedepassageInitial, $compteurPassage);
        
        //--------------------------------------------------------------------------------------------
        //ECRITURE DES DIFFERTENTS FICHIERS EN SORTIE
        //--------------------------------------------------------------------------------------------
        
        $nomClee = nomClePerso($listeData); //on teste l'existance d'une clee personnalisé ex : IDS
        
        ecrireFichiers($table, $TablesSorties, $donnees, $nbligneagenerer, $sortie, $PremierPassage, $nomfic, $nomClee, $listesortie);

        //--------------------------------------------------------------------------------------------
        //GENERATION DU RAPPORT A PARTIR DES DONNEES
        //--------------------------------------------------------------------------------------------

        genererRapport($listeData, $donnees, $DonneesRapport, $PremierPassage, $nbligneagenerer);
        
        $PremierPassage = 1;//on indique qu'il y a eu au moins un passage

        $nbedepassage--;
        
    }
    FoncEcrireRapport($DonneesRapport, $nbligne,$PositionRapport);
       
}



echo "Génération effectuée\n";
// timestamp en millisecondes de la fin du script
$timestamp_fin = microtime(true);
$difference_ms = $timestamp_fin - $timestamp_debut;
date_default_timezone_set('Europe/Paris');
setlocale(LC_TIME, 'fr_FR.utf8','fra');
$nouvellesLigne = "La génération du ".strftime("%A %d %B %Y")." à ".strftime("%H:%M:%S")." a durée : ".number_format($difference_ms,2)." secondes\n"."==================================================\n";
$AncienContenu = file($PositionRapport);
array_unshift($AncienContenu,$nouvellesLigne);
$new_content = join('',$AncienContenu);
$fp = fopen($PositionRapport,'w');
$write = fwrite($fp, $new_content);
fclose($fp);
?>