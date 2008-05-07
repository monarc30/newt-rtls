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
	
	public function getType() {
		return $this->type;
	}
	
	public function getCreatedOn() {
		return $this->createdon;
	}
	
	public function getSerialNumber() {
		return $this->serialnumber;
	}
	
	public function getSwVersion() {
		return $this->swversion;
	}
	
	public function getHwVersion() {
		return $this->hwversion;
	}
	
	public function getWlanFirmware() {
		return $this->wlanfirmware;
	}
	
	public function getIP() {
		return $this->ip;
	}
	
	public function getApmac() {
		return $this->apmac;
	}
	
	public function getCmdResult() {
		return $this->cmdresult;
	}
	
	public function getHelloCounter() {
		return $this->hellocounter;
	}
	
	public function getHelloTimestamp() {
		return $this->hellotimestamp;
	}
	
	public function getConfirmCounter() {
		return $this->confirmcounter;
	}
	
	public function getConfirmTimestamp() {
		return $this->confirmtimestamp;
	}
	
	public function getConfigId() {
		return $this->configid;
	}
	
	public function getPosX() {
		return $this->posx;
	}
	
	public function getPosY() {
		return $this->posy;
	}
	
	public function getPosModelId() {
		return $this->posmodelid;
	}
	
	public function getPosMapId() {
		return $this->posmapid;
	}
	
	public function getPosZoneId() {
		return $this->poszoneid;
	}
	
	public function getPosMapName() {
		return $this->posmapname;
	}
	
	public function getPosQuality() {
		return $this->posquality;
	}
	
	public function getPosReason() {
		return $this->posreason;
	}
	
	public function getPosTime() {
		return $this->postime;
	}
	
	public function getPosTimestamp() {
		return $this->postimestamp;
	}
	
	public function getButtonX() {
		return $this->buttonx;
	}
	
	public function getButtonY() {
		return $this->buttony;
	}
	
	public function getButtonModelId() {
		return $this->buttonmodelid;
	}
	
	public function getButtonMapId() {
		return $this->buttonmapid;
	}
	
	public function getButtonZoneId() {
		return $this->buttonzoneid;
	}
	
	public function getButtonMapName() {
		return $this->buttonmapname;
	}
	
	public function getButtonQuality() {
		return $this->buttonquality;
	}
	
	public function getButtonReason() {
		return $this->buttonreason;
	}
	
	public function getButtonTime() {
		return $this->buttontime;
	}
	
	public function getButtonTimestamp() {
		return $this->buttontimestamp;
	}
	
	public function getPosCounter() {
		return $this->poscounter;
	}
	
	public function getBattery() {
		return $this->battery;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getProfile() {
		return $this->profile;
	}
	
	public function getPending() {
		return $this->pending;
	}
}

?>