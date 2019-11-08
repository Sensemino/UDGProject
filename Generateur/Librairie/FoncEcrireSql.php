<?php
function FoncEcrireSql($donnees, $nomfic, $nbligne,$PremierPassage,$sortie,$nomClee){//ecriture de la sortie au format SQL

  $reference = array();
  for ($i=0; $i < count($donnees); $i++) 
  { 
    if($PremierPassage == 0)
      array_push($reference, array_shift($donnees[$i]));
  }

  $fp = fopen($sortie.$nomfic.".sql", "a+");

  if($PremierPassage == 0)
  {
    fputs($fp, "DROP TABLE IF EXISTS " . $nomfic . ";\n");
    fputs($fp, "CREATE TABLE " . $nomfic . " (\n");

    if(empty($nomClee)) //on verifie si le nom de la clé est vide = entier auto incrementé par defaut
    {
      fputs($fp, "id".ucfirst($nomfic)." mediumint(8) unsigned PRIMARY KEY NOT NULL auto_increment,\n"); //identifiant par défaut
    }

    for ($i = 0; $i < count($donnees); $i++) 
    {
      $deterddt = 1;
      while ($deterddt != 0 && $deterddt < count($donnees)) //tant qu'on a pas identifier le type de données
      {
        $temp = gettype($donnees[$i][$deterddt]);
        if ($temp != "NULL") 
        {
          $deterddt = 0;

          if($reference[$i]["reference"] == true)
          {
            $TableReference =  $reference[$i]["TableReference"];
            $ColonneReference =  $reference[$i]["ColonneReference"];
            $estReference = "references $TableReference($ColonneReference)";
          }
          else
          {
            $estReference = "";
          }

          if ($temp == 'string') 
          {
            fputs($fp, $donnees[$i][0] . " VARCHAR(255) " . $estReference .",\n");
          } 
          else 
          {
            fputs($fp, $donnees[$i][0] . " NUMERIC(9) " . $estReference .",\n");
          }
        } 
        else 
        {
          $deterddt++;
        }
      }
    }
    
    if(!empty($nomClee)) //on verifie si le nom de la clé n'est pas vide
    {
      fputs($fp, "PRIMARY KEY (`".$nomClee."`)\n");
      fputs($fp, ");\n\n\n\n");
    }
    else
    {
      fputs($fp, "PRIMARY KEY (`id".ucfirst($nomfic)."`)\n");
      fputs($fp, ") AUTO_INCREMENT=1;\n\n\n\n");
    }
  }
  //les insert
  $i = 1;
  $datafin = array();
  while ($i < $nbligne + 1) 
  {
    $datafin[$i] = "INSERT INTO ".$nomfic." (";

    for($champs=0;$champs<count($donnees);$champs++) 
    {
      //print_r($donnees[$champs][0]);
      if($champs!=count($donnees)-1)
        $datafin[$i] .=$donnees[$champs][0].",";
      else 
        $datafin[$i] .=$donnees[$champs][0].")";
    }
    $datafin[$i] .=" VALUES (";
    for ($j = 0; $j < count($donnees); $j++) 
    {
      if(isset($donnees[$j][$i])) 
      {
        $temp = $donnees[$j][$i];
        if ($temp != NULL) 
        {
          $typetemp = gettype($donnees[$j][$i]);
        }
      }
      else 
      { 
        $temp = "NULL";
        $typetemp = gettype($donnees[$j][$i]);
      }

      if($j!=count($donnees)-1)
      {
        if($typetemp == "string")
          $datafin[$i] .="'".$temp ."'". ",";
        else
          $datafin[$i] .= $temp . ",";
      }
      else
      {
        if($typetemp == "string")
          $datafin[$i] .="'".$temp ."'". "";
        else
          $datafin[$i] .= $temp . "";
      }
    }
    $datafin[$i] .=");";

    fputs($fp, $datafin[$i]);
    fputs($fp, "\n");

    $i++;
  }
  fclose($fp);
}
?>
