# generated via Exemples/minimal.xml;

DROP TABLE IF EXISTS minimal_formule;

CREATE TABLE minimal_formule (
    id VARCHAR(255)  ,
    double VARCHAR(255)  ,
    triPlusUn VARCHAR(255)  ,
    cinqPlus7 VARCHAR(255)  ,
    longueur VARCHAR(255)  ,
    largeur VARCHAR(255)  ,
    aire VARCHAR(255)   ,
    PRIMARY KEY (`id`)
) ; 

INSERT INTO minimal_formule (id,double,triPlusUn,cinqPlus7,longueur,largeur,aire) VALUES (1,2,4,12,3,2,6) ;
INSERT INTO minimal_formule (id,double,triPlusUn,cinqPlus7,longueur,largeur,aire) VALUES (2,4,7,17,5,3,15) ;
INSERT INTO minimal_formule (id,double,triPlusUn,cinqPlus7,longueur,largeur,aire) VALUES (3,6,10,22,3,5,15) ;
INSERT INTO minimal_formule (id,double,triPlusUn,cinqPlus7,longueur,largeur,aire) VALUES (4,8,13,27,1,5,5) ;
INSERT INTO minimal_formule (id,double,triPlusUn,cinqPlus7,longueur,largeur,aire) VALUES (5,10,16,32,1,2,2) ;
INSERT INTO minimal_formule (id,double,triPlusUn,cinqPlus7,longueur,largeur,aire) VALUES (6,12,19,37,3,2,6) ;
