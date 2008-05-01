<?php
require_once "../lib/DataConnector.class.php";

$myCon = new DataConnector("192.168.1.10", "8550", "rtls_user", "welcome");

$xmlRequest = new DOMDocument("1.0", "utf-8");
$xmlRequest->formatOutput = true;

$request = $xmlRequest->createElement("request");
$request = $xmlRequest->appendChild($request); 

$params = $xmlRequest->createElement("PARAMS");
$params = $request->appendChild($params);
$params->appendChild($xmlRequest->createElement("fields", "all"));

try {
	$xmlResponse = $myCon->request($xmlRequest, "epe/pos/taglist");
	echo $xmlResponse->saveXML();
} catch (CannotConnectException $e) {
	echo $e->getMessage();
}
?>