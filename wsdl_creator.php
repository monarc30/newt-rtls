<?php
require_once "php2wsdl/WSDLCreator.php";

$test = new WSDLCreator("NEWT-RTLS", "http://rtls.gg/ws/");

$test->addFile("lib/SOAPServer.class.php");
$test->addFile("lib/Person.class.php");

$test->setClassesGeneralURL("http://rtls.gg/ws/");
$test->addURLToClass("SOAPServer", "http://rtls.gg/ws/");
$test->addURLToClass("Person", "http://rtls.gg/ws/");
$test->addURLToTypens("Person[]", "http://rtls.gg/ws/");

$test->createWSDL();

$test->saveWSDL("/home/labadmin/eclipse-workspace/newt-rtls/ws.wsdl", true);
?>