# generated via Exemples/minimal.xml;

DROP TABLE IF EXISTS minimal_horairesDepart;

CREATE TABLE minimal_horairesDepart (
    NomTrain VARCHAR(255)  ,
    villeDepart VARCHAR(255)  ,
    horaireDepart VARCHAR(255)  ,
    TypeTrain VARCHAR(255)  ,
    villeArrivee VARCHAR(255)  ,
    horaireArrivee VARCHAR(255) 
) ; 

INSERT INTO minimal_horairesDepart (NomTrain,villeDepart,horaireDepart,TypeTrain,villeArrivee,horaireArrivee) VALUES ('SNCF-000001','Minsk','2019-11-06 11:00:00','TRAIN CHARBON','Lisbonne','2019-11-06 16:04:00') ;
INSERT INTO minimal_horairesDepart (NomTrain,villeDepart,horaireDepart,TypeTrain,villeArrivee,horaireArrivee) VALUES ('SNCF-000002','Bratislava','2019-11-06 13:02:00','TRAIN CHARBON','Vatican','2019-11-06 18:16:00') ;
INSERT INTO minimal_horairesDepart (NomTrain,villeDepart,horaireDepart,TypeTrain,villeArrivee,horaireArrivee) VALUES ('SNCF-000003','Prague','2019-11-06 10:09:00','TGV','Sofia','2019-11-06 17:22:00') ;
