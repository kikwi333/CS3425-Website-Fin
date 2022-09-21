INSERT INTO student
VALUES("Ryo Nishihira", "rnishihi", sha2("rnishihi", 256)),
("Austin Mabee", "ammabee", sha2("ammabee", 256));

INSERT INTO instructor
VALUES("CS3425", "CS3425", sha2("CS3425", 256));

INSERT INTO course
VALUES(0, "CS3425 Intro to Database Systems", 3, "This course provides an introduction to database systems including database design, query, and programming. Topics include goals of database management; data definition; data models; data normalization; data retrieval and manipulation with relational algebra and SQL; data security and integrity; database and Web programming; and languages for representing semi-structured data.");

INSERT INTO student(name, account)
VALUES("Bob", "bob");

DELETE FROM student 
WHERE
    account = 'bob';

INSERT INTO instructor(name, account)
VALUES("Alice", "alice");

DELETE FROM instructor 
WHERE
    account = 'alice';

UPDATE instructor 
SET 
    password = SHA2('alice', 256)
WHERE
    account = 'alice';

INSERT INTO course
VALUES(1, "CS2311 - Discrete Structures", 3, "Presents fundamental concepts in discrete structures that are used in computer science. Topics include sets, trees, graphs, functions, relations, recurrences, proof techniques, logic, combinatorics, and probability.");

DELETE FROM register 
WHERE
    student_account = 'bob';
    
DELETE FROM register 
WHERE
    student_account = 'ben';
    
DELETE FROM register 
WHERE
    student_account = 'brook';

DELETE FROM register 
WHERE
    student_account = 'brian';

DELETE FROM register 
WHERE
    student_account = 'bethany';
    
DELETE FROM register 
WHERE
    student_account = 'jimmy';
    
DELETE FROM register
WHERE
	student_account = 'rnishihi';
    
INSERT INTO evaluation(question_num, question, q_type)
VALUES(1, "How many fries?", "essay"),
(2, "Which one is true?", "multi"),
(3, "How many?", "multi");

DELETE FROM evaluation 
WHERE
    question_num > 0;

DELETE FROM multi_question 
WHERE
    question_ID > 0;
    
DELETE FROM essay_question
WHERE
    question_ID > 0;

SELECT 
    COUNT(survey_done)
FROM
    register
WHERE
    student_account = 'bob';

INSERT INTO survey(course_ID, student_account, question_num, answer)
VALUES(1, "bob", 1, "No."),
(1, "bob", 2, "True"),
(1, "bob", 3, "Sample text");

DELETE FROM survey 
WHERE
    student_account = 'bob';
    
DELETE FROM survey 
WHERE
    student_account = 'brian';
    
DELETE FROM survey
WHERE
	student_account = 'ben';

DELETE FROM survey
WHERE
	student_account = 'bethany';
    
UPDATE student 
SET 
    password = SHA2("jimmy", 256)
WHERE
    account = 'jimmy';
    
UPDATE register 
SET 
    survey_done = FALSE
WHERE
    student_account = 'brian';

SELECT 
    student_account,
    (SELECT 
            name
        FROM
            student
        WHERE
            account = student_account) AS name
FROM
    register
WHERE
    course_ID = 1;
GRANT ALL PRIVILEGES ON rnishihi.* TO 'cs3425gr'@'%';