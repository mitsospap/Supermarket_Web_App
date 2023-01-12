CREATE SCHEMA `supermarket` ;
USE `supermarket` ;

CREATE TABLE `supermarket`.`user` (
  `id` INT UNSIGNED NOT NULL ,
  `username` VARCHAR(45) NOT NULL,
  `email` VARCHAR(45) NOT NULL,
  `password` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;

CREATE TABLE `supermarket`.`STORE` (
  `STORE_id` INT UNSIGNED NOT NULL ,
  `Size` VARCHAR(45) NOT NULL,
  `Operating_Hours` VARCHAR(15) NOT NULL,
  `City` VARCHAR(45) NOT NULL,
  `Postal_Code` INT NOT NULL,
  `Street` VARCHAR(45) NOT NULL,
  `Number` INT NOT NULL,
  PRIMARY KEY (`STORE_id`),
  UNIQUE INDEX `STORE_id_UNIQUE` (`STORE_id` ASC))
ENGINE = InnoDB;

CREATE TABLE `supermarket`.`Category` (
  `Category_id` INT UNSIGNED NOT NULL,
  `Name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`Category_id`),
  UNIQUE INDEX `Category_id_UNIQUE` (`Category_id` ASC),
  UNIQUE INDEX `Name_UNIQUE` (`Name` ASC))
ENGINE = InnoDB;

CREATE TABLE `supermarket`.`STORE_has_Category` (
  `STORE_STORE_id` INT UNSIGNED NOT NULL,
  `Category_Category_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`STORE_STORE_id`, `Category_Category_id`),
  INDEX `fk_STORE_has_Category_Category1_idx` (`Category_Category_id` ASC),
  INDEX `fk_STORE_has_Category_STORE1_idx` (`STORE_STORE_id` ASC),
  CONSTRAINT `fk_STORE_has_Category_STORE1`
    FOREIGN KEY (`STORE_STORE_id`)
    REFERENCES `supermarket`.`STORE` (`STORE_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_STORE_has_Category_Category1`
    FOREIGN KEY (`Category_Category_id`)
    REFERENCES `supermarket`.`Category` (`Category_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE `supermarket`.`Store_Phone#` (
  `Phone` VARCHAR(20) NOT NULL,
  `STORE_STORE_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Phone`, `STORE_STORE_id`),
  INDEX `fk_Phone#_STORE1_idx` (`STORE_STORE_id` ASC),
  CONSTRAINT `fk_Phone#_STORE1`
    FOREIGN KEY (`STORE_STORE_id`)
    REFERENCES `supermarket`.`STORE` (`STORE_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE `supermarket`.`PRODUCT` (
  `Barcode` NUMERIC(5,0) NOT NULL,
  `Name` VARCHAR(45) NOT NULL,
  `Brand_name` TINYINT NOT NULL,
  `Price` FLOAT UNSIGNED NOT NULL,
  `Category_Category_id` INT UNSIGNED NOT NULL,
  `Starting_Date` DATE NOT NULL,
  PRIMARY KEY (`Barcode`, `Category_Category_id`),
  UNIQUE INDEX `Barcode_UNIQUE` (`Barcode` ASC),
  INDEX `fk_PRODUCT_Category1_idx` (`Category_Category_id` ASC),
  CONSTRAINT `fk_PRODUCT_Category1`
    FOREIGN KEY (`Category_Category_id`)
    REFERENCES `supermarket`.`Category` (`Category_id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE`supermarket`.`STORE_has_PRODUCT` (
  `STORE_STORE_id` INT UNSIGNED NOT NULL,
  `PRODUCT_Barcode` NUMERIC(5,0) NOT NULL,
  `PRODUCT_Category_Category_id` INT UNSIGNED NOT NULL,
  `alley` INT UNSIGNED NOT NULL,
  `shelf` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`STORE_STORE_id`, `PRODUCT_Barcode`, `PRODUCT_Category_Category_id`),
  INDEX `fk_STORE_has_PRODUCT_PRODUCT1_idx` (`PRODUCT_Barcode` ASC, `PRODUCT_Category_Category_id` ASC),
  INDEX `fk_STORE_has_PRODUCT_STORE1_idx` (`STORE_STORE_id` ASC),
  CONSTRAINT `fk_STORE_has_PRODUCT_STORE1`
    FOREIGN KEY (`STORE_STORE_id`)
    REFERENCES `supermarket`.`STORE` (`STORE_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_STORE_has_PRODUCT_PRODUCT1`
    FOREIGN KEY (`PRODUCT_Barcode` , `PRODUCT_Category_Category_id`)
    REFERENCES `supermarket`.`PRODUCT` (`Barcode` , `Category_Category_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE `supermarket`.`OLDER_PRICES` (
  `Start_Date` DATE NOT NULL,
  `Price` FLOAT UNSIGNED NOT NULL,
  `End_Date` DATE NOT NULL,
  `PRODUCT_Barcode` NUMERIC(5,0) NOT NULL,
  `PRODUCT_Category_Category_id` INT UNSIGNED NOT NULL,
  INDEX `fk_OLDER_PRICES_PRODUCT1_idx` (`PRODUCT_Barcode` ASC, `PRODUCT_Category_Category_id` ASC),
  PRIMARY KEY (`PRODUCT_Barcode`, `PRODUCT_Category_Category_id`, `Start_Date`),
  CONSTRAINT `fk_OLDER_PRICES_PRODUCT1`
    FOREIGN KEY (`PRODUCT_Barcode` , `PRODUCT_Category_Category_id`)
    REFERENCES `supermarket`.`PRODUCT` (`Barcode` , `Category_Category_id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

CREATE TABLE `supermarket`.`Customer` (
  `Card#` INT UNSIGNED NOT NULL,
  `Name` VARCHAR(45) NOT NULL,
  `Date_of_Birth` DATE NULL,
  `Points` INT UNSIGNED NULL DEFAULT 0,
  `Family_Members` INT UNSIGNED NULL,
  `Pet` VARCHAR(45) NULL,
  `City` VARCHAR(45) NOT NULL,
  `Postal_Code` INT NOT NULL,
  `Street` VARCHAR(45) NOT NULL,
  `Number` INT UNSIGNED NOT NULL,
  `Age` INT GENERATED ALWAYS AS (year(CURRENT_TIMESTAMP) - year(date_of_birth)) VIRTUAL,
  PRIMARY KEY (`Card#`),
  UNIQUE INDEX `Card#_UNIQUE` (`Card#` ASC))
ENGINE = InnoDB;


CREATE TABLE `supermarket`.`TRANSACTION` (
  `Date_Time` DATETIME NOT NULL,
  `Payment_Method` VARCHAR(45) NOT NULL,
  `Total_Pieces` INT UNSIGNED NOT NULL DEFAULT 0,
  `Total_Amount` FLOAT UNSIGNED NOT NULL DEFAULT 0,
  `Customer_Card#` INT UNSIGNED NOT NULL,
  `STORE_STORE_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Date_Time`, `STORE_STORE_id`),
  INDEX `fk_TRANSACTION_Customer1_idx` (`Customer_Card#` ASC),
  INDEX `fk_TRANSACTION_STORE1_idx` (`STORE_STORE_id` ASC),
  CONSTRAINT `fk_TRANSACTION_Customer1`
    FOREIGN KEY (`Customer_Card#`)
    REFERENCES `supermarket`.`Customer` (`Card#`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_TRANSACTION_STORE1`
    FOREIGN KEY (`STORE_STORE_id`)
    REFERENCES `supermarket`.`STORE` (`STORE_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE `supermarket`.`PRODUCT_has_TRANSACTION` (
  `PRODUCT_Barcode` DECIMAL(5,0) UNSIGNED NOT NULL,
  `PRODUCT_Category_Category_id` INT UNSIGNED NOT NULL,
  `Pieces` INT NOT NULL,
  `TRANSACTION_Date_Time` DATETIME NOT NULL,
  `TRANSACTION_STORE_STORE_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`PRODUCT_Barcode`, `PRODUCT_Category_Category_id`, `TRANSACTION_Date_Time`, `TRANSACTION_STORE_STORE_id`),
  INDEX `fk_PRODUCT_has_TRANSACTION_PRODUCT1_idx` (`PRODUCT_Barcode` ASC, `PRODUCT_Category_Category_id` ASC),
  INDEX `fk_PRODUCT_has_TRANSACTION_TRANSACTION1_idx` (`TRANSACTION_Date_Time` ASC, `TRANSACTION_STORE_STORE_id` ASC),
  CONSTRAINT `fk_PRODUCT_has_TRANSACTION_PRODUCT1`
    FOREIGN KEY (`PRODUCT_Barcode` , `PRODUCT_Category_Category_id`)
    REFERENCES `supermarket`.`PRODUCT` (`Barcode` , `Category_Category_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_PRODUCT_has_TRANSACTION_TRANSACTION1`
    FOREIGN KEY (`TRANSACTION_Date_Time` , `TRANSACTION_STORE_STORE_id`)
    REFERENCES `supermarket`.`TRANSACTION` (`Date_Time` , `STORE_STORE_id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

CREATE TABLE `supermarket`.`Customer_Phone#` (
  `Phone` VARCHAR(45) NOT NULL,
  `Customer_Card#` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`Phone`, `Customer_Card#`),
  INDEX `fk_Customer_Phone#_Customer1_idx` (`Customer_Card#` ASC),
  CONSTRAINT `fk_Customer_Phone#_Customer1`
    FOREIGN KEY (`Customer_Card#`)
    REFERENCES `supermarket`.`Customer` (`Card#`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

 CREATE VIEW `supermarket`.product_couples AS (SELECT P.PRODUCT_Barcode as product_A,T.PRODUCT_Barcode as product_B ,COUNT(T.PRODUCT_Barcode) as cnt FROM `PRODUCT_has_TRANSACTION`as T inner JOIN PRODUCT_has_TRANSACTION as P on T.PRODUCT_Barcode <> P.PRODUCT_Barcode and T.TRANSACTION_Date_Time = P.TRANSACTION_Date_Time and T.TRANSACTION_STORE_STORE_id = P.TRANSACTION_STORE_STORE_id GROUP BY P.PRODUCT_Barcode,T.PRODUCT_Barcode ORDER BY cnt desc limit 3);
 
 CREATE VIEW `supermarket`.tops as (SELECT * FROM PRODUCT, (SELECT T.`Customer_Card#`, T.STORE_STORE_id, P.PRODUCT_Barcode,COUNT(P.PRODUCT_Barcode) as cnt FROM `TRANSACTION`as T inner JOIN PRODUCT_has_TRANSACTION as P on T.Date_Time = P.TRANSACTION_Date_Time and T.STORE_STORE_id = P.TRANSACTION_STORE_STORE_id GROUP BY P.PRODUCT_Barcode, T.STORE_STORE_id ORDER BY cnt desc) as K where K.PRODUCT_Barcode = Barcode ORDER BY K.cnt desc, `Name`);

CREATE INDEX brand_name_idx ON supermarket.PRODUCT (Brand_name);

CREATE INDEX Payment_idx ON supermarket.TRANSACTION(Payment_Method);
