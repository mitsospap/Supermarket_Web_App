# database19-20
create a supermarket site(insert/delete/update products, transactions and clients) with php, using xampp and mysql database 

![image](https://user-images.githubusercontent.com/75052554/212148724-c9a1341b-8a32-4f66-98e4-af49ec104881.png)

Important Feautures:

1)Brandname can take 1/0 value 1 if it is product of the store or 0 if it isn't (tinyint)

2)Card of the costumer is unique, since we put a relation between transaction and stores, so we can save in which store is the transaction taken place.

3)Indexs are all the primary and foreigh keys of each table with two extras:

   a)to search faster and easier the percentage of brandnames by the store
      
      CREATE INDEX brand_name_idx ON supermarket.PRODUCT (Brand_name); 
   
   b)to search faster and easier the transactions by method of payment.
      
      CREATE INDEX Payment_idx ON supermarket.TRANSACTION(Payment_Method);
   
Tech Stack:

1) Mysql workbench for the relation diagram

2) Xampp and mysql database, server and phpmyadmin for the ui and the database

3) MySQL to create and fill the database 

4) PHP and HTML for the ui

How to install our site:

1)Install xamp and mysql-server 

2)Open ddl file, copy paste and load at phpmyadmin to create the database 

3)Open triggers file and load them at the database 

4)Open inserts file and filed the databaseκαι 

5)Copy paste the code to link xampp with our site
