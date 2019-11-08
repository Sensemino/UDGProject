<?php
function FoncEcrireXml($donnees, $nomfic, $nbligne, $sortie, $premierpassage)//ecriture de la sortie au format xml
{

  //$reference = array();
  for ($i=0; $i < count($donnees); $i++) { 
      //array_push($reference, array_shift($donnees[$i]));
      if($premierpassage == 0) {
        array_shift($donnees[$i]);
      }
  }
  print_r($donnees);

  $xml = new DOMDocument('1.0', 'utf-8');
  $fichier = $sortie.$nomfic.".xml";
  if (!file_exists($fichier)) {
    $gen = $xml->createElement("Generation"); //crée un élément "Generation"   -->   <Generation> </generation>
    $nomgen = $xml->createTextNode(" ");
    $gen->appendChild($nomgen); //ajoute un noeud fils à $gen appelé $nomgen
    $xml->appendChild($gen);    //ajoute un noeud fils à $xml appelé $gen
    $gene = $xml->getElementsByTagName("Generation")->item(0); //retourne le noeud à l'index 0 (je pense comme un tableau $xml["Generation"][0])
    $table = $xml->createElement($nomfic);                     //et on lui rajoute un fils appelé $table
    $gene->appendChild($table);
    $xml->save($fichier);  //sauvregarde et ferme le fichier
  }
  $xml->load($fichier);
  for ($i = 1; $i <= $nbligne; $i++) {
    $j=0;
    $row = $xml->createElement("ligne"); //normalement pour chaque ligne on crée l'élément "ligne"   -->   <ligne> </ligne>
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
  }
  $xml->save($fichier);
}
?>
