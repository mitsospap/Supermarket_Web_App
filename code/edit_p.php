<?php
include('server.php');

if (!isset($_SESSION['username'])) {

    $_SESSION['msg'] = "you must log in first to view this page";
    header("location: login.php");
}
unset($_SESSION['barcode']);
if (isset($_GET['Home'])) {

    header("location: index1.php");
}

if (isset($_GET['logout'])) {

    session_destroy();
    unset($_SESSION['?username']);
    header("location: login.php");
}
if (isset($_GET['insert']) || isset($_GET['update'])) { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>insert or update</title>
    </head>

    <body>
        <div>
            <h1>Fill The Values!</h1>
        </div>

        <form action="edit_p.php" method="post">
            <div>
                <label for="Barcode">Barcode</label>
                <input type="number" name="barcode" required>
            </div>
            <div>
                <label for="Name">Name</label>
                <input type="text" name="name" required>
            </div>
            <div>
                <label for="Brand_name">Brand Name(0/1)</label>
                <input type="number" name="brand" required>
            </div>
            <div>
                <label for="Price">Price</label>
                <input type="number" step=0.01 name="price" required>
            </div>
            <div>
                <label for="Category_Category_id">Category id</label>
                <input type="number" name="c_id" required>
            </div>
            <div>
                <label for="Starting_Date">Date</label>
                <input type="date" name="s_date" required>
            </div>
            <div>
                <label for="alley">Alley</label>
                <input type="number" name="alley" required>
            </div>
            <div>
                <label for="shelf">Shelf</label>
                <input type="number" name="shelf" required>
            </div>
            <div>
                <label for="STORE_STORE_id">Store id</label>
                <input type="number" name="id">
            </div>
        

            <p> <button type="submit" name="insert_product"> INSERT</button>

                <button type="submit" name="update_product"> UPDATE</button><p>

            <p>Return to <a href="edit_p.php?Home='1'"><b>Home Page</b></a></p>

            <p>If you are done <a href="edit_p.php?logout='1'"><b>Log Out</b></a></p>
        </form>

    </body>

    </html>
<?php
}
if (isset($_GET['delete'])) { ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>delete</title>
    </head>

    <body>
        <div class="conatiner">
            <div>
                <h1>Choose Product!</h1>
            </div>

            <form action="edit_p.php" method="post">
                <div>
                    <label for="Barcode">Barcode</label>
                    <input type="number" name="barcode" required>
                </div>
            
                <p> <button type="submit" name="delete_product"> DELETE</button><p>

                <p>Return to <a href="edit_p.php?Home='1'"><b>Home Page</b></a></p>

                <p>If you are done <a href="edit_p.php?logout='1'"><b>Log Out</b></a></p>
            </form>

        </div>

    </body>

    </html>
<?php
} ?>