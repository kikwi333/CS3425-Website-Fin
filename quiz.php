<?php
require "db.php";
session_start();
echo "<pre>";
print_r($_SESSION); 
print_r($_POST);
echo "</pre>";

// function print_debug($var) {
//     echo "<br>DEBUGGING INFORMATION";
//     echo "<pre>";
//     print_r($var);
//     echo "</pre>";
//     echo "<br>";
// }

$NUMQUESTION = num_question();
$QUESTIONS = questions();

?>

<html>
<form action="quiz.php" method="post">
    <?php
        for ($i = 0; $i < $NUMQUESTION[0][0]; $i++) {
            $num = $QUESTIONS[$i][0];
            $quest = $QUESTIONS[$i][1];
            $qType = $QUESTIONS[$i][2];

            echo "$num.) $quest<br>";

            if ($qType == "essay")
            {   
                //echo "name: $num<br>";
                ?>
                <textarea name="<?php echo $num; ?>" rows="4" cols="50"></textarea><br><br>
                <?php
                
            }
            else {
                $multNum = num_multiple_choice($num);
                $multAns = multiple_choice_answers($num);
                //print_debug($multAns);
                //echo "name: $num<br>";
                for ($j = 0; $j < $multNum[0][0]; $j++) {
                    ?>
                    <input type="radio" name="<?php echo $num; ?>" value="<?php echo $multAns[$j][0];?>">
                    <label for="<?php echo $num; ?>"><?php echo $multAns[$j][0];?><br>
                    <?php
                }
                echo "<br>";
                
            }
        }
        ?>
    <input type="submit" name="Turn_In_Eval" value="Turn In Evaluation">
</form>
</html>

<?php

if (isset($_POST["Take_Evaluation"])) {
    $_SESSION["eval_course_id"] = $_POST["course_evals"];
}

if (isset($_POST["Turn_In_Eval"])) {
    $isComplete = true;

    //Check for survey completion
    for ($l = 0; $l < $NUMQUESTION[0][0]; $l++) {
        $num = $QUESTIONS[$l][0];
        $qType = $QUESTIONS[$l][2];

        if ($qType == "essay")
        {   
            if ($_POST[$num] == "") {
                $isComplete = false;
            }
        }
        else {
            if (!isset($_POST[$num])) {
                $isComplete = false;
            }
        }
    }

    //If survey is complete, mark the survey as done and update survey results
    //Otherwise, print error
    if ($isComplete) {
        $answers = array_fill(0, $NUMQUESTION[0][0], "0");
        //print_debug($answers);

        for ($k = 0; $k < $NUMQUESTION[0][0]; $k++) {
            $num = $QUESTIONS[$k][0];
            update_survey_results($_SESSION["eval_course_id"], $_SESSION["username"], $num, $_POST[$num]);
        }
    
        set_survey_complete($_SESSION["username"], $_SESSION["eval_course_id"]);
        header("Location:main.php");
        exit();
    //print_r($answers);
    } else {
        echo '<p style="color:red">Must complete all questions!</p>';
    }

    
}
?>