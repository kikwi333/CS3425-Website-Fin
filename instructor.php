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

if (isset($_POST["roster"])) 
{
    ?>

    <form action="instructor.php" method="post">
        <label for="course_ID">Course ID:</label>
        <input type="text" id="course_ID" name="course_ID"><br>
        <input type="submit" value="Generate roster" name="find_ID"><br>
    </form>

    
    <?php
}


if (isset($_POST["course_ID"])) {
    $id = $_POST["course_ID"];
    $roster_list = get_roster($id);
    print_debug($roster_list);
    ?>

    <table id="roster_list">
    <tr>
    <th>Student Accounts</th>
    <th>Student Names</th>
    </tr>
    

    <?php
    foreach ($roster_list as $row) {
        echo "<tr>";
        echo "<td>" . $row[0] . "</td>";
        echo "<td>" . $row[1] . "</td>";
        echo "</tr>";
    }

    echo "<table>";
    ?>
    </table>
    <?php
}

if (isset($_POST["results"])) {
    ?>
    <form action="instructor.php" method="post">
    <label for="course_IDS">Course ID:</label>
    <input type="text" id="course_IDS" name="course_IDS"><br>
    <input type="submit" value="See Survey Results" name="find_ID"><br>
    </form>
    <?php
}

if (isset($_POST["course_IDS"])) {
    $id = $_POST["course_IDS"];
    $list = get_survey_results($id);
    print_debug($list);
    ?>

    <table id="lista">
    <tr>
    <th>Course ID</th>
    <th>Question Number</th>
    <th>Answer</th>
    </tr>
    

    <?php
    foreach ($list as $row) {
        echo "<tr>";
        echo "<td>" . $row[0] . "</td>";
        echo "<td>" . $row[1] . "</td>";
        echo "<td>" . $row[2] . "</td>";
        echo "</tr>";
    }

    echo "<table>";
    ?>
    </table>
    <?php
}
?>