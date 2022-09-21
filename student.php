<style>
    table,th, td {
        border: 1px solid black;
        border-collapse: collapse;
    }
</style>
<?php
require "db.php";
session_start();
echo "<pre>";
print_r($_SESSION); 
print_r($_POST);
echo "</pre>";

function print_debug($var) {
    echo "<br>DEBUGGING INFORMATION";
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    echo "<br>";
}

//*********REGISTER FOR COURSES - START***********
if (isset($_POST["register"])) {
    $courses = get_courses();
    print_debug($courses);
    ?>
    <div>

    <p>
        Available Courses:<br>
    </p>
    <table id="courses">
    <tr>
    <th>ID</th>
    <th>Title</th>
    <th>Credit</th> 
    <th style = "width: 500px;">Description</th>
    </tr>

    <?php

    foreach ($courses as $row) {
        echo "<tr>";
        echo "<td>" . $row[0] . "</td>";
        echo "<td>" . $row[1] . "</td>";
        echo "<td>" . $row[2] . "</td>";
        echo "<td>" . $row[3] . "</td>";
        echo "</tr>";
    }
    ?>
    </table>
    
    <?php
    echo "<table>";
    ?>
    </div>

    <form action="student.php" method="post">
        
        <label for="course_ID">Course ID:</label>
        <input type="text" id="course_ID" name="course_ID"><br>
        <input type="submit" value='Register using ID' name="register_ID"><br>
    </form>




    <div>
    
    <p>
        Registered Courses:<br>
    </p>

    <table id="reg_courses">
    <tr>
    <th>ID</th>
    <th>Title</th>
    </tr>
    <?php

    $reg_courses = registered_courses($_SESSION["username"]);
    foreach ($reg_courses as $row) {
        echo "<tr>";
        echo "<td>" . $row[0] . "</td>";
        echo "<td>" . $row[1] . "</td>";
        echo "</tr>";
    }
    ?>
    </table>
    
    <?php
    echo "<table>";
    ?>
    </div>
    <?php
}

if (isset($_POST["register_ID"])) {
    $id = $_POST["course_ID"];
    $user = $_SESSION["username"];
    $reg_courses = register($user, $id);
    print_debug($reg_courses);
}
//*********REGISTER FOR COURSES - END***********

//*********CHECK SURVEY STATUS - START***********
if (isset($_POST["check"])) {
    $surveys = get_eval_stat($_SESSION["username"]);
    print_debug($surveys);
    ?>
    <div>

    <p>
        Survey Status:<br>
    </p>
    <table id="surv">
    <tr>
    <th>Course</th>
    <th>Status</th>
    </tr>

    <?php

    foreach ($surveys as $row) {
        echo "<tr>";
        echo "<td>" . $row[0] . "</td>";
        echo "<td>" . $row[1] . "</td>";
        echo "</tr>";
    }
    ?>
    </table>
    <?php
    echo "<table>";
}
//*********CHECK SURVEY STATUS - END***********

//*********TAKE SURVEY - START***********
if (isset($_POST["survey"])) {
    
    $num_class = num_class_taken($_SESSION["username"]);
    $courseList = get_courseID($_SESSION["username"]);
    //print_debug($num_class);
    //print_debug($courseList);
    $num = $num_class[0][0] - 1;

    if($num == 0)
    {
        echo "You have no evaluations <br>";
    }
    else {
        ?>
        
        <form action="quiz.php" method="post">
            <p>
                Select the course ID that you want to take an<br>
                evaluation for.
            </p>
            <select name="course_evals">
            <?php
            //Generate dynamic drop down menu
            while($num >= 0)
            {
                ?>
                
                <option value="<?php $courseList[$num][0]?>">Course ID: <?php echo $courseList[$num][0]; ?> </option>
                <?php
                $num--;
            }
            //Submit button to take specified evaluation
            ?>
            <input type="submit" name="Take_Evaluation" value="Take Evaluation">
        </form>
        
        <?php
    }
    ?> 
    <!-- <label for="username">username:</label>
    <input type="text" id="username" name="username"><br>

    <input type="submit" name="login" value="login"> -->

    <?php

    
}
//*********TAKE SURVEY - END***********



?>