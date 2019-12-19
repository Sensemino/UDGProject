<?php
####################################################################################################################

function ecrireFichiers($table,&$TablesSorties,&$donnees,$nbligneagenerer,$sortie,$PremierPassage,$nomfic,$nomClee, $listesortie,$numPassage,$fichierXml) {

####################################################################################################################

# pour debug :  echo " debut de ecrireFichiers \n " ;

    // foreach appellant les fonctions d'écriture en sortie

    foreach ($listesortie as $valsortie) {

        $ini = 0;
# pour debug : echo " CSV " ;
        if ($valsortie->hasAttribute("CSV"))  {
            if ($valsortie->getAttribute("CSV") == "oui") {
                ecrireCsv($donnees, $nomfic, $nbligneagenerer,$sortie,$numPassage);
                $ini++;
            } # fin si
        } # fin si

# pour debug : echo " JSON " ;
        if ($valsortie->hasAttribute("JSON")) {
            if ($valsortie->getAttribute("JSON") == "oui") {
                ecrireJson($donnees, $nomfic, $nbligneagenerer,$sortie, $PremierPassage);
                $ini++;
            } # fin si
        } # fin si

# pour debug : echo " XML " ;
        if ($valsortie->hasAttribute("XML")) {
            if ($valsortie->getAttribute("XML") == "oui") {
                ecrireXml($donnees, $nomfic, $nbligneagenerer,$sortie, $PremierPassage,$fichierXml);
                $ini++;
            } # fin si
        } # fin si

# pour debug : echo " SQL " ;
        if ($valsortie->hasAttribute("SQL")) {
            if ($valsortie->getAttribute("SQL") == "oui") {
                ecrireSql($donnees, $nomfic, $nbligneagenerer, $PremierPassage, $sortie, $nomClee,$fichierXml);
                $ini++;
            } # fin si
        } # fin si

        // La table est sortie, on l'ajoute à notre tableau de données
# pour debug : echo " unshift et push " ;
        array_unshift($donnees, $nomfic);
        // On ajoute le nom de notre table au debut du tableau de données
        array_push($TablesSorties, $donnees);

        if ($ini == 0) {
            echo "Aucun format de sortie choisi pour cette table \n";
            exit(-2) ;
        } # fin si

    } # fin foreach

# pour debug :     echo " fin de ecrireFichiers \n " ;

} # fin de fonction ecrireFichiers

####################################################################################################################

// ecriture de la sortie au format CSV

function ecrireCsv($donnees, $nomfic, $nbligne,$sortie,$numPassage) {

####################################################################################################################

$nbd = count($donnees) ;
# au niveau du premier passage, il faut rajouter les entetes de colonnes
# soit une ligne de plus
if ($numPassage==1) { $nbligne++ ; } ;
# pour debug : print("donnees taille $nbd avec $nbligne lignes a produire passage = $numPassage") ;
#              print_r($donnees) ;
    $reference = array();
    for ($i=0; $i < $nbd; $i++) {
        array_push($reference, array_shift($donnees[$i]));
    } # fin pour i

    $i = 0 ;
    $datafin = array() ;
    $fp = fopen($sortie.$nomfic.".csv", "a+") ;
    $idl = 1 ;
    #while ($i < $nbligne + 1) {
    while ($idl <= $nbligne) {
        $datafin[$idl] = "" ;
        for ($j = 0; $j < count($donnees); $j++) {
            if (isset($donnees[$j][$i])) {
                $datafin[$idl] .= $donnees[$j][$i] . ";" ;
            } else {
                $datafin[$idl] .= "  ; " ;
            } # fin si
        } # fin pour

        if ($datafin[$idl] != "") {
            fputs($fp, $datafin[$idl]) ;
            fputs($fp, "\n") ;
        } # fin si
        $i++ ;
        $idl++ ;
    } # fin tant que
    fclose($fp) ;

# pour debug : echo "datafin " ;
#              print_r($datafin) ;

} # fin fonction ecrireCsv

####################################################################################################################

// ecriture de la sortie au format Json

function ecrireJson($donnees, $nomfic, $nbligne, $sortie, $premierpassage){ //ecriture de la sortie au format JSON

####################################################################################################################

   //$reference = array();

   for ($i=0; $i < count($donnees); $i++) {
      //array_push($reference, array_shift($donnees[$i]));
      if ($premierpassage == 0) {
        array_shift($donnees[$i]);
      } # fin si
   } # fin pour

   $myFile = $sortie.$nomfic.".json";

   $datafin = array();
   $en_tetes = array();


   // Dans un premier temps, on parcourt notre tableau et retire les en-tetes.
   for ($i=0; $i < count($donnees); $i++) {
      $en_tetes[$i] = array_shift($donnees[$i]);
   } # fin pour

   // On sait désormais que $donnees ne contient plus que les données sans les en-tetes.
   for ($i=0; $i < $nbligne; $i++) {

      // C'est dans $row que nous allons écrire les données qui pour chaque en-tete contient une valeur
      // (possiblement nulle selon le fichier de configuration)
      $row = array();

      for ($j=0; $j < count($en_tetes); $j++) {
         $row[$en_tetes[$j]] = $donnees[$j][$i];
      } # fin pour

      $datafin[$i] = $row;

   } # fin pour

   //Convert updated array to JSON
   $jsondata = json_encode($datafin, JSON_PRETTY_PRINT);

   //write json data into data.json file
   file_put_contents($myFile, $jsondata, FILE_APPEND);

} # fin de fonction  ecrireJson

####################################################################################################################

// ecriture de la sortie au format xml

function ecrireXml($donnees, $nomfic, $nbligne, $sortie, $premierpassage,$fichierXml) {

####################################################################################################################

//$reference = array();

  for ($i=0; $i < count($donnees); $i++) {
      //array_push($reference, array_shift($donnees[$i]));
      if ($premierpassage == 0) {
        array_shift($donnees[$i]);
      } # fin si
  } # fin pour

  $xml = new DOMDocument('1.0', 'utf-8');
  $fichier = $sortie.$nomfic.".xml";
  $cmt = $xml->createComment(" generated via $fichierXml ") ;
  $xml->appendChild($cmt) ;

  if (!file_exists($fichier)) {

    $gen = $xml->createElement("Generation"); //crée un élément "Generation"   -->   <Generation> </generation>
    $nomgen = $xml->createTextNode(" ");
    $gen->appendChild($nomgen); //ajoute un noeud fils à $gen appelé $nomgen
    $xml->appendChild($gen);    //ajoute un noeud fils à $xml appelé $gen
    $gene = $xml->getElementsByTagName("Generation")->item(0); //retourne le noeud à l'index 0
    $table = $xml->createElement($nomfic);                     //et on lui rajoute un fils appelé $table
    $gene->appendChild($table);
    $xml->save($fichier);  //sauvregarde et ferme le fichier
  } # fin si

  $xml->load($fichier);

  for ($i = 1; $i <= $nbligne; $i++) {
    $j=0;
    // normalement pour chaque ligne on crée l'élément "ligne"   -->   <ligne> </ligne>
    $row = $xml->createElement("ligne") ;
    //print_r($donnees);
    while ($j < count($donnees)) {
      $tmp = str_replace(' ', '', $donnees[$j][0]);
      $tuple = $xml->createElement($tmp);
      $nomtuple = $xml->createTextNode($donnees[$j][$i]);
      $tuple->appendChild($nomtuple);
      $row->appendChild($tuple);
      $j++;
    }
    $gene = $xml->getElementsByTagName($nomfic)->item(0);
    $gene->appendChild($row);
  } # fin pour
  $xml->save($fichier);
} # fin de fonction ecrireXml

####################################################################################################################

// ecriture de la sortie au format SQL

function ecrireSql($donnees, $nomfic, $nbligne,$PremierPassage,$sortie,$nomClef,$nomXml) {

####################################################################################################################

  $reference = array();

  for ($i=0; $i < count($donnees); $i++)   {
    if ($PremierPassage == 0)
      array_push($reference, array_shift($donnees[$i]));
  } # fin pour

  $fp = fopen($sortie.$nomfic.".sql", "a+");

  if ($PremierPassage == 0) {

    fputs($fp, "# generated via "      . $nomXml . ";\n\n");
    fputs($fp, "DROP TABLE IF EXISTS " . $nomfic . ";\n\n");
    fputs($fp, "CREATE TABLE "         . $nomfic . " (\n");

    $nbc     = count($donnees) ;
    $nomClef = "" ;

    for ($i = 0; $i < $nbc ; $i++) {
      echo " Colonne indice $i numéro " .($i+1)." / $nbc ".$donnees[$i][0] ."\n" ;
      if ($i==0) {
        if (preg_match("/^ID/",strtoupper($donnees[$i][0]))) { $nomClef = $donnees[$i][0] ; } ;
      } ; # fin si

      $deterddt = 0;
      // tant qu'on a pas identifier le type de données
      while ($deterddt==0 && $deterddt < count($donnees)) {
        $temp = gettype($donnees[$i][$deterddt]);
        if ($temp != "NULL") {
          $deterddt = 1 ;

          if ($reference[$i]["reference"] == true) {
            $TableReference   =  $reference[$i]["TableReference"];
            $ColonneReference =  $reference[$i]["ColonneReference"];
            $estReference     = "references $TableReference($ColonneReference)";
          } else {
            $estReference = "";
          } # fin si

          if ($temp == 'string') {
              fputs($fp, "    " . $donnees[$i][0] . " VARCHAR(255) " . $estReference ) ;
          } else {
              fputs($fp, "    " . $donnees[$i][0] . " NUMERIC(9) " . $estReference ) ;
          } # fin si
          if ($i<$nbc-1) {
             fputs($fp, " ,") ;
          } else {
             if ($nomClef!="") {
                fputs($fp, "  ,\n    PRIMARY KEY (`".$nomClef."`)");
             } # fin si
          } ; # fin si
          fputs($fp, "\n") ;
        } else {
          $deterddt++;
        } # fin si non null
      } # fin tant que

      // si le premier champ commence par id, c'est une clef primaire

    } # fin pour

    fputs($fp, ") ; \n\n");

  } # fin si sur premier passage

  // les insertions

  $i = 1;
  $datafin = array();
  while ($i < $nbligne + 1) {
    $datafin[$i] = "INSERT INTO ".$nomfic." (";

    for($champs=0;$champs<count($donnees);$champs++) {
      //print_r($donnees[$champs][0]);
      if ($champs!=count($donnees)-1)
        $datafin[$i] .=$donnees[$champs][0].",";
      else
        $datafin[$i] .=$donnees[$champs][0].")";
    } # fin pour

    $datafin[$i] .= " VALUES (";

    for ($j = 0; $j < count($donnees); $j++) {
      if (isset($donnees[$j][$i])) {
        $temp = $donnees[$j][$i];
        if ($temp != NULL) {
          $typetemp = gettype($donnees[$j][$i]);
        } # fin si
      } else {
        $temp = "NULL";
        $typetemp = gettype($donnees[$j][$i]);
      } # fin si

      if ($j!=count($donnees)-1) {
        if ($typetemp == "string")
          $datafin[$i] .="'".$temp ."'". ",";
        else
          $datafin[$i] .= $temp . ",";
      } else {
        if ($typetemp == "string")
          $datafin[$i] .="'".$temp ."'". "";
        else
          $datafin[$i] .= $temp . "";
      } # fin si
    } # fin pour

    $datafin[$i] .= ") ;";

    fputs($fp, $datafin[$i]);
    fputs($fp, "\n");

    $i++;
  } # fin tant que
  fclose($fp);
} # fin fonction ecrireSql
?>
