DROP TABLE IF EXISTS Temperatures;
CREATE TABLE Temperatures (
idTemperatures mediumint(8) unsigned PRIMARY KEY NOT NULL auto_increment,
Type de train VARCHAR(255) ,
Celsius NUMERIC(9) ,
Fahrenheit NUMERIC(9) ,
PRIMARY KEY (`idTemperatures`)
) AUTO_INCREMENT=1;



INSERT INTO Temperatures (Type de train,Celsius,Fahrenheit) VALUES ('TRAIN CHARBON',48,118.4);
INSERT INTO Temperatures (Type de train,Celsius,Fahrenheit) VALUES ('TER EXPRESS',64,147.2);
INSERT INTO Temperatures (Type de train,Celsius,Fahrenheit) VALUES ('TER EXPRESS',13,55.4);
INSERT INTO Temperatures (Type de train,Celsius,Fahrenheit) VALUES ('TRAIN CHARBON',78,172.4);
INSERT INTO Temperatures (Type de train,Celsius,Fahrenheit) VALUES ('TRAIN CHARBON',90,194);
INSERT INTO Temperatures (Type de train,Celsius,Fahrenheit) VALUES ('TER EXPRESS',82,179.6);
INSERT INTO Temperatures (Type de train,Celsius,Fahrenheit) VALUES ('TER EXPRESS',60,140);
INSERT INTO Temperatures (Type de train,Celsius,Fahrenheit) VALUES ('TRAIN CHARBON',38,100.4);
INSERT INTO Temperatures (Type de train,Celsius,Fahrenheit) VALUES ('TRAIN CHARBON',90,194);
INSERT INTO Temperatures (Type de train,Celsius,Fahrenheit) VALUES ('TER EXPRESS',19,66.2);
INSERT INTO Temperatures (Type de train,Celsius,Fahrenheit) VALUES ('TER EXPRESS',NULL,NULL);
INSERT INTO Temperatures (Type de train,Celsius,Fahrenheit) VALUES ('TER EXPRESS',NULL,NULL);
INSERT INTO Temperatures (Type de train,Celsius,Fahrenheit) VALUES ('TER EXPRESS',78,172.4);
INSERT INTO Temperatures (Type de train,Celsius,Fahrenheit) VALUES ('TER EXPRESS',3,37.4);
INSERT INTO Temperatures (Type de train,Celsius,Fahrenheit) VALUES ('TER EXPRESS',68,122.4);
