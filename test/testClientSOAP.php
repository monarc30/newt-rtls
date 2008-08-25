<?php
ini_set("soap.wsdl_cache_enabled", "0");

$myClient = new SoapClient("http://rtls.gg/ws/wsdl.php");

foreach($myClient->__getFunctions() as $item) {
	echo $item . "<br>";
}
echo "<hr>";
foreach($myClient->__getTypes() as $item) {
	echo $item . "<br>";
}
echo "<hr>";

echo var_dump($myClient->getPeople());
/*
foreach($myClient->getPeople() as $item) {
	echo $item->getFullName();
}
*/
?>