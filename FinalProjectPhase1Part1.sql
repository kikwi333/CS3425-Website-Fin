CREATE TABLE student (
    name VARCHAR(255) PRIMARY KEY,
    account VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);
 
CREATE TABLE instructor (
    name VARCHAR(255) PRIMARY KEY,
    account VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE course (
    ID INT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    credit INT NOT NULL,
    description BLOB
);

CREATE TABLE register (
    student_name VARCHAR(255),
    course_ID INT,
    FOREIGN KEY (student_name)
        REFERENCES student (name),
    FOREIGN KEY (course_id)
        REFERENCES course (ID)
);
 
CREATE TABLE teaches (
    instructor_name VARCHAR(255),
    course_ID INT,
    FOREIGN KEY (instructor_name)
        REFERENCES instructor (name),
    FOREIGN KEY (course_ID)
        REFERENCES course (ID)
);
 
CREATE TABLE evaluation (
    question_num INT PRIMARY KEY,
    mult_a VARCHAR(255),
    mult_b VARCHAR(255),
    mult_c VARCHAR(255),
    mult_d VARCHAR(255),
    q_type VARCHAR(255) NOT NULL,
    essay_answer BLOB,
    mult_answer VARCHAR(10),
    question VARCHAR(255) NOT NULL
);
 
CREATE TABLE takes (
    student_name VARCHAR(255),
    question_num INT,
    date_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (question_num)
        REFERENCES evaluation (question_num),
    FOREIGN KEY (student_name)
        REFERENCES student (name)
);
 
 
 
 
 
 
 
 