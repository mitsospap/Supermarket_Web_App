<?php
include('server.php');

if(!isset($_SESSION['username'])){

    $_SESSION['msg'] = "you must log in first to view this page";
    header("location: login.php");
}
if(isset($_GET['Home'])){

    header("location: index1.php");
}

if(isset($_GET['logout'])){

    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Categories</title>
</head>
<body>
    <h1>Categories!</h1>
    <p>Each and every store has the following categories:</p> 
    <?php

        $user_check_query = "SELECT * FROM Category ORDER BY Category_id ";
        $results = mysqli_query($db1, $user_check_query);
        $names = array();
    ?>
    <?php while($row = mysqli_fetch_assoc($results)){ 
        $names = $row['Name']; ?>
        <div> 
        <strong><?php echo $names . "<br>";?></strong>
        
        </div>
            
    <?php 
    }
    mysqli_free_result($results); ?>

    <p>Return to <a href="categories.php?Home='1'"><b>Home Page</b></a></p>

    <p>If you are done <a href="categories.php?logout='1'"><b>Log Out</b></a></p>     

    
</body>
</html>