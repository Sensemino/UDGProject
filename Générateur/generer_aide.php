<?php
error_reporting(E_ALL | E_NOTICE | E_STRICT ) ;

/**
* generer_aide.php
*
* Ce sous-programme fournit une aide minimale pour la génération de données en ligne de commandes.
*
* @version 1.0
* @author Gilles HUNAULT <gilles.hunault@univ-angers.fr>
*
* @project Generateur_de_donnees
*/

function aide($parm="") {

  $parmOk = 0 ;

  if ($parm=="champs") { $parm = "colonnes" ; } ;

  if ($parm=="") {
    echo "\n" ;
    echo " Aide pour le programme generer :\n\n" ;
    echo "    utiliser generer --aide colonnes   pour plus d'explications sur les champs (colonnes)   \n\n" ;
    echo "    utiliser generer --aide parametres pour plus d'explications sur les parametres \n" ;
    $parmOk = 1 ;
  } ; # fin si

  if ($parm=="colonnes") {
    echo "\n" ;
    echo " Aide pour le programme generer : définition des champs (colonnes) \n\n" ;
    echo " Pour chaque colonne à générer, il faut au minimum un nom et un type.\n" ;
    echo " En fonction des types, il y a éventuellement d'autres valeurs à renseigner, \n" ;
    echo " comme par exemple le min et le max pour une génération numérique.\n" ;
    echo "\n" ;
    echo " Exemples de types implémentés :\n" ;
    echo "   id            -- identifiant numérique                                                  \n" ;
    echo "   Dictionnaire  -- valeur lue dans un dictionnaire (nom de famille, code postal...)       \n" ;
    echo "   IDS           -- identifiant caractère avec masque de remplissage                       \n" ;
    echo "   Formule       -- calcul du genre aX+b                                                    \n" ;
    echo "   DateHeure     -- avec DateHeureMin et DateHeureMax                                      \n" ;
    echo "   Numérique     -- entier ou non, avec recodage ou non                                    \n" ;
    $parmOk = 1 ;
  } ; # fin si

  if ($parm=="parametres") {
    echo "\n" ;
    echo " Aide pour le programme generer : définition des paramètres\n\n" ;
    echo " Il y a 4 paramètres à renseigner, le dernier étant facultatif.\n\n" ;
    echo "   Paramètre 1 : NomTable -- le nom des fichiers à produire\n" ;
    echo "   Paramètre 2 : Sortie   -- le(s) type(s) de fichier à produire (CSV, XML, JSON, SQL)\n" ;
    echo "   Paramètre 3 : NbLigne  -- le nombre de lignes à générer\n" ;
    echo "   Paramètre 4 : Graine   -- une valeur numérique facultative pour le tirage aléatoire\n" ;
    $parmOk = 1 ;
  } ; # fin si

  if ($parmOk == 0) {
      echo " paramètre $parm non reconnu.\n" ;
  } ; # fin si

  echo "\n" ;
  echo " Consulter http://forge.info.univ-angers.fr/~gh/Udg/aide.php pour plus de renseignements sur le fichier XML à écrire.\n" ;
  echo "\n" ;
  exit(2) ;

} ; # fin de fonction aide

?>
