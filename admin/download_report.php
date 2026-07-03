<?php
require_once "../db_connect.php";

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="Complaint_Report.csv"');

$output = fopen("php://output", "w");

// Column Names
fputcsv($output, [
    "Complaint ID",
    "User",
    "Title",
    "Category",
    "Priority",
    "Status",
    "Created Date"
]);

$sql = "SELECT complaints.id,
               users.full_name,
               complaints.title,
               complaints.category,
               complaints.priority,
               complaints.status,
               complaints.created_at
        FROM complaints
        INNER JOIN users
        ON complaints.user_id = users.id
        ORDER BY complaints.created_at DESC";

$stmt = $conn->query($sql);

while($row = $stmt->fetch(PDO::FETCH_ASSOC))
{
    fputcsv($output, [
        $row['id'],
        $row['full_name'],
        $row['title'],
        $row['category'],
        $row['priority'],
        $row['status'],
        $row['created_at']
    ]);
}

fclose($output);
exit();
?>