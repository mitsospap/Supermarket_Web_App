<?php
include('server.php');

if (!isset($_SESSION['username'])) {

    $_SESSION['msg'] = "you must log in first to view this page";
    header("location: login.php");
}
if (isset($_SESSION['s_date'])){
    unset($_SESSION['store']);
    unset($_SESSION['s_date']);
    unset($_SESSION['e_date']);
    unset($_SESSION['quantity']);
    unset($_SESSION['payment']);
}
if (isset($_GET['Home'])) {

    header("location: index1.php");
}

if (isset($_GET['logout'])) {

    session_destroy();
    unset($_SESSION['username']);
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

        <form action="edit_t.php" method="post">
            <div>
                <label for="Date_Time">Date Time</label>
                <input type="datetime-local" name="date" required>
            </div>
            <div>
                <label for="Payment_Method">Payment Method</label>
                <input type="text" name="payment" required>
            </div>
            <div>
                <label for="Customer_Card#">Customer Card Number</label>
                <input type="number" name="card" required>
            </div>
            <div>
                <label for="STORE_STORE_id">Store Number</label>
                <input type="number" name="s_id" required>
            </div>        

            <p> <button type="submit" name="insert_transaction"> INSERT</button>

                <button type="submit" name="update_transaction"> UPDATE</button><p>

            <p>Return to <a href="edit_c.php?Home='1'"><b>Home Page</b></a></p>

            <p>If you are done <a href="edit_c.php?logout='1'"><b>Log Out</b></a></p>
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
                <h1>Choose Transaction!</h1>
            </div>

            <form action="edit_t.php" method="post">
                <div>
                    <label for="Date_Time">Date Time</label>
                    <input type="datetime-local" name="date" required>
                </div>
                <div>
                    <label for="Customer_Card#">Customer Card Number</label>
                    <input type="number" name="card" required>
                </div>
                <div>
                    <label for="STORE_STORE_id">Store Number</label>
                    <input type="number" name="s_id" required>
                </div>
            
                <p><button type="submit" name="delete_transaction"> DELETE</button><p>

                <p>Return to <a href="edit_c.php?Home='1'"><b>Home Page</b></a></p>

                <p>If you are done <a href="edit_c.php?logout='1'"><b>Log Out</b></a></p>
            </form>

        </div>

    </body>

    </html>
<?php
} ?>