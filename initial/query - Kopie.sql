CREATE TABLE `jherzig_api`.`tstation` (
  `staKey` INT NOT NULL AUTO_INCREMENT,
  `staName` VARCHAR(250) NULL,
  `staStatndort` VARCHAR(250) NULL,
  `staDescription` VARCHAR(2000) NOT NULL,
  PRIMARY KEY (`staKey`));
  
   CREATE TABLE `jherzig_api`.`tsensor` (
  `senKey` INT NOT NULL AUTO_INCREMENT,
  `senStaId` INT NULL,
  `senName` VARCHAR(250) NULL,
  `senDescription` VARCHAR(2000) NULL,
  PRIMARY KEY (`senKey`));
  
CREATE TABLE `jherzig_api`.`tdatatype` (
  `dtyKey` int(11) NOT NULL AUTO_INCREMENT,
  `dtyName` varchar(250) DEFAULT NULL,
  `dtyUnit` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`dtyKey`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;


CREATE TABLE `jherzig_api`.`tsensordata` (
  `sdaKey` int(11) NOT NULL AUTO_INCREMENT,
  `sdaSenId` int(11) DEFAULT NULL,
  `sdaDtyId` int(11) DEFAULT NULL,
  `sdaValue` float DEFAULT NULL,
  `sdaDt` datetime DEFAULT NULL,
  PRIMARY KEY (`sdaKey`),
  KEY `sdaSenId` (`sdaSenId`),
  KEY `sdaDtyId` (`sdaDtyId`),
  CONSTRAINT `sdaDtyId` FOREIGN KEY (`sdaDtyId`) REFERENCES `jherzig_api`.`tdatatype` (`dtyKey`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `sdaSenId` FOREIGN KEY (`sdaSenId`) REFERENCES `jherzig_api`.`tsensor` (`senKey`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;



CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `jherzig_api`.`vsensor` 
AS select `jherzig_api`.`tsensor`.`senKey` 
AS `senKey`,`jherzig_api`.`tsensor`.`senStaId` 
AS `senStaId`,`jherzig_api`.`tsensor`.`senName` 
AS `senName`,`jherzig_api`.`tsensor`.`senDescription` 
AS `senDescription`,`jherzig_api`.`tstation`.`staName` 
AS `staName`,`jherzig_api`.`tstation`.`staStatndort` 
AS `staStatndort`,`jherzig_api`.`tstation`.`staDescription` 
AS `staDescription` 
from (`jherzig_api`.`tsensor` join `jherzig_api`.`tstation` on((`jherzig_api`.`tsensor`.`senStaId` = `jherzig_api`.`tstation`.`staKey`)));


CREATE ALGORITHM=UNDEFINED SQL SECURITY DEFINER VIEW `jherzig_api`.`vsensordata` 
AS select `jherzig_api`.`tsensordata`.`sdaKey` 
AS `sdaKey`,`jherzig_api`.`tsensordata`.`sdaSenId` 
AS `sdaSenId`,`jherzig_api`.`tsensordata`.`sdaDtyId` 
AS `sdaDtyId`,`jherzig_api`.`tsensordata`.`sdaValue` 
AS `sdaValue`,`jherzig_api`.`tsensordata`.`sdaDt` 
AS `sdaDt`,`jherzig_api`.`tdatatype`.`dtyName` 
AS `dtyName`,`jherzig_api`.`tdatatype`.`dtyUnit` 
AS `dtyUnit`,`vsensor`.`senName` 
AS `senName`,`vsensor`.`senDescription` 
AS `senDescription`,`vsensor`.`staName` 
AS `staName`,`vsensor`.`staStatndort` 
AS `staStatndort`,`vsensor`.`staDescription` 
AS `staDescription` from ((`jherzig_api`.`tsensordata` join `jherzig_api`.`tdatatype` on((`jherzig_api`.`tsensordata`.`sdaDtyId` = `jherzig_api`.`tdatatype`.`dtyKey`))) join `jherzig_api`.`vsensor` on((`jherzig_api`.`tsensordata`.`sdaSenId` = `vsensor`.`senKey`)));
