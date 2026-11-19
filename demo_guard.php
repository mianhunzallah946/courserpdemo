<?php
/**
 * demo_guard.php - Centralized Security Guard for Demo Mode
 * CourseERP Demo Access & Isolation Control
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Checks whether the current active session is a demo user.
 * 
 * @return bool True if logged in as demo, false otherwise.
 */
function is_demo_user(): bool {
    return !empty($_SESSION['is_demo']) && $_SESSION['is_demo'] === true;
}

/**
 * Intercepts and blocks destructive actions (INSERT, UPDATE, DELETE, file unlinks)
 * for demo sessions and redirects back with a descriptive warning notification.
 * 
 * @param string $fallbackUrl Fallback URL to redirect if referer is unavailable.
 * @param string $customMessage Custom warning message to display to the user.
 */
function block_demo_action(string $fallbackUrl = './dashboard.php', string $customMessage = ''): void {
    if (is_demo_user()) {
        $message = !empty($customMessage) 
            ? $customMessage 
            : "⚠️ Demo Mode: Action Restricted. Modifications, uploads, and deletions are disabled in demo mode.";
        
        $_SESSION['demo_notice'] = $message;

        // Use Referer if safe and available, otherwise fallback
        $target = $fallbackUrl;
        if (!empty($_SERVER['HTTP_REFERER'])) {
            $referer = $_SERVER['HTTP_REFERER'];
            $host = $_SERVER['HTTP_HOST'] ?? '';
            // Only redirect to local referer
            if (empty($host) || strpos($referer, $host) !== false) {
                $target = $referer;
            }
        }

        header("Location: " . $target);
        exit();
    }
}

