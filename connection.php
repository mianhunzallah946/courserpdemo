<?php
/**
 * ============================================================================
 * CourseERP - Database Connection & Environment Configuration
 * Compatible with: Localhost (XAMPP), InfinityFree, Wasmer, cPanel & Cloud Hosting
 * ============================================================================
 */

// 1. Output Buffering to prevent "headers already sent" on live web hosts
if (!ob_get_level()) {
    ob_start();
}

// 2. Safe Session Initialization
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 3. Database Credentials Configuration
// ----------------------------------------------------------------------------
// For InfinityFree:
// In your InfinityFree Client Area -> Manage -> Database Details:
// - MySQL Host Name : e.g. sql100.infinityfree.com (NEVER use 'localhost' on InfinityFree!)
// - MySQL User Name : e.g. if0_12345678
// - MySQL Password  : Your hosting account / vPanel password
// - MySQL Database  : e.g. if0_12345678_course
// ----------------------------------------------------------------------------

$DB_HOST = 'localhost';
$DB_USER = 'root';
$DB_PASS = '';
$DB_NAME = 'course';
$DB_PORT = 3306;

// Check for Environment Variables (Wasmer, Railway, Heroku, Docker, etc.)
if (getenv('DB_HOST') || getenv('MYSQLHOST')) {
    $DB_HOST = getenv('DB_HOST') ?: getenv('MYSQLHOST');
    $DB_USER = getenv('DB_USER') ?: getenv('MYSQLUSER') ?: 'root';
    $DB_PASS = getenv('DB_PASS') ?: getenv('MYSQLPASSWORD') ?: '';
    $DB_NAME = getenv('DB_NAME') ?: getenv('MYSQLDATABASE') ?: 'course';
    $DB_PORT = getenv('DB_PORT') ?: getenv('MYSQLPORT') ?: 3306;
}

// Check for local credentials override (config.local.php) if present
if (file_exists(__DIR__ . '/config.local.php')) {
    include_once(__DIR__ . '/config.local.php');
}

// 4. Connect to MySQL Database (Error-Suppressed for Graceful Error Handling)
$connec = @mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, (int)$DB_PORT);

$db_connected = ($connec !== false);
$db_error = $db_connected ? null : mysqli_connect_error();

if ($db_connected) {
    mysqli_set_charset($connec, "utf8mb4");
}

/**
 * Helper function: Safely execute queries with fallback if database is offline
 */
if (!function_exists('safe_query')) {
    function safe_query($sql) {
        global $connec;
        if (!$connec) {
            return false;
        }
        return mysqli_query($connec, $sql);
    }
}
