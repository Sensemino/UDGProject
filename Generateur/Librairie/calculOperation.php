<?php
function calculOperation($operateur,$x,$y)
{
    $resultat = 0;
    switch ($operateur)
    {
        case '*' :
            if($y == Null)
                $resultat = $x;
            elseif($x == Null)
                $resultat = $y;
            elseif($x == Null && $y == Null)
                return Null;
            else
                $resultat = $x * $y;
            break;
        case '/' :
            if($y == Null)
                $resultat = $x;
            elseif($x == Null)
                $resultat = $y;
            elseif($x == Null && $y == Null)
                return Null;
            else
                $resultat = $x / $y;
            break;
        case '%' :
            if($y == Null)
                $resultat = $x;
            elseif($x == Null)
                $resultat = $y;
            elseif($x == Null && $y == Null)
                return Null;
            else
                $resultat = $x % $y;
            break;
        case '-' :
            if($y == Null)
                $resultat = $x;
            elseif($x == Null)
                $resultat = $y;
            elseif($x == Null && $y == Null)
                return Null;
            else
                $resultat = $x - $y;
            break;
        case '+' :
            if($y == Null)
                $resultat = $x;
            elseif($x == Null)
                $resultat = $y;
            elseif($x == Null && $y == Null)
                return Null;
            else
                $resultat = $x + $y;
            break;
    }
    return $resultat;
}
?>