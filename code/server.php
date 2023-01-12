<?php

session_start();

$username = "";
$email = "";

$errors = array();
//connect to db

$db1 = mysqli_connect("localhost", "root", "", "supermarket") or die("could not connect to database");

//initializing variables
if(isset($_POST['registration'])){


    //register users

    $username = mysqli_real_escape_string($db1, $_POST['username']);
    $email = mysqli_real_escape_string($db1, $_POST['email']);
    $password_1 = mysqli_real_escape_string($db1, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db1, $_POST['password_2']);

    //form validation

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "Passwords do not match");
    }

    //check dp for existing user with same username 

    $user_check_query = "SELECT * FROM user WHERE username = '$username' or email = '$email' LIMIT 1";

    $results = mysqli_query($db1, $user_check_query);
    $user = mysqli_fetch_assoc($results);
    mysqli_free_result($results);

    if ($user) {

        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }
        if ($user['email'] === $email) {
            array_push($errors, "This email already exists");
        }
    }

    //register the user if no error

    if (count($errors) == 0) {
        $password = $password_1;
        $query = "INSERT INTO user (username, email, password) VALUES ('$username', '$email', '$password')";
        $result = mysqli_query($db1, $query);
        $_SESSION = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";

        header('location: index1.php');
    }
}

//login user

if(isset($_POST['login_user'])){

    $username = mysqli_real_escape_string($db1, $_POST['username']);
    $password = mysqli_real_escape_string($db1, $_POST['password_1']);

    if(empty($username)){
        array_push($errors, "Username is required");
    }
    if(empty($password)){
        array_push($errors, "Password is required");
    }
    if(count($errors) == 0){
        $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password' ";
        $result = mysqli_query($db1, $query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "Logged in succesfully ";
        mysqli_free_result($result);
        header('location: index1.php');
    }
}
if(isset($_POST['insert_store'])){
    //insert store

    $id = mysqli_real_escape_string($db1, $_POST['store_id']);
    $size = mysqli_real_escape_string($db1, $_POST['size']);
    $operating = mysqli_real_escape_string($db1, $_POST['operating']);
    $city = mysqli_real_escape_string($db1, $_POST['city']);
    $post = mysqli_real_escape_string($db1, $_POST['pc']);
    $street = mysqli_real_escape_string($db1, $_POST['street']);
    $number = mysqli_real_escape_string($db1, $_POST['number']);
    $phone1 = mysqli_real_escape_string($db1, $_POST['phone1']);
    $phone2 = mysqli_real_escape_string($db1, $_POST['phone2']);

    //check dp for existing store with same store_id

    $user_check_query1 = "SELECT STORE_id FROM STORE WHERE STORE_id = '$id'";

    $results = mysqli_query($db1, $user_check_query1);
    $row = mysqli_fetch_assoc($results);
    mysqli_free_result($results);

    if ($row['STORE_id'] === $id) {
        array_push($errors, "STORE_id already exists");
    }

    //register the store if no error

    if (count($errors) == 0) {
        $query1 = "INSERT INTO STORE (STORE_id, Size, Operating_Hours, City, Postal_Code, Street, `Number`) VALUES ('$id', '$size', '$operating', '$city', '$post', '$street', '$number')";
        mysqli_query($db1, $query1);
        $user_check_query = "SELECT Category_id FROM Category ";
        $result = mysqli_query($db1, $user_check_query);
         while($row = mysqli_fetch_assoc($result)){ 
            $c_id = $row['Category_id'];
            $query = "INSERT INTO STORE_has_Category (STORE_STORE_id, Category_Category_id) VALUES ('$id', '$c_id')";
            mysqli_query($db1, $query);
        }  
        mysqli_free_result($result);
        if ($phone1 != NULL) mysqli_query($db1,"INSERT INTO `Store_Phone#` (Phone, STORE_STORE_id) VALUES ('$phone1', '$id')");
        if ($phone2 != NULL) mysqli_query($db1,"INSERT INTO `Store_Phone#` (Phone, STORE_STORE_id) VALUES ('$phone2', '$id')");
        header('location: stores.php');
    }
}
if(isset($_POST['update_store'])){
    //update store

    $id = mysqli_real_escape_string($db1, $_POST['store_id']);
    $size = mysqli_real_escape_string($db1, $_POST['size']);
    $operating = mysqli_real_escape_string($db1, $_POST['operating']);
    $city = mysqli_real_escape_string($db1, $_POST['city']);
    $post = mysqli_real_escape_string($db1, $_POST['pc']);
    $street = mysqli_real_escape_string($db1, $_POST['street']);
    $number = mysqli_real_escape_string($db1, $_POST['number']);
    $phone1 = mysqli_real_escape_string($db1, $_POST['phone1']);
    $phone2 = mysqli_real_escape_string($db1, $_POST['phone2']);

    //check dp for existing store with same store_id

    $user_check_query1 = "SELECT count(*) as check1 FROM STORE WHERE STORE_id = '$id'";

    $results = mysqli_query($db1, $user_check_query1);
    $row = mysqli_fetch_assoc($results);
    mysqli_free_result($results);

    if ($row['check1'] == 0) {
        array_push($errors, "STORE_id does not exists");
    }

    //update the store if no error

    if (count($errors) == 0) {
        $query1 = "UPDATE STORE SET STORE_id = '$id', Size = '$size', Operating_Hours = '$operating', City = '$city', Postal_Code = '$post', Street = '$street', `Number` = '$number' WHERE STORE_id = '$id'";
        mysqli_query($db1, $query1);
        if ($phone1 != NULL) mysqli_query($db1,"UPDATE `Store_Phone#` SET Phone = '$phone1' WHERE STORE_STORE_id = '$id'");
        if ($phone2 != NULL) mysqli_query($db1,"UPDATE `Store_Phone#` SET Phone = '$phone2' WHERE STORE_STORE_id = '$id'");
        header('location: stores.php');
    }
}
if(isset($_POST['delete_store'])){
    //delete store
    $id = mysqli_real_escape_string($db1, $_POST['store_id']);

    //check dp for existing store with same store_id
    $user_check_query1 = "SELECT count(*) as total FROM STORE WHERE STORE_id = '$id'";
    $results = mysqli_query($db1, $user_check_query1);
    $row = mysqli_fetch_assoc($results); 
    if ($row['total'] == 0) {
        array_push($errors, "STORE_id does not exists");
        header('location: stores.php');
    }
    mysqli_free_result($results);
    //delete the store if no error
    if (count($errors) == 0) {
        $query1 = "DELETE FROM STORE WHERE STORE_id = '$id'";
        mysqli_query($db1, $query1);
        header('location: stores.php');
    }
}
if(isset($_POST['insert_product'])){
    //insert product

    $barcode = mysqli_real_escape_string($db1, $_POST['barcode']);
    $name = mysqli_real_escape_string($db1, $_POST['name']);
    $tag = mysqli_real_escape_string($db1, $_POST['brand']);
    $price = mysqli_real_escape_string($db1, $_POST['price']);
    $c_id = mysqli_real_escape_string($db1, $_POST['c_id']);
    $s_date = mysqli_real_escape_string($db1, $_POST['s_date']);
    $alley = mysqli_real_escape_string($db1, $_POST['alley']);
    $shelf = mysqli_real_escape_string($db1, $_POST['shelf']);
    $id = mysqli_real_escape_string($db1, $_POST['id']);
    //check dp for existing product with same barcode

    $user_check_query1 = "SELECT Barcode FROM PRODUCT WHERE Barcode = '$id'";

    $results = mysqli_query($db1, $user_check_query1);
    $row = mysqli_fetch_assoc($results);
    mysqli_free_result($results);

    if ($row['Barcode'] === $id) {
        array_push($errors, "Barcode already exists");
    }
    //register the product if no error

    if (count($errors) == 0) {
        $query1 = "INSERT INTO PRODUCT VALUES ('$barcode', '$name', '$tag', '$price', '$c_id', '$s_date')";
        mysqli_query($db1, $query1);
        $user_check_query = "SELECT STORE_id FROM STORE ";
        $result = mysqli_query($db1, $user_check_query);
        while($row = mysqli_fetch_assoc($result)){ 
            $s_id = $row['STORE_id'];
            $query = "INSERT INTO STORE_has_PRODUCT VALUES ('$s_id', '$barcode', '$c_id', '$alley', '$shelf')";
            mysqli_query($db1, $query);
        }  
        mysqli_free_result($result);
        header('location: product.php');
    }
}
if(isset($_POST['update_product'])){
    //update product 

    $barcode = mysqli_real_escape_string($db1, $_POST['barcode']);
    $name = mysqli_real_escape_string($db1, $_POST['name']);
    $tag = mysqli_real_escape_string($db1, $_POST['brand']);
    $price = mysqli_real_escape_string($db1, $_POST['price']);
    $c_id = mysqli_real_escape_string($db1, $_POST['c_id']);
    $s_date = mysqli_real_escape_string($db1, $_POST['s_date']);
    $alley = mysqli_real_escape_string($db1, $_POST['alley']);
    $shelf = mysqli_real_escape_string($db1, $_POST['shelf']);
    $id = mysqli_real_escape_string($db1, $_POST['id']);
    //check dp for existing product with same barcode

    $user_check_query1 = "SELECT Price, Starting_Date, count(*) as check1 FROM PRODUCT WHERE Barcode = '$barcode'";

    $results = mysqli_query($db1, $user_check_query1);
    $row = mysqli_fetch_assoc($results);
    mysqli_free_result($results);

    if ($row['check1'] == 0) {
        array_push($errors, "Barcode does not exists");
    }
    //update the product if no error

    if (count($errors) == 0) {
        if($row['Price']!== $Price && $row['Starting_Date'] < $s_date){
            $query1 = "UPDATE PRODUCT SET Name = '$name', Brand_name = '$tag', Price = '$price', Category_Category_id = '$c_id', Starting_Date = '$s_date' WHERE Barcode = '$barcode'";
        }else $query1 = "UPDATE PRODUCT SET  Name = '$name', Brand_name = '$tag', Category_Category_id = '$c_id' WHERE Barcode = '$barcode'";
        mysqli_query($db1, $query1);
        if ($id != NULL){
            $query = "UPDATE `STORE_has_PRODUCT` SET alley = '$alley', shelf = '$shelf' WHERE STORE_STORE_id = '$id' and PRODUCT_Barcode = '$barcode'";
        }else $query = "UPDATE `STORE_has_PRODUCT` SET alley = '$alley', shelf = '$shelf' WHERE PRODUCT_Barcode = '$barcode'";
        mysqli_query($db1, $query);
        
        header('location: product.php');
    }
}
if(isset($_POST['delete_product'])){
    //delete product
    $barcode = mysqli_real_escape_string($db1, $_POST['barcode']);

    //check dp for existing product with same barcode
    $user_check_query1 = "SELECT count(*) as total FROM PRODUCT WHERE Barcode = '$barcode'";
    $results = mysqli_query($db1, $user_check_query1);
    $row = mysqli_fetch_assoc($results); 
    if ($row['total'] == 0) {
        array_push($errors, "product does not exists");
        header('location: index1.php');
    }
    mysqli_free_result($results);
    //delete the product if no error
    if (count($errors) == 0) {
        $query1 = "DELETE FROM PRODUCT WHERE Barcode = '$barcode'";
        mysqli_query($db1, $query1);
        header('location: product.php');
    }
}
if(isset($_POST['insert_customer'])){
    //insert customer

    $card = mysqli_real_escape_string($db1, $_POST['card']);
    $name = mysqli_real_escape_string($db1, $_POST['name']);
    $dob = mysqli_real_escape_string($db1, $_POST['dob']);
    $family = mysqli_real_escape_string($db1, $_POST['family']);
    $pet = mysqli_real_escape_string($db1, $_POST['pet']);
    $city = mysqli_real_escape_string($db1, $_POST['city']);
    $pc = mysqli_real_escape_string($db1, $_POST['pc']);
    $street = mysqli_real_escape_string($db1, $_POST['street']);
    $number = mysqli_real_escape_string($db1, $_POST['number']);
    $phone1 = mysqli_real_escape_string($db1, $_POST['phone1']);
    $phone2 = mysqli_real_escape_string($db1, $_POST['phone2']);
    //check dp for existing customer with same card#

    $user_check_query1 = "SELECT `Card#` FROM Customer WHERE `Card#` = '$card'";

    $results = mysqli_query($db1, $user_check_query1);
    $row = mysqli_fetch_assoc($results);
    mysqli_free_result($results);

    if ($row['Card#'] === $card) {
        array_push($errors, "customer already exists");
    }
    //register the customer if no error

    if (count($errors) == 0) {
        $query1 = "INSERT INTO Customer (`Card#`, `Name`, `Date_of_Birth`, `Family_Members`, `Pet`, `City`, `Postal_Code`, `Street`, `Number`) VALUES ('$card', '$name', '$dob', '$family', '$pet', '$city', '$pc', '$street', '$number')";
        mysqli_query($db1, $query1);
        if ($phone1 != NULL) mysqli_query($db1,"INSERT INTO `Customer_Phone#` (Phone, `Customer_Card#`) VALUES ('$phone1', '$card')");
        if ($phone2 != NULL) mysqli_query($db1,"INSERT INTO `Customer_Phone#` (Phone, `Customer_Card#`) VALUES ('$phone2', '$card')");
        header('location: customer.php');
    }
}
if(isset($_POST['update_customer'])){
    //update customer 

    $card = mysqli_real_escape_string($db1, $_POST['card']);
    $name = mysqli_real_escape_string($db1, $_POST['name']);
    $dob = mysqli_real_escape_string($db1, $_POST['dob']);
    $family = mysqli_real_escape_string($db1, $_POST['family']);
    $pet = mysqli_real_escape_string($db1, $_POST['pet']);
    $city = mysqli_real_escape_string($db1, $_POST['city']);
    $pc = mysqli_real_escape_string($db1, $_POST['pc']);
    $street = mysqli_real_escape_string($db1, $_POST['street']);
    $number = mysqli_real_escape_string($db1, $_POST['number']);
    $phone1 = mysqli_real_escape_string($db1, $_POST['phone1']);
    $phone2 = mysqli_real_escape_string($db1, $_POST['phone2']);
    //check dp for existing customer with same card#

    $user_check_query1 = "SELECT count(*) as check1 FROM Customer WHERE `Card#` = '$card'";

    $results = mysqli_query($db1, $user_check_query1);
    $row = mysqli_fetch_assoc($results);
    mysqli_free_result($results);

    if ($row['check1'] == 0) {
        array_push($errors, "Card does not exists");
        header('location: index1.php');
    }
    //update the customer if no error

    if (count($errors) == 0) {
        $query1 = "UPDATE Customer SET `Name` = '$name', `Date_of_Birth` = '$dob', `Family_Members` = '$family', Pet = '$pet', City = '$city', Postal_Code = '$pc', Street = '$street', `Number` = '$number' WHERE `Card#` = '$card'";            
        mysqli_query($db1, $query1);
        if ($phone1 != NULL) mysqli_query($db1,"INSERT INTO `Customer_Phone#` (Phone, `Customer_Card#`) VALUES ('$phone1', '$card')");
        if ($phone2 != NULL) mysqli_query($db1,"INSERT INTO `Customer_Phone#` (Phone, `Customer_Card#`) VALUES ('$phone2', '$card')");    
        header('location: customer.php');
    }
}
if(isset($_POST['delete_customer'])){
    //delete customer
    $card = mysqli_real_escape_string($db1, $_POST['card']);

    //check dp for existing customer with same card#
    $user_check_query1 = "SELECT count(*) as total FROM Customer WHERE `Card#` = '$card'";
    $results = mysqli_query($db1, $user_check_query1);
    $row = mysqli_fetch_assoc($results); 
    if ($row['total'] == 0) {
        array_push($errors, "customer does not exists");
        header('location: index1.php');
    }
    mysqli_free_result($results);
    //delete the customer if no error
    if (count($errors) == 0) {
        $query1 = "DELETE FROM Customer WHERE `Card#` = '$card'";
        mysqli_query($db1, $query1);
        header('location: customer.php');
    }
}
if(isset($_POST['insert_transaction'])){
    //insert transaction

    $date = mysqli_real_escape_string($db1, $_POST['date']);
    $payment = mysqli_real_escape_string($db1, $_POST['payment']);
    $card = mysqli_real_escape_string($db1, $_POST['card']);
    $s_id = mysqli_real_escape_string($db1, $_POST['s_id']);
    //check dp for existing transaction with same date time

    $user_check_query1 = "SELECT `Date_Time` FROM `TRANSACTION` WHERE `Date_Time` = '$date', `Customer_Card#` = '$card', STORE_STORE_id = '$s_id'";

    $results = mysqli_query($db1, $user_check_query1);
    $row = mysqli_fetch_assoc($results);
    mysqli_free_result($results);

    if ($row['Date_Time'] === $date) {
        array_push($errors, "transaction already exists");
    }
    //register the transaction if no error

    if (count($errors) == 0) {
        $query1 = "INSERT INTO `TRANSACTION` (`Date_Time`, `Payment_Method`, `Customer_Card#`, `STORE_STORE_id`) VALUES ('$date', '$payment', '$card', '$s_id')";
        mysqli_query($db1, $query1);
        $_SESSION['Date_Time'] = $date;
        $_SESSION['STORE_STORE_id'] = $s_id;
        header("location: adding.php");
    }
}
if(isset($_POST['add_trans'])){
    //insert transaction

    $barcode = mysqli_real_escape_string($db1, $_POST['barcode']);
    $category = mysqli_real_escape_string($db1, $_POST['category']);
    $pieces = mysqli_real_escape_string($db1, $_POST['pieces']);
    if($pieces == NULL) header('location: adding.php');
    //check dp for existing transaction with same date time

    $user_check_query1 = "SELECT count(PRODUCT_Barcode) as check1 FROM `PRODUCT_has_TRANSACTION` 
                            WHERE `TRANSACTION_Date_Time` = '$date' and PRODUCT_Barcode = $barcode and TRANSACTION_STORE_STORE_id = $s_id";

    $results = mysqli_query($db1, $user_check_query1);
    $row = mysqli_fetch_assoc($results);
    mysqli_free_result($results);

    if ($row['check1'] != 0) {
        array_push($errors, "transaction already exists");
        header('location: index1.php');
    }
    //register the transaction if no error

    if (count($errors) == 0) {
        $date = $_SESSION['Date_Time'];
        $s_id = $_SESSION['STORE_STORE_id'];
        $query1 = "INSERT INTO `PRODUCT_has_TRANSACTION` VALUES ('$barcode', '$category', '$pieces', '$date', '$s_id')";
        mysqli_query($db1, $query1);
        header('location: adding.php');
    }
}
if(isset($_POST['update_transaction'])){
    //update transaction 

    $date = mysqli_real_escape_string($db1, $_POST['date']);
    $payment = mysqli_real_escape_string($db1, $_POST['payment']);
    $card = mysqli_real_escape_string($db1, $_POST['card']);
    $s_id = mysqli_real_escape_string($db1, $_POST['s_id']);
    //check dp for existing transaction with same date time

    $user_check_query1 = "SELECT count(*) as check1 FROM `TRANSACTION` WHERE `Date_Time` = '$date' and `Customer_Card#` = '$card' and STORE_STORE_id = '$s_id'";

    $results = mysqli_query($db1, $user_check_query1);
    $row = mysqli_fetch_assoc($results);
    mysqli_free_result($results);

    if ($row['check1'] == 0) {
        array_push($errors, "Transaction does not exists");
        header('location: index1.php');
    }
    //update the transaction if no error

    if (count($errors) == 0) {
        $_SESSION['Date_Time'] = $date;
        $_SESSION['STORE_STORE_id'] = $s_id;
        $query1 = "UPDATE `TRANSACTION` SET `Payment_Method` = '$payment' WHERE `Date_Time` = '$date' and `Customer_Card#` = '$card' and STORE_STORE_id = '$s_id'";            
        mysqli_query($db1, $query1);;    
        header('location: adding.php');
    }
}
if(isset($_POST['update_trans'])){
    //insert transaction

    $barcode = mysqli_real_escape_string($db1, $_POST['barcode']);
    $category = mysqli_real_escape_string($db1, $_POST['category']);
    $pieces = mysqli_real_escape_string($db1, $_POST['pieces']);
    if($pieces == NULL) header('location: adding.php');
    $date = $_SESSION['Date_Time'];
    $s_id = $_SESSION['STORE_STORE_id'];
    //check dp for existing transaction with same date time

    $user_check_query1 = "SELECT count(PRODUCT_Barcode) as check1 FROM `PRODUCT_has_TRANSACTION` 
                            WHERE `TRANSACTION_Date_Time` = '$date' and PRODUCT_Barcode = $barcode and TRANSACTION_STORE_STORE_id = $s_id";

    $results = mysqli_query($db1, $user_check_query1);
    $row = mysqli_fetch_assoc($results);
    mysqli_free_result($results);

    if ($row['check1'] == 0) {
        array_push($errors, "transaction doesn't exists");
        header('location: index1.php');
    }
    //register the transaction if no error

    if (count($errors) == 0) {
        $query1 = "UPDATE `PRODUCT_has_TRANSACTION` SET `Pieces` = '$pieces' WHERE `TRANSACTION_Date_Time` = '$date' and PRODUCT_Barcode = $barcode and TRANSACTION_STORE_STORE_id = $s_id";            
        mysqli_query($db1, $query1);
        header('location: adding.php');
    }
}
if(isset($_POST['delete_transaction'])){
    //delete transaction
    $date = mysqli_real_escape_string($db1, $_POST['date']);
    $card = mysqli_real_escape_string($db1, $_POST['card']);
    $s_id = mysqli_real_escape_string($db1, $_POST['s_id']);

    //check dp for existing transaction with same date time
    $user_check_query1 = "SELECT count(*) as total FROM `TRANSACTION` WHERE `Date_Time` = '$date' and `Customer_Card#` = '$card' and STORE_STORE_id = '$s_id'";
    $results = mysqli_query($db1, $user_check_query1);
    $row = mysqli_fetch_assoc($results); 
    if ($row['total'] == 0) {
        array_push($errors, "transaction does not exists");
        header('location: index1.php');
    }
    mysqli_free_result($results);
    //delete the transaction if no error
    if (count($errors) == 0) {
        $query1 = "DELETE FROM `TRANSACTION` WHERE `Date_Time` = '$date' and `Customer_Card#` = '$card' and STORE_STORE_id = '$s_id'";
        mysqli_query($db1, $query1);
        header('location: transaction.php');
    }
}
if(isset($_POST['delete_trans'])){
    //insert transaction

    $barcode = mysqli_real_escape_string($db1, $_POST['barcode']);
    $category = mysqli_real_escape_string($db1, $_POST['category']);
    $date = $_SESSION['Date_Time'];
    $s_id = $_SESSION['STORE_STORE_id'];
    //check dp for existing transaction with same date time

    $user_check_query1 = "SELECT count(PRODUCT_Barcode) as check1 FROM `PRODUCT_has_TRANSACTION` 
                            WHERE `TRANSACTION_Date_Time` = '$date' and PRODUCT_Barcode = $barcode and TRANSACTION_STORE_STORE_id = $s_id";

    $results = mysqli_query($db1, $user_check_query1);
    $row = mysqli_fetch_assoc($results);
    mysqli_free_result($results);

    if ($row['check1'] == 0) {
        array_push($errors, "transaction doesn't exists");
        header('location: index1.php');
    }
    //register the transaction if no error

    if (count($errors) == 0) {
        $query1 = "DELETE FROM `PRODUCT_has_TRANSACTION` WHERE `TRANSACTION_Date_Time` = '$date' and PRODUCT_Barcode = $barcode and TRANSACTION_STORE_STORE_id = $s_id";            
        mysqli_query($db1, $query1);
        header('location: adding.php');
    }
}
if(isset($_POST['search_trans'])){
    $store = mysqli_real_escape_string($db1, $_POST['store']);
    if(!isset($_SESSION['store']) && $store != NULL) $_SESSION['store'] = $store;
    else if ($store != NULL) $_SESSION['store'] = $store;
    $s_date = mysqli_real_escape_string($db1, $_POST['s_date']);
    if($s_date != NULL) $_SESSION['s_date'] = $s_date;
    $e_date = mysqli_real_escape_string($db1, $_POST['e_date']);
    if($e_date != NULL) $_SESSION['e_date'] = $e_date;
    $payment = mysqli_real_escape_string($db1, $_POST['payment']);
    if($payment != NULL) $_SESSION['payment'] = $payment;
    $quantity = mysqli_real_escape_string($db1, $_POST['quantity']);
    if ($quantity != NULL) $_SESSION['quantity'] = $quantity;
    header("location: transaction.php");
}
if(isset($_POST['search_prices'])){
    $barcode = mysqli_real_escape_string($db1, $_POST['barcode']);
    $_SESSION['barcode'] = $barcode;
    header("location: product.php");
}
if(isset($_POST['search_customer'])){
    $card = mysqli_real_escape_string($db1, $_POST['card']);
    $_SESSION['card'] = $card;
    header("location: customer.php");
}
if(isset($_POST['search_store'])){
    $store = mysqli_real_escape_string($db1, $_POST['store']);
    $_SESSION['store'] = $store;
    header("location: stores.php");
}
?>