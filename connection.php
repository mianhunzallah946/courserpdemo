<?php
$host = getenv('DB_HOST') ?: 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$user = getenv('DB_USER') ?: 'thqwjtXwmTAALuQ.root';
$pass = getenv('DB_PASS') ?: 'rs2HhRpuiwsGcZs0';
$db   = getenv('DB_NAME') ?: 'test';
$port = (int)(getenv('DB_PORT') ?: 4000);

$caCert = '/etc/ssl/certs/ca-certificates.crt';

$conn = mysqli_init();

if (file_exists($caCert)) {
    mysqli_ssl_set($conn, null, null, $caCert, null, null);
} else {
    mysqli_ssl_set($conn, null, null, null, null, null);
}

mysqli_real_connect(
    $conn,
    $host,
    $user,
    $pass,
    $db,
    $port,
    null,
    MYSQLI_CLIENT_SSL
);
?>
