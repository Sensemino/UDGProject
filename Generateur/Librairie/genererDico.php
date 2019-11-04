<?php
function genererDico($nbligne, $NomDonnees, $GenererDep){//remplie un tableau en piochant aléatoirement dans un dictionnaire
    $dicogene = array();
    $nomdico = strtolower($NomDonnees);
    $fichier = file("Dictionnaires/Dico_" . $nomdico . ".txt");
    $lignefichier = count($fichier);
    for ($j = 0; $j < $nbligne; $j++) {
        $ligne = rand(1, $lignefichier - 1);

        $mots = preg_split('/\t+/', $fichier[$ligne]);
        $dicogene[0][$j] = ucfirst($mots[0]);



        if(count($mots) > 1 && $GenererDep) {
            if ($nomdico == 'prenoms') {
                preg_match('/\s[f,m]\,*[f,m]*/', $fichier[$ligne], $mot2);
                $mot2[0] = trim($mot2[0]);
                $mot2[0] = substr($mot2[0], 0, 1);

                if ($mot2[0] == 'f') {
                    $sexe = 'Femme';
                } else {
                    $sexe = 'Homme';
                }
                $dicogene[1][$j] = $sexe;

            }

            if ($nomdico == 'villes') {
                $mots = preg_split('/[0-9]+/', $fichier[$ligne]);
                $dicogene[0][$j] = trim(ucfirst($mots[0]));

                preg_match('/[0-9]+/', $fichier[$ligne], $codePostale);
                $dicogene[1][$j] = $codePostale[0];
            }
        }
    }
    
    foreach($dicogene as $key1=>$h)
    {
        foreach($h as $key2=>$v)
        {
            $dicogene[$key1][$key2] = str_replace("\n", "", $dicogene[$key1][$key2]);
        }
    }
    return $dicogene;
}
?>
