<?php
function connectDB()
{
    $config = parse_ini_file("db.ini");
    $dbh = new PDO($config['dsn'], $config['username'], $config['password']);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $dbh;
}
//return number of rows matching the given user and passwd. 
function authStudent($user, $passwd) {
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare("SELECT count(*) FROM student ".
                                   "where account = :account and password = sha2(:passwd,256) ");
        $statement->bindParam(":account", $user);
        $statement->bindParam(":passwd", $passwd);
        $result = $statement->execute();
        $row=$statement->fetch();
        $dbh=null;

        return $row[0];
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

function authInstruct($user, $passwd) {
    try {
        $dbh = connectDB();
        $statement = $dbh->prepare("SELECT count(*) FROM instructor ".
                                   "where account = :account and password = sha2(:passwd,256) ");
        $statement->bindParam(":account", $user);
        $statement->bindParam(":passwd", $passwd);
        $result = $statement->execute();
        $row=$statement->fetch();
        $dbh=null;

        return $row[0];
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

//find student's username in database
//return true if found
//false otherwise
function get_stu_accounts($user)
{
    //connect to database
    //retrieve the data and display
    try {
        $dbh = connectDB();

        $statement = $dbh->prepare("SELECT account FROM student WHERE account = :account");
        $statement->bindParam(":account", $user);
        $statement->execute();
        $username = $statement->fetchAll();
        echo '<pre>';
        print_r($username[0][0]);
        print_r($user);
        echo '</pre>';
        if (strcmp($username[0][0], $user) == 0) {
            echo "true";
            return true;
        } else {
            echo "false";
            return false;
        }

        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

//find instructor's username in database
//return true if found
//false otherwise
function get_instruct_accounts($user)
{
    //connect to database
    //retrieve the data and display
    try {
        $dbh = connectDB();

        $statement = $dbh->prepare("SELECT account FROM instructor WHERE account = :account");
        $statement->bindParam(":account", $user);
        $statement->execute();
        $username = $statement->fetchAll();
        echo '<pre>';
        print_r($username[0][0]);
        print_r($user);
        echo '</pre>';
        if (strcmp($username[0][0], $user) == 0) {
            echo "true";
            return true;
        } else {
            echo "false";
            return false;
        }

        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

function set_student_password($user, $passwd) 
{
    //connect to database
    //retrieve the data and display
    try {
        $dbh = connectDB();

        $statement = $dbh->prepare("UPDATE student SET password = sha2(:passwd,256) WHERE account = :account");
        $statement->bindParam(":account", $user);
        $statement->bindParam(":passwd", $passwd);
        $statement->execute();

        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

function set_instruct_password($user, $passwd) 
{
    //connect to database
    //retrieve the data and display
    try {
        $dbh = connectDB();

        $statement = $dbh->prepare("UPDATE instructor SET password = sha2(:passwd,256) WHERE account = :account");
        $statement->bindParam(":account", $user);
        $statement->bindParam(":passwd", $passwd);
        $statement->execute();
        
        $dbh = null;
    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

function get_courses()
{
    $dbh = connectDB();

    
    $statement = $dbh->prepare("SELECT * FROM course");
    $statement->execute();
    $row = $statement->fetchAll();
    return $row;

    $dbh = null;
}

function register($account, $course_ID)
{
    $dbh = connectDB();

    $statement = $dbh->prepare("INSERT INTO register (student_account, course_ID) VALUES (:account, :ID)");
    $statement->bindParam(":account", $account);
    $statement->bindParam(":ID", $course_ID);
    $statement->execute();
    $result = registered_courses($account);

    return $result;
    $dbh = null;
}

function registered_courses($account)
{
    $dbh = connectDB();

    $statement = $dbh->prepare("SELECT course_ID, (SELECT title FROM course WHERE course_ID=ID) AS title FROM register WHERE student_account = :account");
    $statement->bindParam(":account", $account);
    $statement->execute();
    $result = $statement->fetchAll();

    return $result;
    $dbh = null;
}

function get_roster($unga)
{
    try {
        
        $dbh = connectDB();

        $statement = $dbh->prepare("SELECT student_account, (SELECT name FROM student WHERE account=student_account) AS name FROM register WHERE course_ID = :bunga");
        //$statement = $dbh->prepare("SELECT * FROM register WHERE course_ID = :bunga");
        $statement->bindValue(":bunga", $unga);
        $statement->execute();
        $stu_acc = $statement->fetchAll();

        return $stu_acc;

        $dbh = null;

    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}


function get_eval_stat($user)
{
    try {
        $dbh = connectDB();
        
        $statement = $dbh->prepare("SELECT course_ID, survey_done FROM register WHERE student_account = :bunga");
        $statement->bindParam(":bunga", $user);
        $statement->execute();
        $result = $statement->fetchAll();
        
        return $result;

        $dbh = null;

    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

function num_question()
{
    try {
        $dbh = connectDB();
        
        $statement = $dbh->prepare("SELECT COUNT(*) FROM evaluation");
        $statement->execute();
        $result = $statement->fetch();
        
        return $result;

        $dbh = null;

    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

function num_class_taken($username)
{
    try {
        $dbh = connectDB();
        
        $statement = $dbh->prepare("SELECT COUNT(survey_done) FROM register WHERE student_account = :bunga AND survey_done = 0");
        //$statement = $dbh->prepare("SELECT count(course_ID) FROM register WHERE survey_done = 0");
        $statement->bindParam(":bunga", $username);
        $statement->execute();
        $result = $statement->fetchAll();
        
        return $result;

        $dbh = null;

    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

function questions()
{
    try {
        $dbh = connectDB();
        
        $statement = $dbh->prepare("SELECT question_num, question, q_type FROM evaluation");
        $statement->execute();
        $result = $statement->fetchAll();
        
        return $result;

        $dbh = null;

    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

function num_multiple_choice($NUM)
{
    try {
        $dbh = connectDB();
        
        $statement = $dbh->prepare("SELECT COUNT(question_ID) FROM multi_question WHERE question_ID=:bunga");
        $statement->bindParam(":bunga", $NUM);
        $statement->execute();
        $result = $statement->fetchAll();
        
        return $result;

        $dbh = null;

    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

function multiple_choice_answers($questNum)
{
    try {
        $dbh = connectDB();
        
        $statement = $dbh->prepare("SELECT answers FROM multi_question WHERE question_ID=:bunga");
        $statement->bindParam(":bunga", $questNum);
        $statement->execute();
        $result = $statement->fetchAll();
        
        return $result;

        $dbh = null;

    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

function get_survey_results($class)
{
    try {
        $dbh = connectDB();
        
        $statement = $dbh->prepare("SELECT course_ID, question_num, answer FROM survey WHERE course_ID=:bunga");
        $statement->bindParam(":bunga", $class);
        $statement->execute();
        $result = $statement->fetchAll();
        
        return $result;

        $dbh = null;

    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

function set_survey_complete($stuAcc, $cID)
{
    try {
        $dbh = connectDB();
        
        $statement = $dbh->prepare("UPDATE register SET survey_done = true WHERE student_account = :zunga AND course_ID = :tunga");
        $statement->bindParam(":zunga", $stuAcc);
        $statement->bindParam(":tunga", $cID);
        $statement->execute();

        $dbh = null;

    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
    
}

function update_survey_results($cID, $stuAcc, $qNum, $qAns)
{
    try {
        $dbh = connectDB();
        
        $statement = $dbh->prepare("INSERT INTO survey (course_ID, student_account, question_num, answer) VALUES (:unga, :bunga, :zunga, :tunga)");
        $statement->bindParam(":unga", $cID);
        $statement->bindParam(":bunga", $stuAcc);
        $statement->bindParam(":zunga", $qNum);
        $statement->bindParam(":tunga", $qAns);
        $statement->execute();

        $dbh = null;

    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}

function get_courseID($accName)
{
    try {
        $dbh = connectDB();
        
        $statement = $dbh->prepare("SELECT course_ID FROM register WHERE student_account=:bunga AND survey_done = false");
        $statement->bindParam(":bunga", $accName);
        $statement->execute();
        $result = $statement->fetchAll();
        
        return $result;

        $dbh = null;

    } catch (PDOException $e) {
        print "Error!" . $e->getMessage() . "<br/>";
        die();
    }
}


// function transfer($from, $to, $amount, $user)
// {
//     try {
//         $dbh = connectDB();
//         $dbh->beginTransaction();

//         // check if there are enough balance in the from account
//         $statement = $dbh->prepare("select balance from lab3_accounts where account_no=:from ");
//         $statement->bindParam(":from", $from);
//         $result = $statement->execute();
//         $row = $statement->fetch();
//         if ($row) {
//             $currentBalance = $row[0];
//             if ($currentBalance < $amount) {
//                 echo "Not enough balance in $from";
//                 $dbh->rollBack();
//                 $dbh=null;
//                 return;
//             }
//         } else {
//             echo "Account $from does not exist";
//             $dbh->rollBack();
//             $dbh=null;
//             return;
//         }

//         $statement = $dbh->prepare("update lab3_accounts set balance = balance - :amount " .
//             "where account_no=:from");
//         $statement->bindParam(":amount", $amount);
//         $statement->bindParam(":from", $from);
//         $result = $statement->execute();

//         $statement = $dbh->prepare("update lab3_accounts set balance = balance + :amount " .
//             "where account_no= :to");
//         $statement->bindParam(":amount", $amount);
//         $statement->bindParam(":to", $to);
//         $result = $statement->execute();
//         echo "Money has been transfered successfully";
//         $dbh->commit();
//     } catch (Exception $e) {
//         echo "Failed: " . $e->getMessage();
//         $dbh->rollBack();
//     }

//     $dbh=null;
// }

?>
