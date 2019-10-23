<?php

## traitement du formulaire UDG (fichier index.php)

# 1. on crée un nouveau répertoire temporaire dans /tmp

$newTemp = trim(shell_exec("mktemp -d -t -p /tmp")) ;
$nomTemp =  substr($newTemp,5) ; # car on retire /tmp/ soit 5 caractères
$fichierXML = $newTemp."/XMLsite.xml" ;

# 2. on parcourt le formulaire pour préparer le fichier XML de configuration de la génération

$xml = new DOMDocument('1.0', 'utf-8');
$gen = $xml->createElement("Generateur");
$data = array();
$sortieCond = '-1';
foreach ($_POST as $key => $val) {
    $key = trim($key);
    preg_match("/[0-9]+/", $key, $numeroTab);
    preg_match("/[0-9]+$/", $key, $numeroLigne);
    $val = str_replace(" ", "", $val);
    if (strstr($key, "NomTable")) {
        $table = $xml->createElement("Table");
        $champ = $xml->createElement("Champs");
        $parametre = $xml->createElement("Parametres");
        $tableNom = $xml->createElement("NomTable");

        if (isset($_POST["CSV" . $numeroTab[0]]) || isset($_POST["XML" . $numeroTab[0]]) || isset($_POST["SQL" . $numeroTab[0]]) && $sortieCond != $numeroTab[0]) {

            $sortieCond = $numeroTab[0];
            $sortie = $xml->createElement("Sortie");
            if (isset($_POST["CSV" . $numeroTab[0]])) {
                $sortie->setAttribute("CSV", "True");
            }
            if (isset($_POST["XML" . $numeroTab[0]])) {
                $sortie->setAttribute("XML", "True");
            }
            if (isset($_POST["SQL" . $numeroTab[0]])) {
                $sortie->setAttribute("SQL", "True");
            }
        }


        if (isset($_POST["NombreDeLigne" . $numeroTab[0]])) {
            $nbligne = $xml->createElement("Nbligne");
            $nbligne->setAttribute("valeur", $_POST["NombreDeLigne" . $numeroTab[0]]);

        }


        if (isset($_POST["SEED" . $numeroTab[0]])) {
            $seed = $xml->createElement("Seed");
            $seed->setAttribute("valeur", $_POST["SEED" . $numeroTab[0]]);


        }


        $tableNom->setAttribute("nom", $val);
        $parametre->appendChild($sortie);
        $parametre->appendChild($nbligne);

        $parametre->appendChild($tableNom);
        $parametre->appendChild($seed);
        $table->appendChild($champ);
        $table->appendChild($parametre);
        $gen->appendChild($table);
        $xml->appendChild($gen);
    }

    if (strstr($key, "label")) {
        $champ = $xml->getElementsByTagName('Champs')->item($numeroTab[0]);
        $donnee = $xml->createElement("Donnee");
        $donnee->setAttribute("NomColonne", $val);

        if (isset($_POST["tab" . $numeroTab[0] . "TypeDeDonnees" . $numeroLigne[0]])) {
            $donnee->setAttribute("Type", $_POST["tab" . $numeroTab[0] . "TypeDeDonnees" . $numeroLigne[0]]);
            if ($_POST["tab" . $numeroTab[0] . "TypeDeDonnees" . $numeroLigne[0]] == "Dictionnaire") {
                if (isset($_POST["tab" . $numeroTab[0] . "Dictionnaire" . $numeroLigne[0]])) {
                $donnee->setAttribute("NomDictionnaire", $_POST["tab" . $numeroTab[0] . "Dictionnaire" . $numeroLigne[0]]);
                } ;
            }

            if ($_POST["tab" . $numeroTab[0] . "TypeDeDonnees" . $numeroLigne[0]] == "Reference") {
                $donnee->setAttribute("TableReference", $_POST["tab" . $numeroTab[0] . "TableReference" . $numeroLigne[0]]);
                $donnee->setAttribute("ColonneReference", $_POST["tab" . $numeroTab[0] . "ColonneReference" . $numeroLigne[0]]);
            }

            if ($_POST["tab" . $numeroTab[0] . "TypeDeDonnees" . $numeroLigne[0]] == "Formule") {
                $formule=$_POST["tab" . $numeroTab[0] . "AFormule" . $numeroLigne[0]]." ".$_POST["tab" . $numeroTab[0] . "XFormule" . $numeroLigne[0]]." ".$_POST["tab" . $numeroTab[0] . "SelectOp" . $numeroLigne[0]]." ".$_POST["tab" . $numeroTab[0] . "BFormule" . $numeroLigne[0]];
                $donnee->setAttribute("Formule",$formule);
            }


        }
        if (isset($_POST["tab" . $numeroTab[0] . "ModeDeGeneration" . $numeroLigne[0]])) {
            if ($_POST["tab" . $numeroTab[0] . "ModeDeGeneration" . $numeroLigne[0]] == "Aleatoire") {
                $donnee->setAttribute("ModeGeneration", "uniforme");
            } else {
                $donnee->setAttribute("ModeGeneration", $_POST["tab" . $numeroTab[0] . "ModeDeGeneration" . $numeroLigne[0]]);

            }
        }
        if (isset($_POST["tab" . $numeroTab[0] . "LesNull" . $numeroLigne[0]]) && $_POST["tab" . $numeroTab[0] . "LesNull" . $numeroLigne[0]] != '') {
            $donnee->setAttribute("Null", $_POST["tab" . $numeroTab[0] . "LesNull" . $numeroLigne[0]]);
        }

        if (isset($_POST["tab" . $numeroTab[0] . "Min" . $numeroLigne[0]]) && $_POST["tab" . $numeroTab[0] . "Min" . $numeroLigne[0]] != '') {
            $donnee->setAttribute("Min", $_POST["tab" . $numeroTab[0] . "Min" . $numeroLigne[0]]);
        }
        if (isset($_POST["tab" . $numeroTab[0] . "Max" . $numeroLigne[0]]) && $_POST["tab" . $numeroTab[0] . "Max" . $numeroLigne[0]] != '') {
            $donnee->setAttribute("Max", $_POST["tab" . $numeroTab[0] . "Max" . $numeroLigne[0]]);
        }
        if (isset($_POST["tab" . $numeroTab[0] . "Codage" . $numeroLigne[0]]) && $_POST["tab" . $numeroTab[0] . "Codage" . $numeroLigne[0]] != '') {
            $donnee->setAttribute("codage", $_POST["tab" . $numeroTab[0] . "Codage" . $numeroLigne[0]]);
        }
        if(isset($_POST["tab" . $numeroTab[0] . "SelectDependance" . $numeroLigne[0]])){
            $donnee->setAttribute("GenererDependance", $_POST["tab" . $numeroTab[0] . "SelectDependance" . $numeroLigne[0]] );
        }
        $champ->appendChild($donnee);


    }

}

$xml->appendChild($gen) ;
$xml->save($fichierXML) ;
#echo "XML OK*" ;

# 3. on exécute le programme generer.php pour réaliser la génération

$projet     = str_replace(" ","",$_POST["NomProjet"]);
$cheminProjet = $newTemp."/".$projet ;
system("mkdir -p $cheminProjet ");
#echo "MKDIR OK*" ;

$generation = "php generer.php $fichierXML $cheminProjet # ; ls -a $cheminProjet " ;
system($generation);
#echo "GENERATION OK*" ;

# 4. on crée un répertoire projet et l'archive zip avec les fichiers générés dont le rapport

$deplacement = "mv $fichierXML $cheminProjet # ; cat $cheminProjet/$fichierXML " ;
system($deplacement) ;
#echo "DEPLACEMENT OK*" ;

$zipFile = $cheminProjet."/".$projet.'.zip' ;
$zipCmd  = "cd $cheminProjet ; zip $projet * > /dev/null " ;

try{
    system($zipCmd);
    #echo "ZIP OK*" ;
} catch (Exception $e){
    echo 'Exception reÃ§ue : ',  $e->getMessage(), "\n";
}

# 5. on "envoie" le zip via header()

$dbg = 0  ; # 0 en normal, 1 pour debug

if ($dbg==0) {

  $h1 = header('Content-Type: application/zip');
  $h2 = header('Content-Disposition: attachment; filename='.$projet.'.zip');
  header("Content-Transfer-Encoding: Binary");
  #ob_end_flush() ;
  header("Content-Length: ".filesize($zipFile));
   while (ob_get_level()) { ob_end_clean() ; } ;
  $resRF = @readfile($zipFile);

} else {

  echo "<html><head><title>udg</title></head><body><pre>UDG\n\n" ;
  echo " generation  : $generation  \n\n";
  echo " deplacement : $deplacement \n\n";
  echo " zip         : $zipCmd      \n\n";
  echo " archivage   : $zipFile     \n\n";
  echo "</pre></body></html>\n" ;


} # fin si

?>
