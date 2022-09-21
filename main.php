<?php
session_start();
echo "<pre>";
print_r($_SESSION); 
print_r($_POST);
echo "</pre>";
?>

<html>
    <form action="signup.php" method="post">
        <?php
        if (!isset($_SESSION["username"])) {
        ?>
            <input type="submit" value='signup' name="signupM"> 
        <?php
        }
        ?>
    </form>

    <form action="login.php" method="post">
        <?php
        if (!isset($_SESSION["username"])) {
        ?>
            <input type="submit" value='login' name="loginM"> 
        <?php
        } else { 
            echo "Welcome " . $_SESSION["username"] . "!<br>";
        ?>
            <input type="submit" value='logout' name="logout">
        <?php
        }
        ?>
    </form>

    <form action="chngePasswd.php" method="post">
        <?php
        if (isset($_SESSION["username"])) {
            ?>
            <input type="submit" value='Change Password' name="change_passwd"> <br>
            <?php
        }
        
        ?>
    </form>

    <?php
    if (isset($_SESSION["type"])) {
        if ($_SESSION["type"] == "Student") {
            ?>
            <p>
            You are logged in as a student. <br>
            </p> 
            
            <form action="student.php" method="post">

                <input type="submit" value='Register for Courses' name="register"><br>
    
                <input type="submit" value='Check Survey Status' name="check"><br>

                <input type="submit" value='Take Survey' name="survey"><br>

            </form>
            
            
            
            <?php
        }
        else if ($_SESSION["type"] == "Instructor") {
            ?>
            <p>
            You are logged in as an instructor. <br>
            </p>
            
            <form action="instructor.php" method="post">

                <input type="submit" value="Show Student List" name="roster"><br>
    
                <input type="submit" value="Show Survey Results" name="results"><br>

            </form>
            
            <?php
        }
    }
    else {
        ?>

        <p>
        To get started, please sign up or login with your MTU credentials.<br>
        </p>

        <?php
    }
    ?>
</html>
