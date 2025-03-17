CREATE DATABASE IF NOT EXISTS class_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE class_management;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(15) NULL,
    avatar VARCHAR(255) DEFAULT 'default.png',
    role ENUM('teacher', 'student') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng tin nhắn giữa người dùng
CREATE TABLE messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (receiver_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Bảng bài tập giáo viên giao
CREATE TABLE assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Bảng bài làm sinh viên nộp
CREATE TABLE submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    assignment_id INT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (student_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (assignment_id) REFERENCES assignments(id) ON DELETE CASCADE
);

-- Bảng trò chơi giải đố của giáo viên
CREATE TABLE challenges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    teacher_id INT NOT NULL,
    hint TEXT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (teacher_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Thêm tài khoản mẫu
INSERT INTO users (username, password, full_name, email, phone, role) VALUES
('teacher1', MD5('password123'), 'Giáo viên A', 'teacher1@example.com', '0123456789', 'teacher'),
('student1', MD5('password123'), 'Sinh viên B', 'student1@example.com', '0987654321', 'student');

-- Thêm bài tập mẫu
INSERT INTO assignments (teacher_id, title, file_path) VALUES
(1, 'Bài tập 1 - Lập trình PHP', 'uploads/assignments/baitap1.pdf');

-- Thêm thử thách mẫu
INSERT INTO challenges (teacher_id, hint, file_path) VALUES
(1, 'Bài thơ về mùa xuân', 'uploads/challenges/mua_xuan.txt');