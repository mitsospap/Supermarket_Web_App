# database19-20
create a supermarket site(insert/delete/update products, transactions and clients) with php, using xampp and mysql database 

![image](https://user-images.githubusercontent.com/75052554/212148724-c9a1341b-8a32-4f66-98e4-af49ec104881.png)

Ερωτημα 1

a)ολοι οι περιορσμοι που εχουν οριστει φαινονται στο ddl αρχειο που ειναι base.sql
αξιζει να σημειωθει το:
1)το brandname μπορει να παρει την τιμη 1/0 αν ειναι προιον του κατστηματος =1 αλλιως =0 γιαυτο και ειναι δηλωμενο και ως tinyint
2)το card του πελατη ειναι απλα ενας μοναδικος αριθμος καθως βαλαμε και μια σχεση μεταξυ transaction κ stores για να μπορουμε να καταγραφουμε σε ποιο καταστημα γινεται το transaction πολλα προς ενα

Η αναφορικη ακεραιοτητα φαινεται αναλυτικα στο σχεσιακο διαγραμμα του mysql workbench και στο αρχειο relation.pdf.

Triggers για το older prices/history των προιοντων και για την ενημερωση μετα απο καθε insert update delete ενος product_has_transactiion… φαινονται στο triggers.sql αρχειο

b)τα ευρετηρια που εχουν χρησιμοποιηθει ειναι ολα τα primary και foreigh keys του καθε table που φαινονται παλι στο ddl αρχειο base.sql
αξιζει να σημειωθουν δυο εξτρα indexes:\|
CREATE INDEX brand_name_idx ON supermarket.PRODUCT (Brand_name);
για την πιο γρηγορη και πιο ευκολη ευρεση του ποσοστου με τα tags του καταστηματος ανα κατηγορια

CREATE INDEX Payment_idx ON supermarket.TRANSACTION(Payment_Method);
για την πιο γρηγορη και πιο ευκολη ευρεση στο search των transactions με τον μεθοδο πληρωμης που επιλεγουμε

c)οι τεχνολογιες που χρησιμοποιησαμε για την αναπτυξη της εφαρμογης μας ειναι:
1) Mysql workbench για την αναπτυξη του σχεσιακου μας διαγραμματος
2) Xampp με mysql database, server και phpmyadmin για την υλοποιηση του ui και της database
3) Γλωσσα SQL για την σχεδιαση και το γεμισμα της βασης 
4) PHP κ HTML για την σχεδιαση του ui

d)
1)Εγκατασταση του xamp και του mysql-server 
2)Ανοιγμα ddl αρχειου copy paste και φορτωμα στο phpmyadmin για την δημιουργια της βασης 
3)ανοιγμα αρχειου triggers και φορτωμα στη βαση 
4)Ανοιγμα inserts και γεμισμα της βασης 
5)copy paste τα αρχεια του κωδικα για να γινεται link απο το xampp στην ιστοσελιδα μας

question 4
//search
SELECT * FROM `TRANSACTION` as T INNER JOIN (SELECT `TRANSACTION_Date_Time`, TRANSACTION_STORE_STORE_id, COUNT(DISTINCT PRODUCT_Barcode) as cnt FROM PRODUCT_has_TRANSACTION GROUP BY `TRANSACTION_Date_Time` ) as P 
   ON T.STORE_STORE_id = P.TRANSACTION_STORE_STORE_id AND T.Date_Time = P.TRANSACTION_Date_Time 
 WHERE T.STORE_STORE_id = $store and P.cnt >= $quantity and (T.Date_Time between '$s_date' and '$e_date') and (T.Payment_Method like concat('%', '$payment', '%')) ORDER BY T.Date_Time




//8 popular couple of products
SELECT P.PRODUCT_Barcode,T.PRODUCT_Barcode,COUNT(T.PRODUCT_Barcode) as cnt FROM `PRODUCT_has_TRANSACTION`as T inner JOIN PRODUCT_has_TRANSACTION as P on T.PRODUCT_Barcode <> P.PRODUCT_Barcode and T.TRANSACTION_Date_Time = P.TRANSACTION_Date_Time and T.TRANSACTION_STORE_STORE_id = P.TRANSACTION_STORE_STORE_id GROUP BY P.PRODUCT_Barcode,T.PRODUCT_Barcode ORDER BY cnt desc limit 3





//question 10 popular products name count

SELECT Name, SUM(cnt) as t_sum FROM tops WHERE `Customer_Card#` = '$card' GROUP BY Barcode ORDER BY t_sum desc, Name   limit 10;


SELECT `Name`, K.cnt FROM PRODUCT, (SELECT T.`Customer_Card#`,P.PRODUCT_Barcode,COUNT(P.PRODUCT_Barcode) as cnt FROM `TRANSACTION`as T inner JOIN PRODUCT_has_TRANSACTION as P on T.Date_Time = P.TRANSACTION_Date_Time and T.STORE_STORE_id = P.TRANSACTION_STORE_STORE_id and T.`Customer_Card#` = '$card' GROUP BY P.PRODUCT_Barcode ORDER BY cnt desc) as K where K.PRODUCT_Barcode = Barcode ORDER BY K.cnt desc, `Name` limit 10 




//question 7 in how many stores and which someone has gone
SELECT * FROM `TRANSACTION`, (SELECT COUNT(*) FROM (SELECT DISTINCT (STORE_STORE_id) FROM `TRANSACTION`) as cnt) as cnt1 WHERE `TRANSACTION`.`Customer_Card#` = '$card' order by STORE_STORE_id, Date_Time



//averages

SELECT * FROM 
   (SELECT AVG(Total_Amount) as W_avg FROM `TRANSACTION` WHERE `Customer_Card#` = '$card' and `Date_Time` BETWEEN '$week_date' and '$e_date') as W,
   (SELECT AVG(Total_Amount) as M_avg FROM `TRANSACTION` WHERE `Customer_Card#` = '$card' and `Date_Time` BETWEEN '$month_date' and '$e_date') as M
   
//question 10 percentage per category
SELECT total.`Category_Category_id`, total_cnt, tag_cnt 
FROM (SELECT COUNT(`Brand_name`) as tag_cnt, `Category_Category_id` FROM `tops` WHERE `Brand_name` = 1 GROUP BY `Category_Category_id` ORDER BY `Category_Category_id`) as tag 
      RIGHT OUTER JOIN (SELECT COUNT(`Brand_name`) as total_cnt, `Category_Category_id` FROM `tops` GROUP BY `Category_Category_id` ORDER BY `Category_Category_id`) as total 
      ON tag.`Category_Category_id` = total.`Category_Category_id`
