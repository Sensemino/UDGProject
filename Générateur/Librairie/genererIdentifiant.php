<?php

//Créer un identifiant avec une table Nom et Prenom de façon dynamiques

function genererIdentifiant($donnees,$NomColonneConcatene,$Concatenation) 
{
    $tableauIdentifiant = Array();
    $tableauNomColonne = explode(";",$NomColonneConcatene);
    $tableauConcatenation = explode(".",$Concatenation);
    $tableauDonneePourConcatenation = array();
    $premierPassage = 1;
    
    for($i=0;$i<count($donnees);$i++)
    {
        foreach($tableauNomColonne as $cle=>$valeur)
        {
            if(preg_match("/".$donnees[$i][1]."/mD",$tableauNomColonne[$cle]))
            {
                $tableauDonneeTmp = array();

                for($j = 1;$j<count($donnees[$i]);$j++)
                {
                    array_push($tableauDonneeTmp,$donnees[$i][$j]);
                } # fin pour

                array_push($tableauDonneePourConcatenation,$tableauDonneeTmp);
                unset($tableauDonneeTmp);
            } # fin si
        } # fin pour
            
    } # fin pour
    
    for($i = 0;$i<count($tableauNomColonne);$i++)
    {
        if(preg_match("/".$tableauNomColonne[$i]."/mD",$Concatenation))
        {
            creerConcatenation("MotComplet",$tableauNomColonne[$i],$tableauDonneePourConcatenation,$tableauIdentifiant,$premierPassage);
        }
        elseif(substr($tableauConcatenation[$i],0) == substr($tableauNomColonne[$i],0,strlen($tableauConcatenation[$i])))
        {
            creerConcatenation(strlen(substr($tableauConcatenation[$i],0)),$tableauNomColonne[$i],$tableauDonneePourConcatenation,$tableauIdentifiant,$premierPassage);
        }
        $premierPassage++;
    }

    return $tableauIdentifiant;

} # fin fonction genererIdentifiant
?>