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

        <form action="edit_c.php" method="post">
            <div>
                <label for="Card#">Card#</label>
                <input type="number" name="card" required>
            </div>
            <div>
                <label for="Name">Name</label>
                <input type="text" name="name" required>
            </div>
            <div>
                <label for="Date_of_Birth">Date of Birth</label>
                <input type="date" name="dob" required>
            </div>
            <div>
                <label for="Family_Members">Family Members</label>
                <input type="number" name="family">
            </div>
            <div>
                <label for="Pet">Pet</label>
                <input type="text" name="pet">
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
                <label for="street">Street</label>
                <input type="text" name="street" required>
            </div>
            <div>
                <label for="Number">Number</label>
                <input type="number" name="number" required>
            </div>
            <div>
                <label for="Phone#1">Phone#1</label>
                <input type="text" name="phone1">
            </div>
            <div>
                <label for="Phone#2">Phone#2</label>
                <input type="text" name="phone2">
            </div>
        

            <p> <button type="submit" name="insert_customer"> INSERT</button>

                <button type="submit" name="update_customer"> UPDATE</button><p>

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
                <h1>Choose Customer!</h1>
            </div>

            <form action="edit_c.php" method="post">
                <div>
                    <label for="Card#">Card Number</label>
                    <input type="number" name="card" required>
                </div>
            
                <p> <button type="submit" name="delete_customer"> DELETE</button><p>

                <p>Return to <a href="edit_c.php?Home='1'"><b>Home Page</b></a></p>

                <p>If you are done <a href="edit_c.php?logout='1'"><b>Log Out</b></a></p>
            </form>

        </div>

    </body>

    </html>
<?php
} ?>