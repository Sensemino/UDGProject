DROP TABLE IF EXISTS temperatures;
CREATE TABLE temperatures (
id mediumint(8) unsigned NOT NULL auto_increment,
Celsius NUMERIC(9) ,
fahrenheit NUMERIC(9) ,
PRIMARY KEY (`id`)
) AUTO_INCREMENT=1;



INSERT INTO temperatures (Celsius,fahrenheit) VALUES (79,174.2);
INSERT INTO temperatures (Celsius,fahrenheit) VALUES (NULL,NULL);
INSERT INTO temperatures (Celsius,fahrenheit) VALUES (NULL,NULL);
INSERT INTO temperatures (Celsius,fahrenheit) VALUES (83,181.4);
INSERT INTO temperatures (Celsius,fahrenheit) VALUES (69,156.2);
INSERT INTO temperatures (Celsius,fahrenheit) VALUES (13,55.4);
INSERT INTO temperatures (Celsius,fahrenheit) VALUES (31,87.8);
INSERT INTO temperatures (Celsius,fahrenheit) VALUES (52,125.6);
INSERT INTO temperatures (Celsius,fahrenheit) VALUES (64,147.2);
INSERT INTO temperatures (Celsius,fahrenheit) VALUES (49,88.2);
