<?php
include('server.php');

if (isset($_SESSION['Date_Time'])){
    
    unset($_SESSION['Date_Time']);
    unset($_SESSION['STORE_STORE_id']);
}
if (!isset($_SESSION['username'])) {

    $_SESSION['msg'] = "you must log in first to view this page";
    header("location: login.php");
}
if (isset($_GET['Home'])) {

    unset($_SESSION['store']);
    unset($_SESSION['s_date']);
    unset($_SESSION['e_date']);
    unset($_SESSION['quantity']);
    unset($_SESSION['payment']);

    header("location: index1.php");
}
if(isset($_GET['reset'])){
    unset($_SESSION['store']);
    unset($_SESSION['quantity']);
    unset($_SESSION['payment']);
}

if (isset($_GET['logout'])) {

    unset($_SESSION['store']);
    unset($_SESSION['s_date']);
    unset($_SESSION['e_date']);
    unset($_SESSION['quantity']);
    unset($_SESSION['payment']);
    unset($_SESSION['username']);
    session_destroy();
    header("location: login.php");
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transaction</title>
</head>
<body>
    <div>
        <h1>Transactions!</h1>
    </div>
    <div>
        <form action="transaction.php" method="POST">
            <div>
                <label for="store">Store Number</label>
                <input type="number" min="0" name="store"> 

                <label for="s_date"> Από</label>
                <input type="date" name="s_date">

                <label for="e_date"> Εώς</label>
                <input type="date" name="e_date">

                <label for="payment"> Payment Method</label>
                <input type="text" name="payment">

                <label for="products"> Minimum Number of products</label>
                <input type="number" min="0" name="quantity">

                <button type="submit" name="search_trans"> SEARCH</button> 
                <a href="transaction.php?reset">RESET</a>
            </div>
        </form>
    </div>

    <p>
    <?php
        if (!isset($_SESSION['quantity'])){
            $_SESSION['quantity'] = 0;
            $_SESSION['s_date'] = "2018-01-01";
            $_SESSION['e_date'] = date("Y-m-d");
            $_SESSION['payment'] = "%";
        }
        $s_date = $_SESSION['s_date'];
        $e_date = $_SESSION['e_date'];
        $quantity = $_SESSION['quantity'];
        $payment = $_SESSION['payment'];
        if (isset($_SESSION['store'])){
            $store = $_SESSION['store'];
            $user_check_query = "SELECT * 
                                FROM `TRANSACTION` as T INNER JOIN 
                                  (SELECT `TRANSACTION_Date_Time`, TRANSACTION_STORE_STORE_id, COUNT(DISTINCT PRODUCT_Barcode) as cnt FROM PRODUCT_has_TRANSACTION GROUP BY `TRANSACTION_Date_Time` ) as P 
                                      ON T.STORE_STORE_id = P.TRANSACTION_STORE_STORE_id AND T.Date_Time = P.TRANSACTION_Date_Time 
                                         WHERE T.STORE_STORE_id = $store and P.cnt >= $quantity and (T.Date_Time between '$s_date' and '$e_date') 
                                            and (T.Payment_Method like concat('%', '$payment', '%')) ORDER BY T.Date_Time";
        }else $user_check_query = "SELECT * FROM `TRANSACTION` as T INNER JOIN (SELECT `TRANSACTION_Date_Time`, TRANSACTION_STORE_STORE_id, COUNT(DISTINCT PRODUCT_Barcode) as cnt FROM PRODUCT_has_TRANSACTION GROUP BY `TRANSACTION_Date_Time` ) as P ON T.STORE_STORE_id = P.TRANSACTION_STORE_STORE_id AND T.Date_Time = P.TRANSACTION_Date_Time WHERE P.cnt >= $quantity and (T.Date_Time between '$s_date' and '$e_date') and (T.Payment_Method like concat('%', '$payment', '%')) ORDER BY T.Date_Time";
        $result = mysqli_query($db1, $user_check_query);
        while ($row = mysqli_fetch_assoc($result)) { 
            ?>
            <div>
                TRANSACTION: <strong><?php echo $row['Date_Time']; ?></strong>
                στο κατάστημα <strong><?php echo $row['STORE_STORE_id']; ?></strong> 
                ο πελάτης με αριθμό κάρτας <strong><?php echo $row['Customer_Card#']; ?></strong> 
                πήρε <strong><?php echo $row['Total_Pieces']; ?></strong> τεμάχια
                Σύνολο <strong><?php echo $row['Total_Amount']; ?></strong> €
                Πλήρωσε με <strong><?php echo $row['Payment_Method'] . '<br>'; ?></strong>
            </div>
        <?php }
        mysqli_free_result($result); 
    ?></p>

    <p>Choose <a href="edit_t.php?insert"><b>INSERT</b></a> to add a transaction!</p>

    <p>Choose <a href="edit_t.php?update"><b>UPDATE</b></a> to update a transaction!</p>

    <p>Choose <a href="edit_t.php?delete"><b>DELETE</b></a> to delete a transaction!</p>

    <p>Return to <a href="transaction.php?Home='1'"><b>Home Page</b></a></p>

    <p>If you are done <a href="transaction.php?logout='1'"><b>Log Out</b></a></p>

</body>
</html>