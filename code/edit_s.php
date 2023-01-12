<?php
include('server.php');

if(!isset($_SESSION['username'])){

    $_SESSION['msg'] = "you must log in first to view this page";
    header("location: login.php");
}
if(isset($_GET['Home'])){

    header("location: index1.php");
}
unset($_SESSION['store']);
if(isset($_GET['logout'])){

    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}
if (isset($_GET['insert']) || isset($_GET['update'])){?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Stores</title>
</head>
<body>
    <div class="container">
        <div class="header">

            <h2>Fill Values!</h2>

        </div>

        <form action="edit_s.php" method="post">
            <div>
                <label for="STORE_id">Store Number</label>
                <input type="number" name="store_id" required>
            </div>

            <div>
                <label for="Size">Size</label>
                <input type="text" name="size" required>
            </div>

            <div>
                <label for="Operating_Hours">Operating Hours</label>
                <input type="text" name="operating" required>
            </div>

            <div>
                <label for="City">City</label>
                <input type="text" name="city" required>
            </div>

            <div>
                <label for="Postal_Code">Postal Code</label>
                <input type="number" name="pc" required>
            </div>

            <div>
                <label for="Street">Street</label>
                <input type="text" name="street" required>
            </div>

            <div>
                <label for="Number">Street Number</label>
                <input type="number" name="number" required>
            </div>

            <div>
                <label for="Phnoe#">Phone#1</label>
                <input type="text" name="phone1" >
            </div>

            <div>
                <label for="Phnoe#">Phone#2</label>
                <input type="text" name="phone2" >
            </div>

            <p> <button type="submit" name="insert_store"> INSERT</button>

                <button type="submit" name="update_store"> UPDATE</button><p>

            <p>Return to <a href="edit_s.php?Home='1'"><b>Home Page</b></a></p>

            <p>If you are done <a href="edit_s.php?logout='1'"><b>Log Out</b></a></p>

        </form>

    </div>

    
</body>
</html>
<?php
}
if (isset($_GET['delete'])){?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Delete Stores</title>
</head>
<body>
    <div class="container">
        <div class="header">

            <h2>Choose Store!</h2>

        </div>

        <form action="edit_s.php" method="post">
            <div>
                <label for="STORE_id">Store Number</label>
                <input type="number" name="store_id" required>
            </div>

            <p><button type="submit" name="delete_store"> DELETE</button></p>

            <p>Return to <a href="edit_s.php?Home='1'"><b>Home Page</b></a></p>

            <p>If you are done <a href="edit_s.php?logout='1'"><b>Log Out</b></a></p>

        </form>

    </div>

    
</body>
</html>
<?php
}?>
