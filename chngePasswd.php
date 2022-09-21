<?php
require "db.php";
session_start();
echo "<pre>";
print_r($_SESSION); 
print_r($_POST);
echo "</pre>";
?>

<html>
<p>
    If you want to change your password,<br>
    type your desired password below twice.<br>
</p>
<form method="post">
    <label for="password">Password:</label>
    <input type="password" id="password" name="new_password"><br>

    <label for="password">Confirm Password:</label>
    <input type="password" id="ConPassword" name="ConPassword"><br>

    <input type="submit" name="changePasswd" value="Change Password">
</form>

</html>

<?php
// user clicked the change password button */

if (isset($_POST["changePasswd"])) {
    echo "hi";
    if ($_SESSION["type"] == "Student") {
        if (strcmp($_POST["new_password"], $_POST["ConPassword"]) == 0 && strcasecmp($_POST["new_password"],"null") != 0 && $_POST['new_password'] != NULL && $_POST['new_password'] != '') {
            set_student_password($_SESSION["username"], $_POST["ConPassword"]);
            header("Location:main.php");
            exit();
        } else {
            echo '<p style="color:red">Passwords must be matching or password cannot be null/blank</p>';
        }
            
    
    } else {
        if (strcmp($_POST["new_password"], $_POST["ConPassword"]) == 0 && strcasecmp($_POST["new_password"],"null") != 0 && $_POST['new_password'] != NULL && $_POST['new_password'] != '') {
            set_instruct_password($_SESSION["username"], $_POST["ConPassword"]);
            header("Location:main.php");
            exit();
        } else {
            echo '<p style="color:red">Passwords must be matching or password cannot be null/blank</p>';
        }
    }
}