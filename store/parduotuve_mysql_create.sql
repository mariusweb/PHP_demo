CREATE TABLE `vartotojai` (
	`id` bigint NOT NULL AUTO_INCREMENT,
	`vardas` varchar(45) NOT NULL,
	`pavarde` varchar(45) NOT NULL,
	`slaptazodis` varchar(225) NOT NULL,
	PRIMARY KEY (`id`)
);

CREATE TABLE `vertinimas` (
	`vartotojo_id` bigint NOT NULL,
	`vertinimas` DECIMAL(10,1) NOT NULL
);

CREATE TABLE `cart_userid` (
	`vartotojo_id` bigint NOT NULL,
	`preke` varchar(70) NOT NULL
);

ALTER TABLE `vertinimas` ADD CONSTRAINT `vertinimas_fk0` FOREIGN KEY (`vartotojo_id`) REFERENCES `vartotojai`(`id`);

ALTER TABLE `cart_userid` ADD CONSTRAINT `cart_userid_fk0` FOREIGN KEY (`vartotojo_id`) REFERENCES `vartotojai`(`id`);

INSERT  INTO `vartotojai` (`vardas`, `pavarde`, `slaptazodis`) 
VALUES ("Marius", "Mariauskas", SHA1("112")),
("Tomas", "Tomasius", SHA1("911"));

