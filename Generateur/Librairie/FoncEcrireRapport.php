<?php
function FoncEcrireRapport($DonneesRapport, $nbligne,$PositionRapport)
{
    $fp = fopen($PositionRapport, "a+");
    $i = 0;
    while(isset($DonneesRapport[$i])){
        switch ($DonneesRapport[$i][1]){
            case "Formule":
            case "IMC" :
            case 'Numerique':
                fputs($fp, $DonneesRapport[$i][0] . " : \n");//on entre le nom de la colonne
                if(isset($DonneesRapport[$i][8])){
                    fputs($fp, "Les données sont exprimer en " . $DonneesRapport[$i][8]."\n");
                }
                if(isset($DonneesRapport[$i][9])){
//                    if(!(isset($DonneesRapport[$i][5]))){
//                        print_r($DonneesRapport[$i]);
//                    }
                    foreach ($DonneesRapport[$i][9] as $key => $value) {//entre le nombre de numéro généré exemple 50 1 et 20 2
                        if($key != $DonneesRapport[$i-1][0]){
                            fputs($fp, "Le nombre de \"" . $key . "\" est de : " . $value . " soit " . (($value / $nbligne) * 100) . " % \n");
                        }
                    }
                }else{
                    if(isset($DonneesRapport[$i][4]) and isset($DonneesRapport[$i][5]) and isset($DonneesRapport[$i][6]) and isset($DonneesRapport[$i][7])){
                        fputs($fp, "La valeur minimale est de : " . $DonneesRapport[$i][4]. "\n");
                        fputs($fp, "La valeur maximale est de : " . $DonneesRapport[$i][5]."\n");
                        $moyenne = $DonneesRapport[$i][6] / $DonneesRapport[$i][7];
                        fputs($fp, "La valeur moyenne est de : " . number_format($moyenne, 2) . "\n");
                    }
                }
                break;
            case "Dictionnaire" :
                fputs($fp, $DonneesRapport[$i][0] . " : \n");//on entre le nom de la colonne
                break;
        }
        if(isset($DonneesRapport[$i][3]) and isset($DonneesRapport[$i][2])){
            fputs($fp, "Le nombre de Valeur null est de : " . $DonneesRapport[$i][2]  . " \n");
            fputs($fp, "Le pourcentage de valeur null est de : " . $DonneesRapport[$i][3] . " % \n");
        }
        fputs($fp, "==================================================\n");
        $i++;
        }
        fclose($fp);
}
?>