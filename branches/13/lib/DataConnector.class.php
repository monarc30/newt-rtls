<?php
/**
 * Part of NEWT-RTLS lib package contains DataConnector class.
 * @author Polad Mirzayev <polad.mirzayev@newt.trlabs.ca>
 * @version 1.0
 * @copyright (c) Copyright NEWT 2008
 * @package newt-rtls
 */

require_once "BadRequestException.class.php";
require_once "CannotConnectException.class.php";

/**
 * Use DataConnector class to request an XML stream from the web
 * service.
 */
class DataConnector {
	private $hostname;
	private $port;
	private $username;
	private $password;
	
	/**
	 * Default Constructor
	 * @param string $hostname
	 * @param string $port
	 * @param string $username
	 * @param string $password
	 * @param boolean $ssl
	 * @return DataConnector
	 */
	public function DataConnector($hostname, $port = NULL, $username = NULL, $password = NULL, $ssl = false) {
		$this->hostname = $hostname;
		$this->port = $port;
		$this->username = $username;
		$this->password = $password;
		$this->ssl = $ssl;
	}
	
	/**
	 * Use this function to send a data request to Ekahau web services
	 * @param DOMDocument $parameters Request parameters in XML format
	 * @param String $path Path to the necessary WebService on the server. Do not prepend path with "/"
	 * @return DOMDocument
	 * @throws BadRequestException
	 * @throws CannotConnectException
	 */
	public function request(DOMDocument $parameters = NULL, $path = NULL) {
		$out = "POST /" . $path . " HTTP/1.1\r\n";
		$out .= "Host: " . $this->hostname . "\r\n";
		$out .= "Connection: Close\r\n\r\n";
		
	    if(!$conn = fsockopen($this->hostname, $this->port, $errno, $errstr, 10)) {
    		throw new CannotConnectException("Error Connecting to the Ekahau server!");
    	}
		fwrite($conn, $out);
		
		$buffer = stream_get_contents($conn);
		
		fclose($conn);
		
		$p1 = strpos($buffer, "WWW-Authenticate: Digest ");
		$p2 = strpos($buffer, "\r\n", $p1);
		$auth_params  = explode(", ",substr($buffer, $p1+25, $p2-($p1+25)));
		foreach($auth_params as $item) {
			eval("\$" . $item . ";");
		}
		
		$ha1 = md5($this->username.":".$realm.":".$this->password);
		$ha2 = md5("POST:/" . $path);
		$cnonce = "smthere";
    	$response = md5($ha1.':'.$nonce.':00000001:'.$cnonce.':auth:'.$ha2);
    	$parameters = $parameters->saveXML();
    	
		$out = "POST /" . $path . " HTTP/1.1\r\n";
		$out .= "Host: " . $this->hostname . "\r\n";
		$out .= "Content-type: text/xml;charset=utf-8\r\n";
		$out .= "Content-length: " . strlen($parameters) . "\r\n";
		$out .= "Accept: text/xml\r\n";
		$out .= "Connection: Close\r\n";
    	$out .= "Authorization: Digest username=\"" . $this->username .  "\", ";
    	$out .= "realm=\"" . $realm . "\", ";
    	$out .= "nonce=\"" . $nonce . "\", ";
    	$out .= "uri=\"/" . $path . "\", ";
    	$out .= "qop=\"" . $qop . "\", ";
    	$out .= "algorithm=\"MD5\", ";
    	$out .= "nc=00000001, ";
    	$out .= "cnonce=\"" . $cnonce . "\", ";
    	$out .= "response=\"" . $response . "\", ";
    	$out .= "opaque=\"" . $opaque . "\"\r\n\r\n";
    	$out .= $parameters . "\r\n\r\n";
    	
    	if(!$conn = fsockopen($this->hostname, $this->port, $errno, $errstr, 10)) {
    		throw new CannotConnectException("Error Connecting to the Ekahau server!");
    	}
    	
    	fwrite($conn, $out);
		
		$buffer = stream_get_contents($conn);
		
		fclose($conn);
		
		if(substr($buffer, strpos($buffer, "HTTP/1.1 ")+9, 3) == "200") {
			if(strpos($buffer, "<?xml")) {
				$xmlResponse = new DOMDocument("1.0", "utf-8");
				$xmlResponse->loadXML(substr($buffer, strpos($buffer, "<?xml")));
				return $xmlResponse;
			} else {
				return substr($buffer, strpos($buffer, "Connection: close\r\n\r\n")+21);
			}
		} else {
			$httpErrCode = substr($buffer, strpos($buffer, "HTTP/1.1 ")+9, 3);
			throw new BadRequestException("Bad request format! HTTP Error Code: " . $httpErrCode);
		}
	}
	
	/**
	 * This method acts as a XML stream server bound to a socket listening
	 * for live event stream.
	 * @param DOMDocument $parameters Request parameters in XML format
	 * @param String $path Path to the necessary WebService on the server. Do not prepend path with "/"
	 * @return void
	 * @throws BadRequestException
	 * @throws CannotConnectException
	 */
	public function listen(DOMDocument $parameters = NULL, $path = NULL) {
		set_time_limit(0);
		
		$out = "POST /" . $path . " HTTP/1.1\r\n";
		$out .= "Host: " . $this->hostname . "\r\n";
		$out .= "Connection: Close\r\n\r\n";
		
	    if(!$conn = fsockopen($this->hostname, $this->port, $errno, $errstr, 10)) {
    		throw new CannotConnectException("Error Connecting to the Ekahau server!");
    	}
		fwrite($conn, $out);
		
		$buffer = stream_get_contents($conn);
		
		fclose($conn);
		
		$p1 = strpos($buffer, "WWW-Authenticate: Digest ");
		$p2 = strpos($buffer, "\r\n", $p1);
		$auth_params  = explode(", ",substr($buffer, $p1+25, $p2-($p1+25)));
		foreach($auth_params as $item) {
			eval("\$" . $item . ";");
		}
		
		$ha1 = md5($this->username.":".$realm.":".$this->password);
		$ha2 = md5("POST:/" . $path);
		$cnonce = "smthere";
    	$response = md5($ha1.':'.$nonce.':00000001:'.$cnonce.':auth:'.$ha2);
    	$parameters = $parameters->saveXML();
    	
		$out = "POST /" . $path . " HTTP/1.1\r\n";
		$out .= "Host: " . $this->hostname . "\r\n";
		$out .= "Content-type: text/xml;charset=utf-8\r\n";
		$out .= "Content-length: " . strlen($parameters) . "\r\n";
		$out .= "Accept: text/xml\r\n";
		$out .= "Connection: Close\r\n";
    	$out .= "Authorization: Digest username=\"" . $this->username .  "\", ";
    	$out .= "realm=\"" . $realm . "\", ";
    	$out .= "nonce=\"" . $nonce . "\", ";
    	$out .= "uri=\"/" . $path . "\", ";
    	$out .= "qop=\"" . $qop . "\", ";
    	$out .= "algorithm=\"MD5\", ";
    	$out .= "nc=00000001, ";
    	$out .= "cnonce=\"" . $cnonce . "\", ";
    	$out .= "response=\"" . $response . "\", ";
    	$out .= "opaque=\"" . $opaque . "\"\r\n\r\n";
    	$out .= $parameters . "\r\n\r\n";
		
    	
    	if(!$conn = fsockopen($this->hostname, $this->port, $errno, $errstr, 10)) {
    		throw new CannotConnectException("Error Connecting to the Ekahau server!");
    	}
    	fwrite($conn, $out);
    	
    	//$xmlResponse = new DOMDocument("1.0", "utf-8");
    	$mysock = socket_create(AF_INET, SOCK_STREAM, 0);
    	socket_bind($mysock, "127.0.0.1", 10000);
    	socket_listen($mysock);
    	//socket_accept($mysock);
    	
    	
    	while($commSock = socket_accept($mysock)) {
			while(!feof($conn)) {
	    		$line = fgets($conn);
		    	echo $line;
		    	$buffer .= $line;
		    	if($eventRecord = $this->processEventStream($buffer)) {
		    			if(!socket_write($commSock, $eventRecord)) {
		    				break;
		    			}
		    	}
			}
    	}
		socket_close($commSock);
		socket_close($mysock);
		fclose($conn);
	}
	
	/**
	 * This is a private method for processing XML stream buffer and extracting
	 * event records from it.
	 * @param String $buffer XML data buffer
	 * @return String
	 */
	private function processEventStream(&$buffer) {
		//$fh = fopen("log.txt", "a");
		$from = strpos($buffer, "<response>");
		$to = strpos($buffer, "</response>", $from);
		if($to) {
			$strEvent = substr($buffer, $from+10, $to-($from+10));
			$buffer = null;
			if(!strpos($strEvent, "<QUERYALIVE>")) {
				return trim($strEvent);
				//fwrite($fh, $strEvent);
				//$eventReader = new XMLReader();
				//if($eventReader->XML($strEvent)) {
				//	return $eventReader->expand();
				//}
		 	}
		}
		return false;
	}
}

?>