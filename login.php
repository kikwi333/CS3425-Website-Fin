<?php
require "db.php";
session_start();
echo "<pre>";
print_r($_SESSION); 
print_r($_POST);
echo "</pre>";
?>

<html>
<form action="login.php" method="post">
    <select name="Student or Instructor">
        <option value="" disabled selected>Choose option</option>
        <option value="Student">Student</option>
        <option value="Instructor">Instructor</option>
    </select><br>

    <label for="username">username:</label>
    <input type="text" id="username" name="username"><br>

    <label for="password">password:</label>
    <input type="password" id="password" name="password"><br>

    <input type="submit" name="login" value="login">
</form>

</html>

<?php

if (isset($_POST["login"])) {
    if (empty($_POST['Student_or_Instructor'])) {
        echo '<p style="color:red">Must select either student or instructor</p>';
    }
    else if ($_POST['Student_or_Instructor'] == "Student") {
        if (authStudent($_POST["username"], $_POST["password"]) == 1) {
            $_SESSION["type"] = $_POST['Student_or_Instructor'];
            $_SESSION["username"]=$_POST["username"];
            header("Location:main.php");
            exit();
        } else {
            echo '<p style="color:red">incorrect username and password</p>';
        }
    }
    else {
        if (authInstruct($_POST["username"], $_POST["password"]) == 1) {
            $_SESSION["type"] = $_POST['Student_or_Instructor'];
            $_SESSION["username"]=$_POST["username"];
            header("Location:main.php");
            exit();
        } else {
            echo '<p style="color:red">incorrect username and password</p>';
        }
    }
}

// user clicked the logout button */
if ( isset($_POST["logout"]) ) { 
   session_destroy();
   header("Location:main.php");
   exit();
}

?>