delimiter //
create procedure create_student (in student_name varchar(255), student_account varchar(255), student_password varchar(255))
begin
insert into student (name, account, password)
values (student_name, student_account, sha2(student_password,256));
end//
delimiter ;

delimiter //
create procedure create_instructor (in instructor_name varchar(255), instructor_account varchar(255), instructor_password varchar(255))
begin
insert into instructor (name, account, password)
values (instructor_name, instructor_account, sha2(instructor_password,256));
end//
delimiter ;

delimiter //
create procedure create_course(in course_id int, course_title varchar(255), course_credit int, course_desc blob)
begin
insert into course (ID, title, credit, description)
values (course_id, course_title, course_credit, course_desc);
end//
delimiter ;

delimiter //
create procedure assign_instruct(in name varchar(255), ID int)
begin 
insert into teaches (instructor_name, course_id)
values (name, ID);
end//
delimiter ;

delimiter //
create procedure create_essay(in quest_num int, q blob, question_type varchar(255))
begin 
insert into evaluation (question_num, question, q_type)
values (quest_num, q, question_type);
end//
delimiter ;

delimiter //
create procedure create_mult(in quest_num int, a varchar(255), b varchar(255), c varchar(255), d varchar(255), q blob, question_type varchar(255), mult_a varchar(10))
begin
insert into evaluation (question_num, mult_a, mult_b, mult_c, mult_d, question, q_type, mult_answer)
values (quest_num, a, b, c, d, q, question_type, mult_a);
end//
delimiter ;

delimiter //
create procedure insert_multi_choice(in quest_num int, multi_choice varchar(255))
begin
insert into multi_question
values(quest_num, multi_choice);
end//
delimiter ;

