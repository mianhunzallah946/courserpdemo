<?php
/**
 * student_dashboard.php - Student Dashboard Endpoint
 * Validates student access and directs to the unified dashboard view.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role'])) {
    header("Location: ./login.php");
    exit();
}

if ($_SESSION['role'] !== 'student') {
    header("Location: ./dashboard.php");
    exit();
}

// Direct to standardized dashboard
header("Location: ./dashboard.php");
exit();

