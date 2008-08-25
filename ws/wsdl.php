<?php
$contents = file_get_contents("ws.wsdl");


header("Content-type: text/xml;charset=utf-8\r\n");
echo $contents;
?>