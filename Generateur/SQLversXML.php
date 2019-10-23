<?php
/**
 * generer.php
 *
 * Ce programme permet la génération de données.
 * En lien direct avec le fichier Parametre.XML.
 *
 * @version 1.0
 * @author Brice Harismendy <brice.harismendy@etud.univ-angers.fr> ,
 * @author Corentin Couvry <corentin.couvry@etud.univ-angers.fr> ,
 * @author Geoffroy Berry <geoffroy.berry@etud.univ-angers.fr>
 *
 * @project Generateur_de_donnees
 */


if(isset($_POST["sqlTexte"]))
    $stringSQL=$_POST["sqlTexte"];

$doss="mktemp -d -t -p /tmp";
$nomDossierTemp=system($doss);


$fp=fopen($nomDossierTemp."/FichiertempSQL.txt","a+");
fwrite($fp,$stringSQL);
fclose($fp);


//ouverture du fichier
$fichiersql = fopen($nomDossierTemp."/FichiertempSQL.txt", "r+");
$xml = new DOMDocument('1.0', 'utf-8');



$cheminFichier =$nomDossierTemp."/"."genererDuSQL.xml";
//echo $cheminFichier;



$gen = $xml->createElement("Generateur");
$nomgen = $xml->createTextNode(" ");
$gen->appendChild($nomgen);
$xml->appendChild($gen);


//$xml->validate();


while(!feof($fichiersql)){
    $ligne = fgets($fichiersql);


    //Si ligne create table atteinte
    if(preg_match('/^CREATE TABLE/', $ligne)){
        //ajout d'elements dans le fichier xml
        // $nomTable= explode(" ",$ligne); //on prendra le deuxième élément qui contient le nom de la table


        $nomTable=preg_replace('/[A-Z]*|\`|\s|\(/','',$ligne);
        $table = $xml->createElement("Table");
        $champ = $xml->createElement("Champs");
        $parametre = $xml->createElement("Parametre");

        $tableNom=$xml->createElement("NomTable");
        $tableNom->setAttribute("nom",$nomTable);

        //Parcours des lignes de la creation de la table
        while(!preg_match("/^[)]/", $ligne)) {
            $ligne = fgets($fichiersql);
            $ligne = trim($ligne, " ");

            $mots = explode(" ", $ligne);
            $mots[1]=preg_replace('/\(|\)|\,|[0-9]*/','',$mots[1]);
            if ($mots[1]=="int" || $mots[1]=="double" || $mots[1]=="float"){
                $mots[1]="Numerique";
//                 $champ->appendChild($donnee);

            }
            elseif ($mots[1]=="varchar"){
                $mots[1]="Dictionnaire";


            }
            if (!preg_match("/^[)]/", $ligne)){
                $donnee=$xml->createElement("Donnee");
                $donnee->setAttribute("Type",$mots[1]);
                $donnee->setAttribute("NomColonne",trim($mots[0],"\`"));

                $champ->appendChild($donnee);
            }


        }
        $sortie=$xml->createElement("Sortie");
        $parametre->appendChild($sortie);

        $nbligne=$xml->createElement("Nbligne");
        $parametre->appendChild($nbligne);

        $parametre->appendChild($tableNom);

        $table->appendChild($champ);
        $table->appendChild($parametre);
        $gen->appendChild($table);

        $xml->save($cheminFichier);

    }

}

$fichierXML = fopen($cheminFichier, "r+");

while(!feof($fichierXML)){
    $l = fgets($fichierXML);
    echo $l;
}

fclose($cheminFichier);


fclose($fichiersql);
//echo $cheminFichier;

?>