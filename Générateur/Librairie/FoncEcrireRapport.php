<?php
function FoncEcrireRapport($DonneesRapport, $nbligne,$PositionRapport) {

    $fp = fopen($PositionRapport, "a+");
    $NumVariable = 0 ;
    $NbVariables = 0 ;
    $nbd = count($DonneesRapport) ;

    # un premier tour  pour d�terminer le nombre de variables

    $i = 0;
#print_r($DonneesRapport) ;
    while (isset($DonneesRapport[$i])){
      $i++ ;
      $NbVariables++ ;
    } # # fintant que

    # et maintenant la description

    $i = 0;
    $NumVariable = 0 ;

    while (isset($DonneesRapport[$i])){

        $infoRapport = $DonneesRapport[$i][1] ;

        switch ($infoRapport) {

            case "Reference" :
            case "Dictionnaire" :
                 $NumVariable++ ;
                 fputs($fp, "  Variable numéro $NumVariable / $NbVariables : " .$DonneesRapport[$i][0] . " type $infoRapport\n\n") ;
                 break ;

            case "id" :
            case "Formule":
            case "IMC"  :
            case 'Numerique' :
            case "IDS" :
            case "CodeArticle" :

                 $NumVariable++ ;

                // on affiche le numéro et le nom de la colonne

                fputs($fp, "  Variable numéro $NumVariable / $NbVariables : " .$DonneesRapport[$i][0] . " type $infoRapport\n\n") ;

                if (isset($DonneesRapport[$i][9])) {

//                    if (!(isset($DonneesRapport[$i][5]))){
//                        print_r($DonneesRapport[$i]);
//                    } # fin si

                    foreach ($DonneesRapport[$i][9] as $key => $value) {//entre le nombre de numéro généré exemple 50 1 et 20 2
                        if($key != $DonneesRapport[$i-1][0]){
                            fputs($fp, "    le nombre de \"" . $key . "\" est de : " . $value . " soit " . (($value / $nbligne) * 100) . " % \n");
                        } # finsi
                    } # fin pour
                } else {
                    if (isset($DonneesRapport[$i][4]) and isset($DonneesRapport[$i][5]) and isset($DonneesRapport[$i][6]) and isset($DonneesRapport[$i][7])) {
## echo " ecrireRapport ligne 58 variable $i type $infoRapport !!\n" ;
                        fputs($fp, "    la valeur minimale est de : " . $DonneesRapport[$i][4]. "\n");
                        fputs($fp, "    la valeur maximale est de : " . $DonneesRapport[$i][5]."\n");
                        if ($DonneesRapport[$i][7]==0) {
                           $moyenne = -1 ;
                        } else {
                           $moyenne = $DonneesRapport[$i][6] / $DonneesRapport[$i][7];
                        } ; # fin si
                        fputs($fp, "    la valeur moyenne  est de : " . number_format($moyenne, 2) . "\n");
                    } # fin si
                } # fin si (isset($DonneesRapport[$i][9])) {

                if (isset($DonneesRapport[$i][8])){
                    fputs($fp, "    les données sont exprimées en " . $DonneesRapport[$i][8]."\n");
                } # fin si

                break;

            case "Dictionnaire" :
                fputs($fp, $DonneesRapport[$i][0] . " : \n");//on entre le nom de la colonne
                break;
        } # fin du switch

        if(isset($DonneesRapport[$i][3]) and isset($DonneesRapport[$i][2])){
            fputs($fp, "    le nombre      de valeurs NULL est de : " . sprintf("%6d",$DonneesRapport[$i][2])  . " \n");
            fputs($fp, "    le pourcentage de valeurs NULL est de : " . sprintf("%6.0f",$DonneesRapport[$i][3]) . " % \n");
        } # fin si
        #fputs($fp, "   ----------------------------------------------\n");
        fputs($fp,"\n");
        $i++;
    } # fin tant que (isset($DonneesRapport[$i]))
    fclose($fp);

} # fin de fonction FoncEcrireRapport
?>
