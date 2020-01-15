<?php

function creerConcatenation($Concatenation,$nomColonne,$tableauDonneePourConcatenation,&$tableauIdentifiant,$premierPassage)
{
    $tableauDonneeTmp = array();
    
    if($Concatenation == "MotComplet")              //Mets les mots en entier dans le tableauDonneeTmp
    {
        for($i = 0;$i<count($tableauDonneePourConcatenation);$i++)          //Parcours de la premier colonne du tableau
        {
            if($tableauDonneePourConcatenation[$i][0] == $nomColonne)           //Vérification pour trouver les données correspondantes au nom de la colonne
            {
                for($j = 1;$j<count($tableauDonneePourConcatenation[$i]);$j++)          //Parcours de la deuxième colonne du tableau
                {
                    array_push($tableauDonneeTmp,$tableauDonneePourConcatenation[$i][$j]);
                }
            } 
        }
    }
    else                                //Mets les mots concatenés dans le tableauTmp
    {
        for($i = 0;$i<count($tableauDonneePourConcatenation);$i++)          //Parcours de la premier colonne du tableau
        {
            if($tableauDonneePourConcatenation[$i][0] == $nomColonne)           //Vérification pour trouver les données correspondantes au nom de la colonne
            {
                for($j = 1;$j<count($tableauDonneePourConcatenation[$i]);$j++)          //Parcours de la deuxième colonne du tableau
                {
                    array_push($tableauDonneeTmp,substr($tableauDonneePourConcatenation[$i][$j],0,$Concatenation));
                }
            } 
        }
    }

    

    if($premierPassage == true)                 //si c'est le premier passage alors on met dans le tableauIdentifiant directement
    {
        for($i = 0;$i<count($tableauDonneeTmp);$i++)
        {
            array_push($tableauIdentifiant,$tableauDonneeTmp[$i]);
        }
    }
    else                            //sinon on concatene les chaînes 
    {
        
        for($i = 0;$i<count($tableauDonneeTmp);$i++)
        {
            if(isset($tableauIdentifiant[$i]))          //Vérifie si la case existe
            {
                $tableauIdentifiant[$i] = $tableauIdentifiant[$i].".".$tableauDonneeTmp[$i];
            }
        }
    }
    
}

?>