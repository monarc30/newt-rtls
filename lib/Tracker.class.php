<?php
/**
 * Part of NEWT-RTLS lib package contains Tracker class.
 * @author Polad Mirzayev <polad.mirzayev@newt.trlabs.ca>
 * @version 1.0
 * @copyright (c) Copyright NEWT 2008
 * @package newt-rtls
 */

require_once "DataConnector.class.php";
require_once "Tag.class.php";
require_once "Event.class.php";

/**
 * Tracker keeps track of the tags registered in the system
 */
class Tracker {
	private $connector;
	
	public function Tracker($server, $port, $username, $password) {
		$this->connector = new DataConnector($server, $port, $username, $password);
	}
	
	/**
	 * This method returns the list of tags registered in the system. 
	 * @return Tag[] Array of Tag objects
	 */
	public function listTags() {
		try {
			$listOfTags;
			
			$xmlRequest = new DOMDocument("1.0", "utf-8");
			$xmlRequest->formatOutput = true;
			
			$request = $xmlRequest->createElement("request");
			$request = $xmlRequest->appendChild($request); 
			
			$params = $xmlRequest->createElement("PARAMS");
			$params = $request->appendChild($params);
			$params->appendChild($xmlRequest->createElement("fields", "all"));
			
			$xmlListOfTags = $this->connector->request($xmlRequest, "epe/pos/taglist");
			
			if($tags = $xmlListOfTags->getElementsByTagName("TAG")) {
				foreach($tags as $item) {
					$listOfTags[] = new Tag($item);
				}
			}
			
			return $listOfTags;
		} catch (CannotConnectException $e) {
			echo $e->getMessage();
		} catch (BadRequestException $e) {
			echo $e->getMessage();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	/**
	 * This method displays a tag on the map
	 * @param string $tagid
	 * @return binary Map in a binary format
	 */
	public function mapTag($tagid, $mapWidth=NULL, $mapHeight=NULL) {
		try {
			$xmlRequest = new DOMDocument("1.0", "utf-8");
			$xmlRequest->formatOutput = true;
			
			$request = $xmlRequest->createElement("request");
			$request = $xmlRequest->appendChild($request); 
			
			$params = $xmlRequest->createElement("PARAMS");
			$params = $request->appendChild($params);
			$params->appendChild($xmlRequest->createElement("tagid", $tagid));
			if($mapWidth) {
				$params->appendChild($xmlRequest->createElement("width", $mapWidth));
			}
			if($mapHeight) {
				$params->appendChild($xmlRequest->createElement("height", $mapHeight));
			}
			
			return $this->connector->request($xmlRequest, "epe/map/render");
		} catch (CannotConnectException $e) {
			echo $e->getMessage();
		} catch (BadRequestException $e) {
			echo $e->getMessage();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	public function getEvents($ruleid=null, $numofevents=1) {
		try {
			$xmlRequest = new DOMDocument("1.0", "utf-8");
			$xmlRequest->formatOutput = true;
			
			$request = $xmlRequest->createElement("request");
			$request = $xmlRequest->appendChild($request);
			
			$params = $xmlRequest->createElement("PARAMS");
			$params = $request->appendChild($params);
			$params->appendChild($xmlRequest->createElement("numlatest", $numofevents));
			
			//$this->connector->listen($xmlRequest, "epe/eve/eventstream");
			
			$xmlListOfEvents = $this->connector->request($xmlRequest, "epe/eve/historylist");
			$xmlListOfEvents = $xmlListOfEvents->getElementsByTagName("response")->item(0);
			
			if($xmlListOfEvents->hasChildNodes()) {
				foreach ($xmlListOfEvents->childNodes as $event) {
					if(is_a($event, "DOMElement")) { 
						$newEvent = new Event($event);
						$newEvent->setEventType($event->nodeName);
						$listOfEvents[] = $newEvent;
					}
				}
			}
			
			return $listOfEvents;
		} catch (CannotConnectException $e) {
			echo $e->getMessage();
		} catch (BadRequestException $e) {
			echo $e->getMessage();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}

?>