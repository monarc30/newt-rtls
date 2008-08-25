<?php
require_once "../lib/RTLSSOAP.class.php";

ini_set("soap.wsdl_cache_enabled", "0");

$myServer = new SoapServer("ws.wsdl", array("encoding"=>"UTF-8"));

$myServer->setClass("RTLSSOAP");
$myServer->handle();
?>