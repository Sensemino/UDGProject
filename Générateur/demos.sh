## exemple de vérification
#  verifieXml Exemples/desAges.xml
## exemple de vérification et de génération
#  verifieXml Exemples/trains.xml    ; generer Exemples/trains.xml    ; wc -l Sorties/horaires*  ; cat Sorties/horairesDepart.csv

# tous les exemples de base sont dans  Exemples/minimal.xml, soit 9 tables à générer

rm Sorties/* ; generer Exemples/minimal.xml ; wc -l Sorties/* ; tail -n 1000 Sorties/*
