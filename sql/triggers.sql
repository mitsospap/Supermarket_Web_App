CREATE TRIGGER `history` AFTER UPDATE ON `PRODUCT`
 FOR EACH ROW BEGIN  
   if (new.Price <> old.Price and new.Starting_Date > old.Starting_Date) then 
       INSERT INTO OLDER_PRICES (Start_Date, Price, End_Date, PRODUCT_Barcode, PRODUCT_Category_Category_id) 
       VALUES (old.Starting_Date, old.Price, new.Starting_Date, old.Barcode, old.Category_Category_id);
   END IF;
 END;
 
CREATE TRIGGER `cost` AFTER INSERT ON `PRODUCT_has_TRANSACTION`
 FOR EACH ROW BEGIN
  SET @pieces = new.Pieces;
  SET @price = (SELECT Price FROM PRODUCT WHERE PRODUCT.Barcode = new.PRODUCT_Barcode);
  SET @cost = (@price * @pieces);
  SET @pieces = @pieces + (SELECT `TRANSACTION`.`Total_Pieces` FROM `TRANSACTION` WHERE (`TRANSACTION`.Date_Time = new.TRANSACTION_Date_Time) and (`TRANSACTION`.STORE_STORE_id = new.TRANSACTION_STORE_STORE_id));
  SET @cost = @cost + (SELECT `TRANSACTION`.`Total_Amount` FROM `TRANSACTION` WHERE (`TRANSACTION`.Date_Time = new.TRANSACTION_Date_Time) and (`TRANSACTION`.STORE_STORE_id = new.TRANSACTION_STORE_STORE_id));
  UPDATE `TRANSACTION` SET `TRANSACTION`.Total_Amount = @cost, `TRANSACTION`.Total_Pieces = @pieces WHERE (`TRANSACTION`.Date_Time = new.TRANSACTION_Date_Time) and (`TRANSACTION`.STORE_STORE_id = new.TRANSACTION_STORE_STORE_id);
  END
  
  CREATE TRIGGER `cost_update` AFTER UPDATE ON `PRODUCT_has_TRANSACTION`
 FOR EACH ROW BEGIN 
  SET @pieces = (new.pieces - old.pieces);
  SET @price = (SELECT Price FROM PRODUCT WHERE PRODUCT.Barcode = new.PRODUCT_Barcode);
  SET @cost = (@price * @pieces);
   SET @pieces = @pieces + (SELECT `TRANSACTION`.`Total_Pieces` FROM `TRANSACTION` WHERE (`TRANSACTION`.Date_Time = new.TRANSACTION_Date_Time) and (`TRANSACTION`.STORE_STORE_id = new.TRANSACTION_STORE_STORE_id));
   SET @cost = @cost + (SELECT `TRANSACTION`.`Total_Amount` FROM `TRANSACTION` WHERE (`TRANSACTION`.Date_Time = new.TRANSACTION_Date_Time) and (`TRANSACTION`.STORE_STORE_id = new.TRANSACTION_STORE_STORE_id));
   UPDATE `TRANSACTION` SET `TRANSACTION`.Total_Amount = @cost, `TRANSACTION`.Total_Pieces = @pieces WHERE (`TRANSACTION`.Date_Time = new.TRANSACTION_Date_Time) and (`TRANSACTION`.STORE_STORE_id = new.TRANSACTION_STORE_STORE_id);
  END
  
  CREATE TRIGGER `cost_delete` AFTER DELETE ON `PRODUCT_has_TRANSACTION`
 FOR EACH ROW BEGIN
  SET @pieces = old.Pieces;
  SET @price = (SELECT Price FROM PRODUCT WHERE PRODUCT.Barcode = old.PRODUCT_Barcode);
  SET @cost = (@price * @pieces);
  SET @pieces = (SELECT `TRANSACTION`.`Total_Pieces` FROM `TRANSACTION` WHERE (`TRANSACTION`.Date_Time = old.TRANSACTION_Date_Time) and (`TRANSACTION`.STORE_STORE_id = old.TRANSACTION_STORE_STORE_id)) - @pieces;
  SET @cost = (SELECT `TRANSACTION`.`Total_Amount` FROM `TRANSACTION` WHERE (`TRANSACTION`.Date_Time = old.TRANSACTION_Date_Time) and (`TRANSACTION`.STORE_STORE_id = old.TRANSACTION_STORE_STORE_id)) - @cost;
  UPDATE `TRANSACTION` SET `TRANSACTION`.Total_Amount = @cost, `TRANSACTION`.Total_Pieces = @pieces WHERE (`TRANSACTION`.Date_Time = old.TRANSACTION_Date_Time) and (`TRANSACTION`.STORE_STORE_id = old.TRANSACTION_STORE_STORE_id);
  END
  
