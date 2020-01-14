<?php

function creerConcatenation($Concatenation,$nomColonne,$tableauDonneePourConcatenation,&$tableauIdentifiant,$premierPassage)
{
    $tableauDonneeTmp = array();
    
    if($Concatenation == "MotComplet")
    {
        for($i = 0;$i<count($tableauDonneePourConcatenation);$i++)
        {
            if($tableauDonneePourConcatenation[$i][0] == $nomColonne)
            {
                for($j = 1;$j<count($tableauDonneePourConcatenation[$i]);$j++)
                {
                    array_push($tableauDonneeTmp,$tableauDonneePourConcatenation[$i][$j]);
                }
            } 
        }
    }
    else
    {
        for($i = 0;$i<count($tableauDonneePourConcatenation);$i++)
        {
            if($tableauDonneePourConcatenation[$i][0] == $nomColonne)
            {
                for($j = 1;$j<count($tableauDonneePourConcatenation[$i]);$j++)
                {
                    array_push($tableauDonneeTmp,substr($tableauDonneePourConcatenation[$i][$j],0,$Concatenation));
                }
            } 
        }
    }

    

    if($premierPassage == 1)
    {
        for($i = 0;$i<count($tableauDonneeTmp);$i++)
        {
            array_push($tableauIdentifiant,$tableauDonneeTmp[$i]);
        }
    }
    else
    {
        
        for($i = 0;$i<count($tableauDonneeTmp);$i++)
        {
            $tableauIdentifiant[$i] = $tableauIdentifiant[$i].".".$tableauDonneeTmp[$i];
        }
    }
    
}

?>