<?php
require_once(__DIR__ . '/demo_guard.php');
block_demo_action('./manage_courses.php', '⚠️ Demo Mode: Deleting course modules is strictly disabled in demo mode.');

include('./connection.php');
$delid = $_GET['delid'];

$dsql = "SELECT `videos` FROM `course` WHERE `course_id`='$delid'";
$drun = mysqli_query($connec, $dsql);
$dfet = mysqli_fetch_assoc($drun);

if ($dfet && file_exists("./coursevideo/" . $dfet['video'])) {
    unlink("./coursevideo/" . $dfet['video']);
}

$sql = "DELETE FROM `course` WHERE `course_id`='$delid'";
$run = mysqli_query($connec, $sql);

if ($run) {
    header("Location: ./index.php");
    exit;
}
?>
