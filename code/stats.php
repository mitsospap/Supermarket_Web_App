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
} ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>STATS</title>
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
        <h1>General Statistics!</h1>
    </div>
    <p>
        <div>
            <?php
                $user_check_query = "SELECT * FROM product_couples";
                $result = mysqli_query($db1, $user_check_query);
                $row = mysqli_fetch_assoc($result);
                $p_A = $row['product_A']; 
                $p_B = $row['product_B'];
                $cnt1 = $row['cnt'];
                $row = mysqli_fetch_assoc($result);
                if ($row['product_A'] == $p_B && $row['product_B'] == $p_A){
                    $row = mysqli_fetch_assoc($result);
                    $p_2A = $row['product_A']; 
                    $p_2B = $row['product_B'];
                    $cnt2 = $row['cnt'];
                }else{
                    $p_2A = $row['product_A']; 
                    $p_2B = $row['product_B'];
                    $cnt2 = $row['cnt'];
                }
                mysqli_free_result($result);
            ?>
                <table style="width: 20%">
                    <tr>
                        <th style="width:auto">Top 2</th>
                        <th style="width:auto">Product Couples</th>
                    </tr>
                    <tr>
                        <th style="width:auto">Barcode A</th>
                        <th style="width:auto">Barcode B</th>
                        <th style="width:auto">Pieces</th>
                    </tr>
                    <tr>
                        <td style="text-align: center"><?php echo $p_A ?></td>
                        <td style="text-align: center"><?php echo $p_B ?></td>
                        <td style="text-align: center"><?php echo $cnt1 ?></td>
                    </tr>
                    <tr>
                        <td style="text-align: center"><?php echo $p_2A ?></td>
                        <td style="text-align: center"><?php echo $p_2B ?></td>
                        <td style="text-align: center"><?php echo $cnt2 ?></td>
                    </tr>
                </table>
        </div>
    </p>
    <p>
        <div>
            <?php
                $user_check_query = "SELECT total.`Category_Category_id`, total_cnt, tag_cnt 
                                        FROM (SELECT COUNT(`Brand_name`) as tag_cnt, `Category_Category_id` FROM `tops` WHERE `Brand_name` = 1 GROUP BY `Category_Category_id` ORDER BY `Category_Category_id`) as tag 
                                                RIGHT OUTER JOIN (SELECT COUNT(`Brand_name`) as total_cnt, `Category_Category_id` FROM `tops` GROUP BY `Category_Category_id` ORDER BY `Category_Category_id`) as total 
                                                    ON tag.`Category_Category_id` = total.`Category_Category_id` ";
                $result = mysqli_query($db1, $user_check_query);
                while ($row = mysqli_fetch_assoc($result)) {
                    $category = $row['Category_Category_id'];
                    $tag = $row['tag_cnt'];
                    $percent = ($tag/$row['total_cnt']) * 100;
                    echo "Για την κατηγορία <b> $category </b>οι πελάτες προτιμούν προιόντα με ετικέτα του καταστήματος κατα <b>$percent %</b><br>";
                }
                mysqli_free_result($result);
    
            
            
            
            
            ?>
        </div>
    </p>






    <p>Return to <a href="stats.php?Home='1'"><b>Home Page</b></a></p>

    <p>If you are done <a href="stats.php?logout='1'"><b>Log Out</b></a></p>
</body>
</html>