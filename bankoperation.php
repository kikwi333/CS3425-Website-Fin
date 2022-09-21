<style>
    table,th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
<?php
require "db.php";

session_start();
print_r($_SESSION);
print_r($_POST);

if (!isset($_SESSION["username"])) {
    header("Location:login.php");
}

function print_debug($var) {
    echo "<br>DEBUGGING INFORMATION";
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    echo "<br>";
}

if (isset($_POST["accounts"])) {
    $accounts = get_accounts($_SESSION["username"]);
    print_debug($accounts);
    ?>
    
    <table>
    <tr>
    <th>Account</th>
    <th>Balance</th> 
    </tr>

    <?php
    foreach ($accounts as $row) {
        echo "<tr>";
        echo "<td>" . $row[0] . "</td>";
        echo "<td>" . $row[1] . "</td>";
        echo "</tr>";
    }
    echo "<table>";
}

if (isset($_POST["transfer"])) {
    ?>
    <html>
        <form method="post">
            <label for="from_account">From account:</label>
            <input type="text" id="from_account" name="from_account"><br>
            <label for="to_account">To account:</label>
            <input type="text" id="to_account" name="to_account"><br>
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" min="0"><br>
            <input type="submit" name="confirm" value="Confirm">
        </form>
    </html>
    <?php
}

if (isset($_POST["confirm"])) {
    $from = $_POST["from_account"];
    $to = $_POST["to_account"];
    $amount = $_POST["amount"];
    $user = $_SESSION["username"];
    transfer($from, $to, $amount, $user);
}

?>