# 🔐 Role-Based User Management System

A secure and dynamic **User Management System** developed using **PHP** and **MySQL** as part of **Task 3: Backend Development & Database Integration** during the Full Stack Development Internship at Apex Planet.

The project demonstrates backend development concepts including authentication, authorization, CRUD operations, session management, and database design.

---

## 🚀 Features

### 👨‍💼 Admin Features
- View all registered users.
- Add new users.
- Edit existing user details.
- Delete users from the system.
- Manage user roles and permissions.
- Restrict access to sensitive administrative actions.

### 👤 User Features
- Secure login and logout functionality.
- Access only to authorized pages.
- Cannot view other users' information.
- Cannot perform administrative operations.

### 🔒 Security Features
- Password hashing using `password_hash()`.
- Session-based authentication.
- Role-Based Access Control (RBAC).
- Server-side validation.
- SQL Injection prevention using prepared statements.
- Access restriction for unauthorized users.

---

## 🛠 Technologies Used

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript
- Bootstrap
- XAMPP Server

---

## 🗄 Database Structure

The application uses two normalized database tables:

### 1️⃣ Roles Table
Stores the available roles in the system.

| Column Name | Type |
|------------|------|
| role_id | INT |
| role_name | VARCHAR |

Example:
- Admin
- User

### 2️⃣ Users Table
Stores user information and role assignments.

| Column Name | Type |
|------------|------|
| user_id | INT |
| username | VARCHAR |
| email | VARCHAR |
| password | VARCHAR |
| role_id | INT |

Relationship:
- One role can belong to multiple users.
- Each user is assigned exactly one role.

---

## 🔑 Authentication & Authorization

The system implements a role-based authentication mechanism:

### Admin Permissions
✅ View all users  
✅ Add users  
✅ Edit users  
✅ Delete users  

### User Permissions
✅ Login and access user dashboard  
❌ View all users  
❌ Add users  
❌ Edit users  
❌ Delete users  

### Additional Security Rule
To maintain administrative integrity:

- An administrator **cannot edit, delete, or modify another administrator account**.
- Only non-admin users can be managed by administrators.

---

## 📂 Project Structure

```text
project/
│
├── config/
│   └── database.php
│
├── uploads/
|
├── auth/
│   ├── login.php
│   ├── register.php
│   └── logout.php
│
├── users/
│   ├── view_users.php
│   ├── add_user.php
│   ├── edit_user.php
│   └── delete_user.php
|
├── includes/
│   ├── footer.php
│   ├── header.php
│   └── sidebar.php
│
├── profile/
|   ├── edit_profile.php
│   └── profile.php
│   
├── database/
|   └── user_management.sql
|
├── assets/
│   ├── css/
│   ├── js/
│   └── images/
│
└── database.sql
└── dashboard.php
└── index.php
```

---

## ⚙️ Installation Guide

### Clone the repository

```bash
git clone https://github.com/yourusername/role-based-user-management.git
```

### Move the project to XAMPP htdocs folder

```text
C:\xampp\htdocs\
```

### Create a MySQL database

```text
user_management_system
```

### Import the SQL file

Import `database.sql` into phpMyAdmin.

### Configure database connection

Update your database credentials in:

```php
config/database.php
```

```php
$host = "localhost";
$username = "root";
$password = "";
$database = "user_management_system";
```

### Start Apache and MySQL

Open your browser and run:

```text
http://localhost/role-based-user-management
```

---

## 📸 Screenshots

### Login Page
(Add Screenshot)

### Admin Dashboard
(Add Screenshot)

### User Dashboard
(Add Screenshot)

### User Management Page
(Add Screenshot)

---

## 🎯 Learning Outcomes

Through this project, I gained hands-on experience in:

- Backend Development using PHP
- Database Design and Normalization
- CRUD Operations
- Session Management
- Authentication and Authorization
- Role-Based Access Control (RBAC)
- Web Application Security

---

## 📹 Demo Video

LinkedIn Demo Video:

(Add LinkedIn Video Link Here)

---

## 👨‍💻 Author

**K.Koti Suresh**

- LinkedIn: https://www.linkedin.com/in/koti-suresh-kommu-a26403339/
- GitHub: https://github.com/Kotisuresh-123

---

## 📜 License

This project is developed for educational and internship purposes under the Apex Planet Full Stack Development Internship Program.

---

## ⭐ Support

If you found this project useful, consider giving it a ⭐ on GitHub!
