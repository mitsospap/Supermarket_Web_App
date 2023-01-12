<?php
include('server.php');

if(!isset($_SESSION['username'])){

    $_SESSION['msg'] = "you must log in first to view this page";
    header("location: login.php");
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
    <title>Home Page</title>
</head>
<body>
    <h1>This is the Homepage</h1>
<?php if(isset($_SESSION['success'])) : ?>

        <h3> <?php echo $_SESSION['success']; ?> </h3>
        <?php unset($_SESSION['success']);?>
<?php endif ?>

<?php if(isset($_SESSION['username'])) : ?>   

    <h3>>Welcome <strong><?php echo $_SESSION['username']; ?></strong> </h3>
    <p>Choose your action!</p>
    <p>---> <a href="stores.php"><b>Stores</b></a></p>
    <p>---> <a href="categories.php"><b>Categories</b></a></p>
    <p>---> <a href="product.php"><b>Products</b></a></p>
    <p>---> <a href="transaction.php"><b>Transactions</b></a></p>
    <p>---> <a href="customer.php"><b>Customers</b></a></p>
    <p>---> <a href="stats.php"><b>General Statistics</b></a></p>
    <p>If you are done <a href="index1.php?logout='1'"><b>Log Out</b></a></p>
<?php endif ?>
    
</body>
</html>