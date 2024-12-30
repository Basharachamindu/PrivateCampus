-- Create the database
CREATE DATABASE IF NOT EXISTS private_university;

-- Use the database
USE private_university;

-- Create the users table for login
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password CHAR(32) NOT NULL, -- Store MD5 hashed passwords
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert an example user (password: "password" hashed using MD5)
INSERT INTO users (username, password)
VALUES ('admin', MD5('password'));

-- Create the students table for student details
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nic VARCHAR(20) NOT NULL UNIQUE,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    tel VARCHAR(15) NOT NULL,
    course VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert sample data into the students table
INSERT INTO students (nic, name, address, tel, course)
VALUES 
    ('982345678V', 'John Doe', '123 Main St, Cityville', '0712345678', 'Computer Science'),
    ('972456789V', 'Jane Smith', '456 Elm St, Townsville', '0776543210', 'Information Technology');
