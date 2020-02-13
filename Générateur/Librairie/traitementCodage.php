<?php

    function traitementCodage(&$donnees,$tab_codage,$i,$j)
    {
        if(substr($tab_codage[$j],0,1) == "<")
        {
            if (($donnees[$i] < intval(substr($tab_codage[$j],1))) && ($donnees[$i] >= intval(substr($tab_codage[$j-2],1)))) {
                $donnees[$i] = $tab_codage[$j + 1];
            } # fin si
        }
        else
        {
            if (($donnees[$i] > intval(substr($tab_codage[$j],1))) && ($donnees[$i] <= intval(substr($tab_codage[$j+2],1)))) {
                $donnees[$i] = $tab_codage[$j + 1];
            } # fin si
        }
    }

?>