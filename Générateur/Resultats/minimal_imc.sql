# generated via Exemples/minimal.xml;

DROP TABLE IF EXISTS minimal_imc;

CREATE TABLE minimal_imc (
    id VARCHAR(255)  ,
    age VARCHAR(255)  ,
    poids VARCHAR(255)  ,
    taille VARCHAR(255)  ,
    imc VARCHAR(255)   ,
    PRIMARY KEY (`id`)
) ; 

INSERT INTO minimal_imc (id,age,poids,taille,imc) VALUES (1,36,94,181,28.7) ;
INSERT INTO minimal_imc (id,age,poids,taille,imc) VALUES (2,60,105,150,46.7) ;
INSERT INTO minimal_imc (id,age,poids,taille,imc) VALUES (3,32,90,192,24.4) ;
INSERT INTO minimal_imc (id,age,poids,taille,imc) VALUES (4,98,83,184,24.5) ;
INSERT INTO minimal_imc (id,age,poids,taille,imc) VALUES (5,28,93,142,46.1) ;
INSERT INTO minimal_imc (id,age,poids,taille,imc) VALUES (6,89,65,150,28.9) ;
