<?php
include('server.php');

if (!isset($_SESSION['username'])) {

    $_SESSION['msg'] = "you must log in first to view this page";
    header("location: login.php");
}
if (isset($_GET['Home'])) {

    unset($_SESSION['barcode']);
    header("location: index1.php");
}
if(isset($_GET['reset'])){
    unset($_SESSION['barcode']);
}

if (isset($_GET['logout'])) {

    unset($_SESSION['barcode']);
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
} ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Products</title>
</head>

<body>
    <h1>Products!</h1>
    <form action="product.php" method="POST">
        <div>
            <label for="barcode">Choose a Barcode to see his Price history</label>
            <input type="number" name="barcode">
            <button type="submit" name="search_prices"> SEARCH</button> 
            <a href="product.php?reset">RESET</a>
        </div>
    </form>
    <?php
        if(isset($_SESSION['barcode'])){
            $barcode = $_SESSION['barcode'];
            $user_check_query1 = "SELECT * FROM OLDER_PRICES WHERE PRODUCT_Barcode = '$barcode' ORDER BY `Start_Date`";
            $result = mysqli_query($db1, $user_check_query1);
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <div>
                    Προιόν με Barcode: <strong><?php echo $row['PRODUCT_Barcode']; ?></strong>
                    κόστιζε <strong><?php echo $row['Price']; ?></strong> €
                    από <strong><?php echo $row['Start_Date']; ?></strong> 
                    εώς <strong><?php echo $row['End_Date'] . '<br>'; ?></strong>
        
                </div>       
            <?php
            } 
            mysqli_free_result($result);
            ?>
            <p>
                <div>
                    <h2>The rest products!</h2>
                </div>
            </p><?php
        }
    ?>
    <p>
    <?php

    $user_check_query = "SELECT Barcode, P.Name as PName, Price, C.Name FROM PRODUCT as P, Category as C 
                            WHERE P.Category_Category_id = C.Category_id ORDER BY Barcode";
    $results = mysqli_query($db1, $user_check_query);
    ?>
    <?php while ($row = mysqli_fetch_assoc($results)) {
        ?>
        <div>
            Προιόν: <strong><?php echo $row['PName']; ?></strong>
            με Barcode <strong><?php echo $row['Barcode']; ?></strong> 
            κοστίζει <strong><?php echo $row['Price']; ?></strong> €
            και ανήκει στην κατηγορια <strong><?php echo $row['Name'] . '<br>'; ?></strong>

        </div>

    <?php
    } 
    mysqli_free_result($results);?>
    </p>

    <p>Choose <a href="edit_p.php?insert"><b>INSERT</b></a> to add a product!</p>

    <p>Choose <a href="edit_p.php?update"><b>UPDATE</b></a> to update a product!</p>

    <p>Choose <a href="edit_p.php?delete"><b>DELETE</b></a> to delete a product!</p>

    <p>Return to <a href="product.php?Home='1'"><b>Home Page</b></a></p>

    <p>If you are done <a href="product.php?logout='1'"><b>Log Out</b></a></p>


</body>

</html>