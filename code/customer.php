<?php
include('server.php');

if (!isset($_SESSION['username'])) {

    $_SESSION['msg'] = "you must log in first to view this page";
    header("location: login.php");
}
if (isset($_GET['Home'])) {

    unset($_SESSION['card']);
    header("location: index1.php");
}
if (isset($_GET['reset'])) {
    unset($_SESSION['card']);
}
if (isset($_GET['logout'])) {

    unset($_SESSION['card']);
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
} ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Customers</title>
</head>
<style>
    table,
    th,
    td {
        border: 1px solid black;
    }
</style>

<body>
    <div>
        <h1>Customers!</h1>
    </div>
    <form action="customer.php" method="POST">
        <div>
            <label for="card">Choose a customer(Card Number) to see some stats</label>
            <input type="number" name="card">

            <button type="submit" name="search_customer">SEARCH</button>
            <a href="customer.php?reset">RESET</a>
        </div>
    </form>
    <p>
        <?php
        if (isset($_SESSION['card'])) {
            $card = $_SESSION['card'];
            $user_check_query = "SELECT Name, SUM(cnt) as t_sum FROM tops WHERE `Customer_Card#` = '$card' GROUP BY Barcode ORDER BY t_sum desc, Name   limit 10 ";
            $result = mysqli_query($db1, $user_check_query);
        ?>
            <div>
                <table style="width: 20%">
                    <tr>
                        <th style="width:auto">Top 10</th>
                        <th style="width:auto">Card# <?php echo $card ?></th>
                    </tr>

                    <tr>
                        <th style="width:auto">product name</th>
                        <th style="width:auto">quantity</th>
                    </tr>

                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                        <tr>
                            <td style="text-align: center"><?php echo $row['Name'] ?></td>
                            <td style="text-align: center"><?php echo $row['t_sum'] . '<br>' ?></td>
                        </tr>
                    <?php }
                    mysqli_free_result($result); ?>
                </table>
            </div>
            <?php
            $user_check_query = "SELECT * FROM `TRANSACTION`, 
                                            (SELECT COUNT(*) FROM 
                                                                (SELECT DISTINCT (STORE_STORE_id) FROM `TRANSACTION` WHERE `TRANSACTION`.`Customer_Card#` = '$card') as cnt) as cnt1 
                                                                WHERE `TRANSACTION`.`Customer_Card#` = '$card' order by STORE_STORE_id, Date_Time";
            $result = mysqli_query($db1, $user_check_query); ?>
            <p>
                <div>
                    <?php
                    echo "Έχει επισκεφθεί το κατάστημα: <br>";
                    $total = 0;
                    $_SESSION['store'] = 0;
                    while ($row = mysqli_fetch_assoc($result)) {
                        if ($_SESSION['store'] != $row['STORE_STORE_id']){
                            $_SESSION['store'] = $row['STORE_STORE_id'];
                            echo "<b>" . $row['STORE_STORE_id'] . " </b>";
                            $test = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0);
                        }
                        $date = strtotime($row['Date_Time']);
                        $hours = date('H', $date);
                        for ($i = 8; $i <= 21; $i++) {
                            if ($hours == $i && $test[$i-8]== 0 ) {
                                echo " στις $hours:00:00 - $hours:59:59 <br>";
                                $test[$i-8] = 1;
                            }
                        }                       
                        $total = $row['COUNT(*)'];
                    }
                    echo "Έχει επισκεφθεί συνολικά <b> $total </b> καταστήματα!<br>";
                    unset($_SESSION['store']);
                    mysqli_free_result($result);
                    ?>
                </div>
            </p>
            <p>
                <div>
                    <?php
                        $e_date = date("Y-m-d");
                        $week_date = date_create($e_date);
                        date_sub($week_date,date_interval_create_from_date_string("7 days"));                                              
                        $week_date = date_format($week_date,"Y-m-d");
                        $month_date = date_create($e_date);
                        date_sub($month_date, date_interval_create_from_date_string('1 month'));
                        $month_date = date_format($month_date,"Y-m-d");
                        $user_check_query= "SELECT * FROM (SELECT AVG(Total_Amount) as W_avg FROM `TRANSACTION` WHERE `Customer_Card#` = '$card' and `Date_Time` BETWEEN '$week_date' and '$e_date') as W,
                                                            (SELECT AVG(Total_Amount) as M_avg FROM `TRANSACTION` WHERE `Customer_Card#` = '$card' and `Date_Time` BETWEEN '$month_date' and '$e_date') as M";
                        $result = mysqli_query($db1, $user_check_query); 
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "avg last week: <b>" . $row['W_avg']. "</b> € <br>";
                            echo "avg last month: <b>" . $row['M_avg'] ."</b> € <br>" ;
                        }
                        mysqli_free_result($result);
                    ?>
                </div>
            </p>
            <?php

        } else {
            $user_check_query = "SELECT * FROM Customer ";
            $result = mysqli_query($db1, $user_check_query);
            while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div>
                    Ο πελάτης <strong><?php echo $row['Name']; ?></strong>
                    με αριθμό κάρτας: <strong><?php echo $row['Card#']; ?></strong>
                    και μένει στην <strong><?php echo $row['City'], ' ', $row['Street'], ' ', $row['Number']; ?></strong>
                    τ.κ <strong><?php echo $row['Postal_Code']; ?></strong>
                    Ηλικία: <strong><?php echo $row['Age'] . '<br>'; ?></strong>
                </div>
            <?php }
            mysqli_free_result($result);
            ?>
    </p>

    <p>Choose <a href="edit_c.php?insert"><b>INSERT</b></a> to add a customer!</p>

    <p>Choose <a href="edit_c.php?update"><b>UPDATE</b></a> to update a customer!</p>

    <p>Choose <a href="edit_c.php?delete"><b>DELETE</b></a> to delete a customer!</p>
<?php
        } ?>

<p>Return to <a href="customer.php?Home='1'"><b>Home Page</b></a></p>

<p>If you are done <a href="customer.php?logout='1'"><b>Log Out</b></a></p>

</body>

</html>