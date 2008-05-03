<?php
/**
 * Part of NEWT-RTLS lib package contains Tag class.
 * @author Polad Mirzayev <polad.mirzayev@newt.trlabs.ca>
 * @version 1.0
 * @copyright (c) Copyright NEWT 2008
 * @package newt-rtls
 */

/**
 * Class representing Tag object
 */
class Tag {
	private $id;
	private $tagid;
	private $mac;
	private $type;
	private $createdon;
	private $serialnumber;
	private $swversion;
	private $hwversion;
	private $wlanfirmware;
	private $ip;
	private $apmac;
	private $cmdresult;
	private $hellocounter;
	private $hellotimestamp;
	private $confirmcounter;
	private $confirmtimestamp;
	private $configid;
	private $posx;
	private $posy;
	private $posmodelid;
	private $posmapid;
	private $poszoneid;
	private $posmapname;
	private $posquality;
	private $posreason;
	private $postime;
	private $postimestamp;
	private $buttonx;
	private $buttony;
	private $buttonmodelid;
	private $buttonmapid;
	private $buttonzoneid;
	private $buttonmapname;
	private $buttonquality;
	private $buttonreason;
	private $buttontime;
	private $buttontimestamp;
	private $poscounter;
	private $battery;
	private $name;
	private $profile;
	private $pending;
	
	/**
	 * Default constructor for Tag object. Can accept an optional
	 * data parameter containing Tag information in XML format.
	 * @param DOMElement $data
	 * @return Tag
	 */
	public function Tag(DOMElement $data = NULL) {
		if($data) {
			foreach ($data->childNodes as $item) {
				$this->{$item->nodeName} = $item->nodeValue;
			}
		}
	}
	
	public function setId($value) {
		$this->id = $value;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setTagId($value) {
		$this->tagid = $value;
	}
	
	public function getTagId() {
		return $this->tagid;
	}
	
	public function setMAC($value) {
		$this->mac = $value;
	}
	
	public function getMAC() {
		return $this->mac;
	}
}

?>