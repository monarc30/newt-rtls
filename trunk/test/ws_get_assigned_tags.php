<?php
ini_set("soap.wsdl_cache_enabled", "0");

$myClient = new SoapClient("http://rtls.gg/ws/wsdl.php");

$assignedTags = $myClient->getAssignedTags($_REQUEST["personId"]);

if(!empty($assignedTags)) {
	$xmlResponse = new DOMDocument("1.0", "utf-8");
	$xmlResponse->formatOutput = true;
	
	$xmlRoot = $xmlResponse->createElement("tags");
	$xmlRoot = $xmlResponse->appendChild($xmlRoot);
	
	foreach($assignedTags as $tagItem) {
		$xmlTag = $xmlResponse->createElement("tag");
		$xmlTag = $xmlRoot->appendChild($xmlTag);
		$xmlTag->appendChild($xmlResponse->createElement("tagid", $tagItem->tagid));
		$xmlTag->appendChild($xmlResponse->createElement("mac", $tagItem->mac));
		$xmlTag->appendChild($xmlResponse->createElement("name", $tagItem->name));
	}
}

header("Content-type: text/xml;charset=utf-8\r\n");

echo $xmlResponse->saveXML();

?>