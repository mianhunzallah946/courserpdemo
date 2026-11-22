<?php
$host = getenv('DB_HOST') ?: 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$user = getenv('DB_USER') ?: 'thqwjtXwmTAALuQ.root';
$pass = getenv('DB_PASS') ?: 'Wl8lNwXMQil2iVAi';
$db   = getenv('DB_NAME') ?: 'sys';
$port = getenv('DB_PORT') ? (int)getenv('DB_PORT') : 4000;

$connec = mysqli_init();

if (getenv('DB_HOST')) {
    // Secure SSL connection for TiDB Cloud on Render
    mysqli_ssl_set($connec, NULL, NULL, "/etc/ssl/certs/ca-certificates.crt", NULL, NULL);
    $connected = mysqli_real_connect($connec, $host, $user, $pass, $db, $port, NULL, MYSQLI_CLIENT_SSL);
} else {
    // Fallback for local testing (XAMPP/WAMP)
    $connected = mysqli_real_connect($connec, $host, $user, $pass, $db, 3306);
}

if (!$connected) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
