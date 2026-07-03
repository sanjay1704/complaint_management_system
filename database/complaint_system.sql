-- ==========================================
-- Complaint Management System Database
-- ==========================================

CREATE DATABASE IF NOT EXISTS complaint_management_system;

USE complaint_management_system;

-- ==========================================
-- USERS TABLE
-- ==========================================

CREATE TABLE users (

    id INT AUTO_INCREMENT PRIMARY KEY,

    full_name VARCHAR(100) NOT NULL,

    email VARCHAR(100) NOT NULL UNIQUE,

    phone VARCHAR(15) NOT NULL,

    password VARCHAR(255) NOT NULL,

    role ENUM('admin','user') DEFAULT 'user',

    status ENUM('Active','Inactive') DEFAULT 'Active',

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

);

-- ==========================================
-- COMPLAINTS TABLE
-- ==========================================

CREATE TABLE complaints (

    id INT AUTO_INCREMENT PRIMARY KEY,

    user_id INT NOT NULL,

    title VARCHAR(255) NOT NULL,

    category VARCHAR(100) NOT NULL,

    priority ENUM('Low','Medium','High') DEFAULT 'Medium',

    description TEXT NOT NULL,

    attachment VARCHAR(255),

    status ENUM(
        'Pending',
        'In Progress',
        'Resolved',
        'Rejected'
    ) DEFAULT 'Pending',

    admin_remarks TEXT,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id)
    REFERENCES users(id)
    ON DELETE CASCADE

);

-- ==========================================
-- COMPLAINT LOGS TABLE
-- ==========================================

CREATE TABLE complaint_logs (

    id INT AUTO_INCREMENT PRIMARY KEY,

    complaint_id INT NOT NULL,

    status ENUM(
        'Pending',
        'In Progress',
        'Resolved',
        'Rejected'
    ) NOT NULL,

    remarks TEXT,

    updated_by INT NOT NULL,

    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (complaint_id)
    REFERENCES complaints(id)
    ON DELETE CASCADE,

    FOREIGN KEY (updated_by)
    REFERENCES users(id)
    ON DELETE CASCADE

);

-- ==========================================
-- SETTINGS TABLE
-- ==========================================

CREATE TABLE settings (

    id INT AUTO_INCREMENT PRIMARY KEY,

    app_name VARCHAR(100),

    organization_name VARCHAR(100),

    support_email VARCHAR(100),

    support_phone VARCHAR(20),

    default_status VARCHAR(50),

    about_system TEXT

);

-- ==========================================
-- DEFAULT SETTINGS
-- ==========================================

INSERT INTO settings(

app_name,
organization_name,
support_email,
support_phone,
default_status,
about_system

)

VALUES(

'Complaint Management System',
'ABC Organization',
'support@example.com',
'+91 9876543210',
'Pending',
'Complaint Management System helps users register, track and manage complaints.'

);

-- ==========================================
-- DEFAULT ADMIN ACCOUNT
-- ==========================================

INSERT INTO users(

full_name,
email,
phone,
password,
role,
status

)

VALUES(

'Administrator',
'admin@gmail.com',
'9999999999',

'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

'admin',
'Active'

);

-- ==========================================
-- SAMPLE USER
-- ==========================================

INSERT INTO users(

full_name,
email,
phone,
password,
role,
status

)

VALUES(

'John Doe',
'john@gmail.com',
'9876543210',

'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',

'user',
'Active'

);