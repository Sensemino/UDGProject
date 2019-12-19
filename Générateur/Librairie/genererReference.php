<?php

	function genererReference($donnees, $nbligne, $TableReference, $ColonneReference){ // remplissage des valeurs pour les references tables liées

		$array_reference = array(); // On créer le tableau qui contiendra le tableau de réference voulu

		// On parcourt toutes les données, lorsqu'on trouve la table voulue, on la met dans notre variable (systeme de pointage)
		for ($i=0; $i < count($donnees); $i++) {
			if($donnees[$i][0] == $TableReference){
				$array_reference = $donnees[$i];
				break;
			}
		}

		array_shift($array_reference); // On ne conserve pas le nom de la table
		
		for ($i=0; $i < count($array_reference); $i++) {
			array_shift($array_reference[$i]);// On ne s'interesse pas à si les colonnes vont reference à une table
			if($array_reference[$i][0] == $ColonneReference){
				$array_reference = $array_reference[$i]; // On ne garde que la colonne que l'on veut
				break;
			}
		}

		// À ce stade, $array_reference ne contient que la colonne voulue de la table voulue

		
		array_shift($array_reference); // On ne garde pas le nom de la colonne

		$reference = array();
		for ($j = 0; $j < $nbligne; $j++) {
			$reference[$j] = $array_reference[(rand(0,count($array_reference) - 1))];
		}

		return $reference;
	
	}

?>
