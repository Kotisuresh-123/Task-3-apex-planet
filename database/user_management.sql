CREATE DATABASE IF NOT EXISTS user_management_system;
USE user_management_system;

-- Roles Table
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(20) NOT NULL UNIQUE
);

-- Users Table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,

    full_name VARCHAR(100) NOT NULL,

    username VARCHAR(50) NOT NULL UNIQUE,

    email VARCHAR(100) NOT NULL UNIQUE,

    mobile VARCHAR(15) NOT NULL,

    password VARCHAR(255) NOT NULL,

    role_id INT NOT NULL DEFAULT 2,

    profile_picture VARCHAR(255) DEFAULT 'default.png',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (role_id)
    REFERENCES roles(id)
    ON DELETE RESTRICT
);

-- Default Roles
INSERT INTO roles(role_name)
VALUES
('Admin'),
('User');