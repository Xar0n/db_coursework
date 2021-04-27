CREATE TABLE `aviakompaniya` (
	`shifr` INT(20) NOT NULL AUTO_INCREMENT,
	`nazvanie` varchar(255) NOT NULL UNIQUE,
	`naselennyj_punkt` varchar(255) NOT NULL,
	`ulica` varchar(255) NOT NULL,
	`nomer_doma` varchar(255) NOT NULL,
	`ofis` varchar(255) NOT NULL,
	PRIMARY KEY (`shifr`)
);

CREATE TABLE `kassa` (
	`nomer` INT(20) NOT NULL AUTO_INCREMENT,
	`naselennyj_punkt` varchar(255) NOT NULL,
	`ulica` varchar(255) NOT NULL,
	`nomer_doma` varchar(255) NOT NULL,
	PRIMARY KEY (`nomer`)
);

CREATE TABLE `klient` (
	`nomer_i_seriya_pasporta` varchar(10) NOT NULL,
	`familiya` varchar(255) NOT NULL,
	`imya` varchar(255) NOT NULL,
	`otchestvo` varchar(255) NOT NULL,
	PRIMARY KEY (`nomer_i_seriya_pasporta`)
);

CREATE TABLE `bilet` (
	`nomer` INT(20) NOT NULL AUTO_INCREMENT,
	`shifr_aviakompanii` INT(20) NOT NULL,
	`nomer_kassy` INT(20) NOT NULL,
	`tabelnyj_nomer_kassira` INT(20) NOT NULL,
	`tip` varchar(255) NOT NULL,
	`data_prodazhi` DATE NOT NULL,
	PRIMARY KEY (`nomer`)
);

CREATE TABLE `kupon` (
	`nomer` INT(20) NOT NULL AUTO_INCREMENT,
	`nomer_bileta` INT(20) NOT NULL,
	`nomer_i_seriya_pasporta_klienta` varchar(10) NOT NULL,
	`nunkt_posadki` varchar(255) NOT NULL,
	`nunkt_vysadki` varchar(255) NOT NULL,
	`tarif` INT(10) NOT NULL,
	PRIMARY KEY (`nomer`)
);

CREATE TABLE `kassir` (
	`tabelnyj_nomer` INT(20) NOT NULL AUTO_INCREMENT,
	`familiya` varchar(255) NOT NULL,
	`imya` varchar(255) NOT NULL,
	`otchestvo` varchar(255) NOT NULL,
	PRIMARY KEY (`tabelnyj_nomer`)
);

ALTER TABLE `bilet` ADD CONSTRAINT `bilet_fk0` FOREIGN KEY (`shifr_aviakompanii`) REFERENCES `aviakompaniya`(`shifr`);

ALTER TABLE `bilet` ADD CONSTRAINT `bilet_fk1` FOREIGN KEY (`nomer_kassy`) REFERENCES `kassa`(`nomer`);

ALTER TABLE `bilet` ADD CONSTRAINT `bilet_fk2` FOREIGN KEY (`tabelnyj_nomer_kassira`) REFERENCES `kassir`(`tabelnyj_nomer`);

ALTER TABLE `kupon` ADD CONSTRAINT `kupon_fk0` FOREIGN KEY (`nomer_bileta`) REFERENCES `bilet`(`nomer`);

ALTER TABLE `kupon` ADD CONSTRAINT `kupon_fk1` FOREIGN KEY (`nomer_i_seriya_pasporta_klienta`) REFERENCES `klient`(`nomer_i_seriya_pasporta`);

