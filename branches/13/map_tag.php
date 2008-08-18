<?php
require_once "lib/Tracker.class.php";

$tracker = new Tracker("192.168.1.10", "8550", "rtls_user", "welcome");
echo $tracker->mapTag($_GET["tagid"], $_GET["width"], $_GET["height"]);
?>