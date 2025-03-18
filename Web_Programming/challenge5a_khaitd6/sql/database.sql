USE student_management;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    phone VARCHAR(20),
    avatar VARCHAR(255),
    role ENUM('teacher', 'student') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    from_user_id INT,
    to_user_id INT,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (from_user_id) REFERENCES users(id),
    FOREIGN KEY (to_user_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    file_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS submissions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    assignment_id INT,
    student_id INT,
    file_path VARCHAR(255) NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (assignment_id) REFERENCES assignments(id),
    FOREIGN KEY (student_id) REFERENCES users(id)
);

CREATE TABLE IF NOT EXISTS challenges (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    hint TEXT NOT NULL,
    file_path VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample teacher account
INSERT INTO users (username, password, fullname, email, phone, role) VALUES 
('teacher', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sample Teacher', 'teacher@example.com', '0123456789', 'teacher');

-- Insert sample student account
INSERT INTO users (username, password, fullname, email, phone, role) VALUES 
('student', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Sample Student', 'student@example.com', '0987654321', 'student');

-- Insert sample teacher accounts
INSERT INTO users (username, password, fullname, email, phone, role) VALUES 
('teacher1', '$2y$10$Z.yIz/PCmxNelP5X0VtC9O7eVRmKb4kPY0A5PAjH8k0/yCtRgGqIm', 'Teacher One', 'teacher1@example.com', '0123456789', 'teacher'),
('teacher2', '$2y$10$Z.yIz/PCmxNelP5X0VtC9O7eVRmKb4kPY0A5PAjH8k0/yCtRgGqIm', 'Teacher Two', 'teacher2@example.com', '0123456788', 'teacher');

-- Insert sample student accounts
INSERT INTO users (username, password, fullname, email, phone, role) VALUES 
('student1', '$2y$10$Z.yIz/PCmxNelP5X0VtC9O7eVRmKb4kPY0A5PAjH8k0/yCtRgGqIm', 'Student One', 'student1@example.com', '0987654321', 'student'),
('student2', '$2y$10$Z.yIz/PCmxNelP5X0VtC9O7eVRmKb4kPY0A5PAjH8k0/yCtRgGqIm', 'Student Two', 'student2@example.com', '0987654322', 'student');
