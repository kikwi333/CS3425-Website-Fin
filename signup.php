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
        Welcome! To get started, start by selecting<br>
        whether you're a student or an instructor.<br>
        Then, input your username and desired password.<br>
        Note: You must use your school-provided username.<br>
    </p>
    <form action="signup.php" method="post">
        <!-- <label for="name">name:</label>
        <input type="text" id="name" name="name"><br> -->

        <select name="Student or Instructor">
        <option value="" disabled selected>Choose option</option>
        <option value="Student">Student</option>
        <option value="Instructor">Instructor</option>
        </select><br>
                
        <label for="username">Username:</label>
        <input type="text" id="username" name="username"><br>
        
        <label for="password">Password:</label>
        <input type="password" id="password" name="password"><br>

        <label for="password">Confirm Password:</label>
        <input type="password" id="ConPassword" name="ConPassword"><br>

        <input type="submit" name="signup" value="sign up">
    </form>
</html>

<?php
// user clicked the sign up button
if (isset($_POST["signup"])) { 

    //check if the user has select either student or instructor
    //error message if they haven't done so
    //  get student or instructor username
    //      check if username exists
    //          if it doesn't exist, error message
    //          otherwise, check if passwords match
    //              if passwords match, let them signup and redirect to main.php
    //              otherwise, error message

    if (empty($_POST['Student_or_Instructor'])) {
        echo '<p style="color:red">Must select either student or instructor</p>';
    }
    else if ($_POST['Student_or_Instructor'] == "Student") {
        $_SESSION["type"] = $_POST['Student_or_Instructor'];
        $exists = get_stu_accounts($_POST["username"]);
        if ($exists) {
            if (strcmp($_POST["password"], $_POST["ConPassword"]) == 0 && strcasecmp($_POST["password"],"null") != 0 && $_POST['password'] != NULL && $_POST['password'] != '') {
                set_student_password($_POST["username"], $_POST["password"]);
                $_SESSION["username"] = $_POST["username"];
                header("Location:main.php");
            }
            else {
                echo '<p style="color:red">Passwords must be matching or password cannot be null/blank</p>';
            }
        }
        else {
            echo '<p style="color:red">Username needs to exist</p>';
        }
 
        
    }
    else {
        $_SESSION["type"] = $_POST['Student_or_Instructor'];
        $exists = get_instruct_accounts($_POST["username"]);
        if ($exists) {
            if (strcmp($_POST["password"], $_POST["ConPassword"]) == 0 && strcasecmp($_POST["password"],"null") != 0 && $_POST['password'] != NULL && $_POST['password'] != '') {
                set_instruct_password($_POST["username"], $_POST["password"]);
                $_SESSION["username"] = $_POST["username"];
                header("Location:main.php");
            }
            else {
                echo '<p style="color:red">Passwords must be matching or password cannot be null/blank</p>';
            }
        }
        else {
            echo '<p style="color:red">Username needs to exist</p>';
        }
    } 
} 
?>
