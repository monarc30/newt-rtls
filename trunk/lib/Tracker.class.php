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

/**
 * Tracker keeps track of the tags registered in the system
 */
class Tracker {
	private $connector;
	
	public function Tracker() {
		$this->connector = new DataConnector(
			"192.168.1.10",
			"8550",
			"rtls_user",
			"welcome");
	}
	
	/**
	 * This method returns the list of tags registered in the system. 
	 * @return Tag[] Array of Tag objects
	 */
	public function listTags() {
		try {
			$listOfTags;
			
			$myCon = new DataConnector("192.168.1.10", "8550", "rtls_user", "welcome");
			
			$xmlRequest = new DOMDocument("1.0", "utf-8");
			$xmlRequest->formatOutput = true;
			
			$request = $xmlRequest->createElement("request");
			$request = $xmlRequest->appendChild($request); 
			
			$params = $xmlRequest->createElement("PARAMS");
			$params = $request->appendChild($params);
			$params->appendChild($xmlRequest->createElement("fields", "all"));
			
			$xmlListOfTags = $myCon->request($xmlRequest, "epe/pos/taglist");
			
			if($tags = $xmlListOfTags->getElementsByTagName("TAG")) {
				foreach($tags as $item) {
					$listOfTags[] = new Tag($item);
				}
			}
			
			return $listOfTags;
		} catch (BadRequestException $e) {
			echo $e->getMessage();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
}

?>