<?php
require_once "php2wsdl/WSDLCreator.php";

$test = new WSDLCreator("NEWT-RTLS", "http://rtls.gg/ws");

$test->addFile("lib/Tracker.class.php");
$test->addFile("lib/DataConnector.class.php");
$test->addFile("lib/Event.class.php");
$test->addFile("lib/Person.class.php");
$test->addFile("lib/Registry.class.php");
$test->addFile("lib/Tag.class.php");

$test->setClassesGeneralURL("http://rtls.gg");

$test->createWSDL();

$test->saveWSDL("/home/labadmin/eclipse-workspace/newt-rtls/ws.wsdl", true);
?>