<?php
function connaitreOperateur($operateur)
{
    switch ($operateur)
    {
        case '*' :
            return '*';
            break;
        case '/' :
            return '/';
            break;
        case '%' :
            return '%';
            break;
        case '-' :
            return '-';
            break;
        case '+' :
            return '+';
            break;
        default :
            return Null;
            break;
    }
}
?>