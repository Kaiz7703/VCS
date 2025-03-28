CREATE TABLE nguoidung(
    id int AUTO_INCREMENT PRIMARY KEY,
    tendangnhap varchar(50),
    hoten varchar(50),
    matkhau varchar(50),
    email varchar(50),
    sodienthoai varchar(50),
    role varchar(50),
    Image varchar(100)
);

INSERT INTO nguoidung(tendangnhap,hoten,matkhau,email,sodienthoai,role) VALUES ('hvt','Thai','hvt','hvt@gmail.com','0879102003','sinhvien'),
('student1','Hoang Van Thai','123456a@A','student1@gmail.com','0123456789','sinhvien'),
('student2','Le Duc Anh','123456a@A','student2@gmail.com','0123456789','sinhvien'),
('tvc','Tran Van Chinh','123456a@A','tvc@gmail.com','0123456789','sinhvien'),
('nda','Nguyen Duc Anh','123456a@A','nda@gmail.com','0123456789','sinhvien'),
('phd','Pham Hai Duong','123456a@A','phd@gmail.com','0123456789','sinhvien'),
('ntl','Nguyen Thanh Long','123456a@A','ntl@gmail.com','0123456789','sinhvien'),
('nmn','Nguyen Minh Nghia','123456a@A','nmn@gmail.com','0123456789','sinhvien'),
('lta','Le Tuan Anh','123456a@A','lta@gmail.com','0123456789','sinhvien'),
('teacher1','Nguyen Van A','123456a@A','teacher1@gmail.com','0123456789','giaovien'),
('teacher2','Nguyen Van B','123456a@A','teacher2@gmail.com','0123456789','giaovien');

create table tinnhan(
receiver_id int,
sender_id int,
msg text,
primary key(receiver_id,sender_id),
foreign key(receiver_id) references nguoidung(id),
foreign key(sender_id) references nguoidung(id)
);

create table baitap(
task_id int auto_increment,
filename varchar(50),
primary key(task_id)
);

create table bailam(
solve_id int AUTO_INCREMENT,
task_id int,
student_id int,
filename varchar(50),
primary key(solve_id),
foreign key(task_id) references baitap(task_id),
foreign key(student_id) references nguoidung(id)
);

create table challenge(
cid int AUTO_INCREMENT,
cname varchar(50),
hint text,
primary key (cid)
);
