<?php
$fh = fopen("test.file", "a");
fwrite($fh, "test here");
fclose($fh);
?>