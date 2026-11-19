<?php
/**
 * login_demo.php - Backend Handler for One-Click Demo Login
 * CourseERP Demo Access System
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("./connection.php");

// 1. Strict Whitelist Validation for Demo Roles
$allowed_roles = ['admin', 'student'];
$role = isset($_GET['role']) ? strtolower(trim($_GET['role'])) : '';

if (!in_array($role, $allowed_roles, true)) {
    header("Location: ./login.php?error=invalid_demo_role");
    exit();
}

// 2. Clear old session data and regenerate session ID to avoid fixation
session_unset();
session_regenerate_id(true);

// 3. Resolve Sample Course for Demo Student Experience (if courses exist)
$sampleCourse = 'Full Stack Web Development';
if (isset($connec) && $connec) {
    $courseQuery = mysqli_query($connec, "SELECT title FROM course LIMIT 1");
    if ($courseQuery && mysqli_num_rows($courseQuery) > 0) {
        $cRow = mysqli_fetch_assoc($courseQuery);
        if (!empty($cRow['title'])) {
            $sampleCourse = $cRow['title'];
        }
    }
}

// 4. Initialize Demo Session State
$_SESSION['is_demo']     = true;
$_SESSION['role']        = $role;
$_SESSION['user_id']     = ($role === 'admin') ? 999991 : 999992;
$_SESSION['email']       = ($role === 'admin') ? 'demo.admin@courseerp.com' : 'demo.student@courseerp.com';
$_SESSION['user_name']   = ($role === 'admin') ? 'Demo Administrator' : 'Demo Student';
$_SESSION['name']        = $_SESSION['user_name'];
$_SESSION['fname']       = 'Demo';
$_SESSION['lname']       = ($role === 'admin') ? 'Admin' : 'Student';
$_SESSION['membership']  = 'paid'; // Grants full preview access to curriculum and videos
$_SESSION['course_name'] = $sampleCourse;
$_SESSION['demo_notice'] = "🎉 Welcome! Logged in as Demo " . ucfirst($role) . ". You are in safe Read-Only mode. All database mutations are restricted.";

// 5. Redirect straight to the respective dashboard
if ($role === 'admin') {
    header("Location: ./admin_dashboard.php");
    exit();
} else {
    header("Location: ./student_dashboard.php");
    exit();
}

