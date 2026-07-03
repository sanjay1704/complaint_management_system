USE complaint_management_system;

-- ==========================================
-- SAMPLE USERS
-- ==========================================

INSERT INTO users
(full_name, email, phone, password, role, status)
VALUES
('John Doe', 'john@gmail.com', '9876543210', 'password', 'user', 'Active'),

('Alice Smith', 'alice@gmail.com', '9876543211', 'password', 'user', 'Active'),

('Robert Johnson', 'robert@gmail.com', '9876543212', 'password', 'user', 'Active'),

('David Wilson', 'david@gmail.com', '9876543213', 'password', 'user', 'Inactive'),

('Administrator', 'admin@gmail.com', '9999999999', 'password', 'admin', 'Active');



-- ==========================================
-- SAMPLE COMPLAINTS
-- ==========================================

INSERT INTO complaints
(user_id, title, category, priority, description, attachment, status, admin_remarks)
VALUES

(1,
'Internet Connection Issue',
'Network',
'High',
'Internet is not working properly in hostel.',
'internet_issue.jpg',
'Pending',
'Waiting for assignment'),

(2,
'Water Leakage',
'Maintenance',
'Medium',
'Water leakage in Block A bathroom.',
'water_leakage.jpg',
'In Progress',
'Maintenance team assigned'),

(3,
'Electricity Failure',
'Electrical',
'High',
'No power supply in Lab 3.',
'electrical.pdf',
'Resolved',
'Problem fixed'),

(4,
'Hostel Cleaning',
'Cleaning',
'Low',
'Cleaning required in hostel corridor.',
'cleaning.jpg',
'Rejected',
'Insufficient details'),

(1,
'Transport Delay',
'Transport',
'Medium',
'College bus arrived late.',
'transport.pdf',
'Pending',
'Under review');



-- ==========================================
-- SAMPLE COMPLAINT LOGS
-- ==========================================

INSERT INTO complaint_logs
(complaint_id, status, remarks, updated_by)
VALUES

(1,
'Pending',
'Complaint Created',
5),

(2,
'In Progress',
'Assigned to Maintenance Team',
5),

(3,
'Resolved',
'Issue Resolved Successfully',
5),

(4,
'Rejected',
'Complaint Rejected due to insufficient details',
5),

(5,
'Pending',
'Complaint Submitted',
5);



-- ==========================================
-- SAMPLE SETTINGS
-- ==========================================

INSERT INTO settings
(app_name,
organization_name,
support_email,
support_phone,
default_status,
about_system)

VALUES

(
'Complaint Management System',
'ABC Organization',
'support@abc.com',
'+91 9876543210',
'Pending',
'Complaint Management System developed using HTML, CSS, PHP and MySQL.'
);