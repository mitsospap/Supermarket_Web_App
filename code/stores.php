<?php
include('server.php');

if(!isset($_SESSION['username'])){

    $_SESSION['msg'] = "you must log in first to view this page";
    header("location: login.php");
}
if(isset($_GET['Home'])){

    header("location: index1.php");
}
if (isset($_GET['reset'])) {
    unset($_SESSION['store']);
}
if(isset($_GET['logout'])){
    
    unset($_SESSION['store']);
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Stores</title>
</head>
<style>
    table,
    th,
    td {
        border: 1px solid black;
    }
</style>
<body>
    <h1>Stores!</h1>
    <form action="stores.php" method="POST">
        <div>
            <label for="store">Choose a store to see his top alley/shelf</label>
            <input type="number" min="0" name="store">

            <button type="submit" name="search_store">SEARCH</button>
            <a href="stores.php?reset">RESET</a>
        </div>   
    </form>
    <?php
        if(isset($_SESSION['store'])){
            $store = $_SESSION['store'];
            $user_check_query = "SELECT alley as a, shelf as s FROM `tops`, STORE_has_PRODUCT as P 
                                    WHERE P.STORE_STORE_id = tops.STORE_STORE_id and P.PRODUCT_Barcode = tops.Barcode and tops.STORE_STORE_id = '$store' limit 20";
            $result = mysqli_query($db1, $user_check_query);
            ?>
            <p>
            <div>
                <table style="width: 20%">
                    <tr>
                        <th style="width:auto">Top 20</th>
                        <th style="width:auto">Store <?php echo $store ?></th>
                    </tr>

                    <tr>
                        <th style="width:auto">Alley</th>
                        <th style="width:auto">Shelf</th>
                    </tr>

                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td style="text-align: center"><?php echo $row['a'] ?></td>
                            <td style="text-align: center"><?php echo $row['s'] . '<br>' ?></td>
                        </tr>
                    <?php }
                    mysqli_free_result($result); ?>
                </table>
            </div>
            </p>
            <?php
        }
    
        $user_check_query = "SELECT * FROM STORE";
        $results = mysqli_query($db1, $user_check_query);

        while($row = mysqli_fetch_assoc($results)){ ?>
        <div> 
        Το κατάστημα <strong><?php echo $row['STORE_id'];?></strong> 
        είναι <strong><?php echo $row['Size'];?></strong> 
        βρίσκεται στην <strong><?php echo $row['Street'].' '. $row['Number'];?></strong>
        <strong><?php echo $row['City'];?></strong> 
        τ.κ <strong><?php echo $row['Postal_Code'];?></strong>
        ωράριο <strong><?php echo $row['Operating_Hours']. '<br>';?></strong>
        
        </div>
            
    <?php
    }
    mysqli_free_result($results);
    ?> 

    <p>Choose <a href="edit_s.php?insert"><b>INSERT</b></a> to add a store!</p>

    <p>Choose <a href="edit_s.php?update"><b>UPDATE</b></a> to update a store!</p>

    <p>Choose <a href="edit_s.php?delete"><b>DELETE</b></a> to delete a store!</p>

    <p>Return to <a href="stores.php?Home='1'"><b>Home Page</b></a></p>

    <p>If you are done <a href="stores.php?logout='1'"><b>Log Out</b></a></p>     

    
</body>
</html>