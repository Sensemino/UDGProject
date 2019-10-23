<?php
function FoncEcrireCsv($donnees, $nomfic, $nbligne,$sortie)//ecriture de la sortie au format CSV
{

    $reference = array();
    for ($i=0; $i < count($donnees); $i++) { 
        array_push($reference, array_shift($donnees[$i]));
    }

    $i = 0;
    $datafin = array();
    $fp = fopen($sortie.$nomfic.".csv", "w+");
    while ($i < $nbligne + 1) {
        $datafin[$i] = "";
        for ($j = 0; $j < count($donnees); $j++) {
            if (isset($donnees[$j][$i])) {
                $datafin[$i] .= $donnees[$j][$i] . ";";
            }
        }
        if ($datafin[$i] != "") {
            fputs($fp, $datafin[$i]);
            fputs($fp, "\n");
        }
        $i++;
    }
    fclose($fp);    
}
?>
