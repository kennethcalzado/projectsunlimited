<?php
function logAudit($user_id, $fname, $lname, $role_id, $action)
{
    include 'conn.php';

    // Prepare and execute an SQL INSERT statement to log the audit entry
    $sql = "INSERT INTO auditlogs (user_id, fname, lname, role_id, action) VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issss", $user_id, $fname, $lname, $role_id, $action);
    $stmt->execute();

    // Close the database connection
    $stmt->close();
}
