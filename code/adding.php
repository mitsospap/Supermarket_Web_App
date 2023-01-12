<?php
include('server.php');

if (!isset($_SESSION['username'])) {

    $_SESSION['msg'] = "you must log in first to view this page";
    header("location: login.php");
}
if (isset($_GET['Home'])) {

    header("location: index1.php");
}

if (isset($_GET['logout'])) {

    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>ADD</title>
</head>
<body>
    <div>
        <h1>Fill The Values!</h1>
    </div>
    <form action="adding.php" method="post" >
        <div>
            <label for="barcode">Product Barcode</label>
            <input type="number" name="barcode" required>
        </div>
        <div>
            <label for="category">Category of the Product</label>
            <input type="number" name="category" required>
        </div>
        <div>
            <label for="Pieces">Pieces</label>
            <input type="number" name="pieces">
        </div>

        <p>
            <button type="submit" name="add_trans">ADD</button>
            <button type="submit" name="update_trans">UPDATE</button>
            <button type="submit" name="delete_trans">DELETE</button>
        </p>
        <p>If you finish press <a href="transaction.php">here</a>!</p>
    </form> 
    <div>
        <?php
            $s_id = $_SESSION['STORE_STORE_id'];
            $date = $_SESSION['Date_Time'];
            $user_check_query = "SELECT * FROM PRODUCT_has_TRANSACTION WHERE TRANSACTION_Date_Time = '$date' and TRANSACTION_STORE_STORE_id = '$s_id' ORDER BY PRODUCT_Barcode";
            $result = mysqli_query($db1, $user_check_query);
            while ($row = mysqli_fetch_assoc($result)) { 
            ?>
            <div>
                TRANSACTION: <strong><?php echo $row['TRANSACTION_Date_Time']; ?></strong>
                στο κατάστημα <strong><?php echo $row['TRANSACTION_STORE_STORE_id']; ?></strong> 
                το προιόν με αριθμό barcode <strong><?php echo $row['PRODUCT_Barcode']; ?></strong> 
                ανήκει στην κατηγορία <strong><?php echo $row['PRODUCT_Category_Category_id']; ?></strong>
                πήρε <strong><?php echo $row['Pieces'] ?></strong> τεμάχια
                <?php echo '<br>';?>
            </div>
        <?php }
            mysqli_free_result($result); 
        ?>
    </div>  
</body>
</html>