<?php
ini_set("soap.wsdl_cache_enabled", "0");

$myClient = new SoapClient("http://rtls.gg/ws/wsdl.php");

$people = $myClient->getPeople();

if(!empty($people)) {
	$xmlResponse = new DOMDocument("1.0", "utf-8");
	$xmlResponse->formatOutput = true;
	
	$xmlRoot = $xmlResponse->createElement("people");
	$xmlRoot = $xmlResponse->appendChild($xmlRoot);
	
	foreach($people as $item) {
		$xmlPerson = $xmlResponse->createElement("person");
		$xmlPerson = $xmlRoot->appendChild($xmlPerson);
		$xmlPerson->appendChild($xmlResponse->createElement("id", $item->id));
		$xmlPerson->appendChild($xmlResponse->createElement("firstName", $item->firstName));
		$xmlPerson->appendChild($xmlResponse->createElement("lastName", $item->lastName));
	}
}

header("Content-type: text/xml;charset=utf-8\r\n");

echo $xmlResponse->saveXML();

?>