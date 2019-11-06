DROP TABLE IF EXISTS testDate;
CREATE TABLE testDate (
idTestDate mediumint(8) unsigned NOT NULL auto_increment,
Date_et_Heure VARCHAR(255) ,
Nom VARCHAR(255) ,
Prénom VARCHAR(255) ,
Sexe VARCHAR(255) ,
PRIMARY KEY (`id`)
) AUTO_INCREMENT=1;



INSERT INTO testDate (Date_et_Heure,Nom,Prénom,Sexe) VALUES ('2012-07-14 05:25:00','Laderoute','Thibault','Homme');
INSERT INTO testDate (Date_et_Heure,Nom,Prénom,Sexe) VALUES ('1999-01-12 10:28:00','Louis','Morgaine','Femme');
INSERT INTO testDate (Date_et_Heure,Nom,Prénom,Sexe) VALUES ('2009-05-09 21:10:00','Bedard','Marie','Femme');
INSERT INTO testDate (Date_et_Heure,Nom,Prénom,Sexe) VALUES ('2012-12-25 01:15:00','Laderoute','Cunégonde','Femme');
