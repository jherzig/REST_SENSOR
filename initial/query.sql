CREATE SCHEMA `jhesensor` ;

CREATE TABLE `jhesensor`.`tstation` (
  `staKey` INT NOT NULL AUTO_INCREMENT,
  `staName` VARCHAR(250) NULL,
  `staStatndort` VARCHAR(250) NULL,
  `staDescription` VARCHAR(2000) NOT NULL,
  PRIMARY KEY (`staKey`));

  CREATE TABLE `jhesensor`.`tsensor` (
  `senKey` INT NOT NULL AUTO_INCREMENT,
  `senStaId` INT NULL,
  `senName` VARCHAR(250) NULL,
  `senDescription` VARCHAR(2000) NULL,
  PRIMARY KEY (`senKey`));

    CREATE TABLE `jhesensor`.`tsensordata` (
  `sdaKey` INT NOT NULL AUTO_INCREMENT,
  `sdaSenId` INT NULL,
  `sdaDtyId` INT NULL,
  `sdaValue` FLOAT NULL,
  `sdaDt` DATETIME NULL,
  PRIMARY KEY (`sdaKey`),
  CONSTRAINT `sdaSenId`
    FOREIGN KEY (`sdaSenId`)
    REFERENCES `jhesensor`.`tsensor` (`senKey`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `sdaDtyId`
    FOREIGN KEY (`sdaDtyId`)
    REFERENCES `jhesensor`.`tdatatype` (`dtyKey`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


USE `jhesensor`;
CREATE 
     OR REPLACE ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `jhesensor`.`vsensordata` AS
     SELECT 
        `jhesensor`.`tsensordata`.`sdaKey` AS `sdaKey`,
        `jhesensor`.`tsensordata`.`sdaSenId` AS `sdaSenId`,
        `jhesensor`.`tsensordata`.`sdaDtyId` AS `sdaDtyId`,
        `jhesensor`.`tsensordata`.`sdaValue` AS `sdaValue`,
        `jhesensor`.`tsensordata`.`sdaDt` AS `sdaDt`,
        `jhesensor`.`tdatatype`.`dtyName` AS `dtyName`,
        `jhesensor`.`tdatatype`.`dtyUnit` AS `dtyUnit`,
        `jhesensor`.`vsensor`.`senName` AS `senName`,
        `jhesensor`.`vsensor`.`senDescription` AS `senDescription`,
        `jhesensor`.`vsensor`.`staName` AS `staName`,
        `jhesensor`.`vsensor`.`staStatndort` AS `staStatndort`,
        `jhesensor`.`vsensor`.`staDescription` AS `staDescription`
    FROM
        ((`jhesensor`.`tsensordata`
        JOIN `jhesensor`.`tdatatype` ON ((`jhesensor`.`tsensordata`.`sdaDtyId` = `jhesensor`.`tdatatype`.`dtyKey`)))
        JOIN `jhesensor`.`vsensor` ON ((`jhesensor`.`tsensordata`.`sdaSenId` = `jhesensor`.`vsensor`.`senKey`)));


CREATE 
    ALGORITHM = UNDEFINED 
    DEFINER = `root`@`localhost` 
    SQL SECURITY DEFINER
VIEW `jhesensor`.`vsensor` AS
    SELECT 
        `jhesensor`.`tsensor`.`senKey` AS `senKey`,
        `jhesensor`.`tsensor`.`senStaId` AS `senStaId`,
        `jhesensor`.`tsensor`.`senName` AS `senName`,
        `jhesensor`.`tsensor`.`senDescription` AS `senDescription`,
        `jhesensor`.`tstation`.`staName` AS `staName`,
        `jhesensor`.`tstation`.`staStatndort` AS `staStatndort`,
        `jhesensor`.`tstation`.`staDescription` AS `staDescription`
    FROM
        (`jhesensor`.`tsensor`
        JOIN `jhesensor`.`tstation` ON ((`jhesensor`.`tsensor`.`senStaId` = `jhesensor`.`tstation`.`staKey`)))


************

SELECT `tsensordata`.`sdaKey`,
    `tsensordata`.`sdaSenId`,
    `tsensordata`.`sdaDtyId`,
    `tsensordata`.`sdaValue`,
    `tsensordata`.`sdaDt`,
    `tdatatype`.`dtyName`,
    `tdatatype`.`dtyUnit`,
    `tsensor`.`senName`,
    `tsensor`.`senDescription`
FROM ((`jhesensor`.`tsensordata`
INNER JOIN `jhesensor`.`tdatatype` ON `tsensordata`.`sdaDtyId` = `tdatatype`.`dtyKey`)
INNER JOIN `jhesensor`.`tsensor` ON `tsensordata`.`sdaSenId` = `tsensor`.`senKey`);


SELECT `vsensordata`.`sdaKey`,
	`vsensordata`.`sdaDt`,
	`vsensordata`.`senName`,
    `vsensordata`.`senDescription`,
    `vsensordata`.`sdaValue`,
    `vsensordata`.`dtyUnit`
FROM `jhesensor`.`vsensordata`;



///
Übergabe Daten aus Sensoren
sdaDt
sdaValue
dtyUnit
senName
staName
