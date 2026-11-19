<?php
/**
 * admin_dashboard.php - Admin Dashboard Endpoint
 * Validates admin access and directs to the unified dashboard view.
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role'])) {
    header("Location: ./login.php");
    exit();
}

if ($_SESSION['role'] !== 'admin') {
    header("Location: ./dashboard.php");
    exit();
}

// Direct to standardized dashboard
header("Location: ./dashboard.php");
exit();

