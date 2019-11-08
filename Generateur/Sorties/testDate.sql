DROP TABLE IF EXISTS testDate;
CREATE TABLE testDate (
idTestDate mediumint(8) unsigned NOT NULL auto_increment,
Celsius NUMERIC(9) ,
Date_et_Heure VARCHAR(255) ,
Nom VARCHAR(255) ,
Prénom VARCHAR(255) ,
Sexe VARCHAR(255) ,
Fahrenheit NUMERIC(9) ,
PRIMARY KEY (`id`)
) AUTO_INCREMENT=1;



INSERT INTO testDate (Celsius,Date_et_Heure,Nom,Prénom,Sexe,Fahrenheit) VALUES (66,'2003-07-17 02:19:00','Courtemanche','Dorothée','Femme',150.8);
INSERT INTO testDate (Celsius,Date_et_Heure,Nom,Prénom,Sexe,Fahrenheit) VALUES (NULL,'2007-08-27 22:58:00','Denis','Yannic','Homme','NULL');
INSERT INTO testDate (Celsius,Date_et_Heure,Nom,Prénom,Sexe,Fahrenheit) VALUES (54,'2017-12-30 18:13:00','Chesnay','Jeanne','Femme',129.2);
INSERT INTO testDate (Celsius,Date_et_Heure,Nom,Prénom,Sexe,Fahrenheit) VALUES (67,'1999-09-03 23:15:00','Sevier','Aline','Femme',152.6);
INSERT INTO testDate (Celsius,Date_et_Heure,Nom,Prénom,Sexe,Fahrenheit) VALUES (54,'2007-08-28 00:40:00','Tessier','Vivienne','Femme',129.2);
INSERT INTO testDate (Celsius,Date_et_Heure,Nom,Prénom,Sexe,Fahrenheit) VALUES (4,'2008-03-11 04:52:00','Bourgeau','Judith','Femme',39.2);
INSERT INTO testDate (Celsius,Date_et_Heure,Nom,Prénom,Sexe,Fahrenheit) VALUES (NULL,'2001-08-02 11:30:00','St-Pierre','Claude','Homme','NULL');
INSERT INTO testDate (Celsius,Date_et_Heure,Nom,Prénom,Sexe,Fahrenheit) VALUES (96,'2003-06-10 04:17:00','Grignon','Gisselle','Femme',204.8);
INSERT INTO testDate (Celsius,Date_et_Heure,Nom,Prénom,Sexe,Fahrenheit) VALUES (43,'2001-04-23 10:19:00','Laforest','Olympe','Femme',109.4);
INSERT INTO testDate (Celsius,Date_et_Heure,Nom,Prénom,Sexe,Fahrenheit) VALUES (36,'2000-04-10 14:48:00','Lacroix','Marcelle','Femme',64.8);
