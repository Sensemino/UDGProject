<?php

//Fonctions


require('TestNull.php');
require('LesNulls.php');
require('nbNull.php');
require('maximum.php');
require('minimum.php');
require('somme.php');
require('make_seed.php');
require('MDGAleatoire.php');
require('nomClePerso.php');
require('calculEquation.php');
require('creerConcatenation.php');
require('traitementCodage.php');

require('genererDico.php');
require('genererNumerique.php');
require('genererFormule.php');
require('genererDateHeure.php');
require('genererReference.php');
require('genererCodeArticle.php');
require('genererIdentifiant.php');
require('codage.php');
require('imc.php');
require('genererIDS.php');

require('ecrireFichiers.php');
// contient ecrireFichiers()
//          ecrireCsv()
//          ecrireJson()
//          ecrireXml()
//          ecrireSql()

require('FoncEcrireRapport.php');

require('genererRapport.php');
require('genererDonnees.php');

// une petite fonction de factorisation :

function valeurAttribut($element,$nomAttribut,$parDefaut="") {

/*

##################################################################################################################
#
# exemple 1 de code :
#
#
    $listeRows = $table->getElementsByTagName("NbLigne") ;

    // variable incrementée permettant l'identification pour IDS (genererIDS.php) pour chaque table

    $compteurPassage = 0 ;
    $nbligne = 0 ;

    foreach ($listeRows as $rows) {

        if ($rows->hasAttribute("valeur")) {
            $nbligne = $rows->getAttribute("valeur") ; //on recupère le nombre de ligne a générer
        } # fin si

    } # fin pour
#
# exemple 2 de code :
#
                 $nbChiffres = 3 ;
                 if ($dataLigne->hasAttribute("NbChiffres")) {
                     $nbChiffres = $dataLigne->getAttribute("NbChiffres") ;
                 } ; # fin si
# exemple 3 de code :

                 if ($data->hasAttribute("Suffixe")) {
                     $Suffixe = $data->getAttribute("Suffixe");
                 } else {
                     $Suffixe = 0 ;
                 } ; # fin si

#  ==> on peut remplaver avantageusement ces codes par
#
#  $nbligne    = valeurAttribut($data,"Nbligne",0) ;
#  $nbChiffres = valeurAttribut($dataLigne,"NbChiffres",3) ;
#  $suffixe    = valeurAttribut($data,"Suffixe",0) ;
#
##################################################################################################################

*/

$attrib = $parDefaut ;

if ($element->hasAttribute($nomAttribut)) {
   $attrib  = $element->getAttribute($nomAttribut) ;
} # fin si

return $attrib ;

} # fin de fonction valeurAttribut

?>
