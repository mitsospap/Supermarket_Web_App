//search
SELECT * FROM `TRANSACTION` as T INNER JOIN (SELECT `TRANSACTION_Date_Time`, TRANSACTION_STORE_STORE_id, COUNT(DISTINCT PRODUCT_Barcode) as cnt FROM PRODUCT_has_TRANSACTION GROUP BY `TRANSACTION_Date_Time` ) as P 
   ON T.STORE_STORE_id = P.TRANSACTION_STORE_STORE_id AND T.Date_Time = P.TRANSACTION_Date_Time 
 WHERE T.STORE_STORE_id = $store and P.cnt >= $quantity and (T.Date_Time between '$s_date' and '$e_date') and (T.Payment_Method like concat('%', '$payment', '%')) ORDER BY T.Date_Time




//8 erwthma dhmofilh zeygh
SELECT P.PRODUCT_Barcode,T.PRODUCT_Barcode,COUNT(T.PRODUCT_Barcode) as cnt FROM `PRODUCT_has_TRANSACTION`as T inner JOIN PRODUCT_has_TRANSACTION as P on T.PRODUCT_Barcode <> P.PRODUCT_Barcode and T.TRANSACTION_Date_Time = P.TRANSACTION_Date_Time and T.TRANSACTION_STORE_STORE_id = P.TRANSACTION_STORE_STORE_id GROUP BY P.PRODUCT_Barcode,T.PRODUCT_Barcode ORDER BY cnt desc limit 3





//7 erwthma 10 dhmfilh proionta onoma count

SELECT Name, SUM(cnt) as t_sum FROM tops WHERE `Customer_Card#` = '$card' GROUP BY Barcode ORDER BY t_sum desc, Name   limit 10;


SELECT `Name`, K.cnt FROM PRODUCT, (SELECT T.`Customer_Card#`,P.PRODUCT_Barcode,COUNT(P.PRODUCT_Barcode) as cnt FROM `TRANSACTION`as T inner JOIN PRODUCT_has_TRANSACTION as P on T.Date_Time = P.TRANSACTION_Date_Time and T.STORE_STORE_id = P.TRANSACTION_STORE_STORE_id and T.`Customer_Card#` = '$card' GROUP BY P.PRODUCT_Barcode ORDER BY cnt desc) as K where K.PRODUCT_Barcode = Barcode ORDER BY K.cnt desc, `Name` limit 10 




//erwthma 7 posa kai poia katasthmata exei paei 
SELECT * FROM `TRANSACTION`, (SELECT COUNT(*) FROM (SELECT DISTINCT (STORE_STORE_id) FROM `TRANSACTION`) as cnt) as cnt1 WHERE `TRANSACTION`.`Customer_Card#` = '$card' order by STORE_STORE_id, Date_Time



//averages

SELECT * FROM 
   (SELECT AVG(Total_Amount) as W_avg FROM `TRANSACTION` WHERE `Customer_Card#` = '$card' and `Date_Time` BETWEEN '$week_date' and '$e_date') as W,
   (SELECT AVG(Total_Amount) as M_avg FROM `TRANSACTION` WHERE `Customer_Card#` = '$card' and `Date_Time` BETWEEN '$month_date' and '$e_date') as M
   
   ερωτηση 10 ποσοσστο ανα κατηγορια
SELECT total.`Category_Category_id`, total_cnt, tag_cnt 
FROM (SELECT COUNT(`Brand_name`) as tag_cnt, `Category_Category_id` FROM `tops` WHERE `Brand_name` = 1 GROUP BY `Category_Category_id` ORDER BY `Category_Category_id`) as tag 
      RIGHT OUTER JOIN (SELECT COUNT(`Brand_name`) as total_cnt, `Category_Category_id` FROM `tops` GROUP BY `Category_Category_id` ORDER BY `Category_Category_id`) as total 
      ON tag.`Category_Category_id` = total.`Category_Category_id`
