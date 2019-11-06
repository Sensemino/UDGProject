<?php

function genererDateHeure($nbligne, $dhmin, $dhmax) {//remplie un tableau en créant dans chaque case une date aléatoire.
    $dhgene = array(); //dh = dateheure
    if(preg_match('#(\d\d\d\d)-(\d\d)-(\d\d).(\d\d):(\d\d):(\d\d)#', $dhmin) == True) {
        $anneemin = substr($dhmin, '0', '4');    //
        $moismin = substr($dhmin, '5', '2');     // Récupération de l'année, du mois, et du jour minimum.
        $jourmin = substr($dhmin, '8', '2');     //

        $heuremin = substr($dhmin, '11', '2');   // Récupération de l'heure et de la minute minimale.
        $minutemin = substr($dhmin, '14', '2');  // 

        /*echo($anneemin."\n");
        echo($moismin."\n");
        echo($jourmin."\n");
        echo($heuremin."\n");
        echo($minutemin."\n");*/

    }
    
    if(preg_match('#(\d\d\d\d)-(\d\d)-(\d\d).(\d\d):(\d\d)#', $dhmax) == True) {
        $anneemax = substr($dhmax, '0', '4');    //
        $moismax = substr($dhmax, '5', '2');     // Récupération de l'année, du mois, et du jour maximum.
        $jourmax = substr($dhmax, '8', '2');     //

        $heuremax = substr($dhmax, '11', '2');   // Récupération de l'heure et de la minute maximale.
        $minutemax = substr($dhmax, '14', '2');  // 

        /*echo($anneemax."\n");
        echo($moismax."\n");
        echo($jourmax."\n");
        echo($heuremax."\n");
        echo($minutemax."\n");*/
        
    }

    //Création de tableaux contenant toutes les parties (années, mois, etc...) maintenant qu'on a bien le min et le max.

    $geneannee = genererNumerique($nbligne, $anneemin, $anneemax, 0);

    if($anneemax == $anneemin) {
        $genemois = genererNumerique($nbligne, $moismin, $moismax, 0);
    }
    else
    {
        $genemois = genererNumerique($nbligne, 01, 12, 0);
    }   
    if ($moismin == $moismax)
    {
        $genejour = genererNumerique($nbligne, $jourmin, $jourmax, 0);
    }   
    else
    {
        $genejour = genererNumerique($nbligne, 01, 31, 0);
    }  
    if ($jourmin == $jourmax)
    {
        $geneheure = genererNumerique($nbligne, $heuremin, $heuremax, 0);
    }   
    else
    {
        $geneheure = genererNumerique($nbligne, 00, 23, 0);
    }   
    if ($heuremin == $heuremax)
    {
        $geneminute = genererNumerique($nbligne, $minutemin, $minutemax, 0);
    }  
    else
    {
        $geneminute = genererNumerique($nbligne, 00, 59, 0);
    }

    $dhgene = array();

    for ($c = 0; $c < $nbligne; $c++) 
    {
        $dhgene[$c] = str_pad ($geneannee[$c], 4, 0, STR_PAD_LEFT) . '-' . str_pad ($genemois[$c], 2, 0, STR_PAD_LEFT) . '-' . str_pad ($genejour[$c], 2, 0, STR_PAD_LEFT) . ' ' . str_pad ($geneheure[$c], 2, 0, STR_PAD_LEFT) . ':' . str_pad ($geneminute[$c], 2, 0, STR_PAD_LEFT) . ':00';
    }

    //$test = strtotime($dhgene[2]); //passer en timestamp

    return $dhgene;

    //$dhgene = date("Y-m-d H:i:s", mktime(00, 00, 00, 11, 5, 2019));
}

?>