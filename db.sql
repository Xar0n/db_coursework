CREATE TABLE `aviakompaniya` (
	`id` INT(20) NOT NULL AUTO_INCREMENT,
	`nazvanie` varchar(255) NOT NULL UNIQUE,
	`naselennyj_punkt` varchar(255) NOT NULL,
	`ulica` varchar(255) NOT NULL,
	`nomer_doma` varchar(255) NOT NULL,
	`ofis` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `kassa` (
	`id` INT(20) NOT NULL AUTO_INCREMENT,
	`naselennyj_punkt` varchar(255) NOT NULL,
	`ulica` varchar(255) NOT NULL,
	`nomer_doma` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `klient` (
	`id` INT(20) NOT NULL AUTO_INCREMENT,
	`nomer_i_seriya_pasporta` varchar(10) NOT NULL UNIQUE,
	`familiya` varchar(255) NOT NULL,
	`imya` varchar(255) NOT NULL,
	`otchestvo` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `bilet` (
	`id` INT(20) NOT NULL AUTO_INCREMENT,
	`shifr_aviakompanii` INT(20) NOT NULL,
	`nomer_kassy` INT(20) NOT NULL,
	`tabelnyj_nomer_kassira` INT(20) NOT NULL,
	`tip` varchar(255) NOT NULL,
	`data_prodazhi` DATE NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `kupon` (
	`id` INT(20) NOT NULL AUTO_INCREMENT,
	`nomer_bileta` INT(20) NOT NULL,
	`nomer_i_seriya_pasporta_klienta` varchar(10) NOT NULL,
	`nunkt_posadki` varchar(255) NOT NULL,
	`nunkt_vysadki` varchar(255) NOT NULL,
	`tarif` INT(10) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `kassir` (
	`id` INT(20) NOT NULL AUTO_INCREMENT,
	`nomer_kassy` INT(20) NOT NULL,
	`familiya` varchar(255) NOT NULL,
	`imya` varchar(255) NOT NULL,
	`otchestvo` varchar(255) NOT NULL,
	PRIMARY KEY (`id`)
);

ALTER TABLE `bilet` ADD CONSTRAINT `bilet_fk0` FOREIGN KEY (`shifr_aviakompanii`) REFERENCES `aviakompaniya`(`id`);

ALTER TABLE `bilet` ADD CONSTRAINT `bilet_fk1` FOREIGN KEY (`nomer_kassy`) REFERENCES `kassa`(`id`);

ALTER TABLE `bilet` ADD CONSTRAINT `bilet_fk2` FOREIGN KEY (`tabelnyj_nomer_kassira`) REFERENCES `kassir`(`id`);

ALTER TABLE `kupon` ADD CONSTRAINT `kupon_fk0` FOREIGN KEY (`nomer_bileta`) REFERENCES `bilet`(`id`);

ALTER TABLE `kupon` ADD CONSTRAINT `kupon_fk1` FOREIGN KEY (`nomer_i_seriya_pasporta_klienta`) REFERENCES `klient`(`nomer_i_seriya_pasporta`);

ALTER TABLE `kassir` ADD CONSTRAINT `kassir_fk0` FOREIGN KEY (`nomer_kassy`) REFERENCES `kassa`(`id`);

