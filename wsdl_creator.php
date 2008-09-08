<?php
require_once "php2wsdl/WSDLCreator.php";

$test = new WSDLCreator("NEWT-RTLS", "http://rtls.gg/ws/");

$test->addFile("lib/RTLSSOAP.class.php");

$test->setClassesGeneralURL("http://rtls.gg/ws/");
$test->addURLToClass("RTLSSOAP", "http://rtls.gg/ws/");
$test->addURLToTypens("Person[]", "http://rtls.gg/ws/");
$test->addURLToTypens("Event[]", "http://rtls.gg/ws/");
$test->addURLToTypens("Tag[]", "http://rtls.gg/ws/");

$test->createWSDL();

$test->saveWSDL("/home/labadmin/eclipse-workspace/newt-rtls/ws.wsdl", true);
?>