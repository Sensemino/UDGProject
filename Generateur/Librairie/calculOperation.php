<?php
function calculOperation($operateur,$x,$y)
{
    $resultat = 0;
    switch ($operateur)
    {
        case '*' :
            if($x == Null || $y == Null)
                return Null;
            else
                $resultat = $x * $y;
            break;
        case '/' :
            if($x == Null || $y == Null)
                return Null;
            else
                $resultat = $x / $y;
            break;
        case '%' :
            if($x == Null || $y == Null)
                return Null;
            else
                $resultat = $x % $y;
            break;
        case '-' :
            if($x == Null || $y == Null)
                return Null;
            else
                $resultat = $x - $y;
            break;
        case '+' :
            if($x == Null || $y == Null)
                return Null;
            else
                $resultat = $x + $y;
            break;
    }
    return $resultat;
}
?>