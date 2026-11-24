<?php
$dbHost = getenv('DB_HOST') ?: 'gateway01.ap-southeast-1.prod.aws.tidbcloud.com';
$dbUser = getenv('DB_USER') ?: 'thqwjtXwmTAALuQ.root';
$dbPass = getenv('DB_PASS') ?: 'ghwoivSNeXfCv5iV';
$dbName = getenv('DB_NAME') ?: 'test';
$dbPort = (int)(getenv('DB_PORT') ?: 4000);

if ($dbHost !== '' && $dbUser !== '' && $dbName !== '') {
    $caCert = '/etc/ssl/certs/ca-certificates.crt';
    $connec = mysqli_init();

    if ($connec) {
        if (file_exists($caCert)) {
            mysqli_ssl_set($connec, null, null, $caCert, null, null);
        } else {
            mysqli_ssl_set($connec, null, null, null, null, null);
        }

        @mysqli_real_connect(
            $connec,
            $dbHost,
            $dbUser,
            $dbPass,
            $dbName,
            $dbPort,
            null,
            MYSQLI_CLIENT_SSL
        );
    }
} else {
    $connec = @mysqli_connect("localhost", "root", "", "course");
}
