<?php
function FoncEcrireXml($donnees, $nomfic, $nbligne,$sortie)//ecriture de la sortie au format xml
{

    $reference = array();
    for ($i=0; $i < count($donnees); $i++) { 
        array_push($reference, array_shift($donnees[$i]));
    }

    $xml = new DOMDocument('1.0', 'utf-8');
    $fichier = $sortie.$nomfic.".xml";
    if (!file_exists($fichier)) {
      $gen = $xml->createElement("Generation");
      $nomgen = $xml->createTextNode(" ");
      $gen->appendChild($nomgen);
      $xml->appendChild($gen);
      $xml->save($fichier);
    }
    $xml->load($fichier);
    $table = $xml->createElement($nomfic);
    $gene = $xml->getElementsByTagName("Generation")->item(0);
    $gene->appendChild($table);
    for ($i = 1; $i < $nbligne; $i++) {
      $j=0;
      $row = $xml->createElement("ligne");
      while ($j < count($donnees)) {
        $tmp = str_replace(' ', '', $donnees[$j][0]);
        $tmp = "_".$tmp;
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
