<?php
/**
 * Part of NEWT-RTLS lib package contains Event class.
 * @author Polad Mirzayev <polad.mirzayev@newt.trlabs.ca>
 * @version 1.0
 * @copyright (c) Copyright NEWT 2008
 * @package newt-rtls
 */

/**
 * Class representing Event object
 */
class Event {
	private $eventid;
	private $ruleid;
	private $eventtime;
	private $tagid;
	private $mac;
	private $name;
	private $posx;
	private $posy;
	private $posmodelid;
	private $posmapid;
	private $poszoneid;
	private $posmapname;
	private $poszonename;
	private $posquality;
	private $posreason;
	private $postime;
	private $postimestamp;
	private $posfilter;
	private $batterylevel;
	private $charging;
	private $oldzoneid;
	private $type;
	private $eventtype;
	
	/**
	 * Default constructor for Event object. Can accept an optional
	 * data parameter containing Event information in XML format.
	 * @param DOMElement $data
	 * @return Event
	 */
	public function Event(DOMElement $data = NULL) {
		if($data) {
			foreach ($data->childNodes as $item) {
				$this->{$item->nodeName} = $item->nodeValue;
			}
			/*
			$item = $data->getNamedItem("ruleid");
			$this->ruleid = $item->nodeValue;
			$data->removeChild($item);
			
			$item = $data->getNamedItem("eventtime");
			$this->eventtime = $item->nodeValue;
			$data->removeChild($item);
			
			$item = $data->getNamedItem("charging");
			$this->charging = $item->nodeValue;
			$data->removeChild($item);
			
			$item = $data->getNamedItem("poszonename");
			$this->poszonename = $item->nodeValue;
			$data->removeChild($item);
			
			$item = $data->getNamedItem("posfilter");
			$this->posfilter = $item->nodeValue;
			$data->removeChild($item);
			
			$item = $data->getNamedItem("oldzoneid");
			$this->oldzoneid = $item->nodeValue;
			$data->removeChild($item);
			
			if($items = $data->getElementsByTagName("eventid")) {
				$this->eventid = $items->item(0)->nodeValue;
			}
			
			$this->tag = new Tag($data);
			*/
		}
	}
	
	public function getEventId() {
		return $this->eventid;
	}
	
	public function getRuleId() {
		return $this->ruleid;
	}
	
	public function getEventTime() {
		return $this->eventtime;
	}
	
	public function getTagId() {
		return $this->tagid;
	}
	
	public function getMAC() {
		return $this->mac;
	}
	
	public function getName() {
		return $this->name;
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
	
	public function getPosZoneName() {
		return $this->poszonename;
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
	
	public function getPosFilter() {
		return $this->posfilter;
	}
	
	public function getBatteryLevel() {
		return $this->batterylevel;
	}
	
	public function getCharging() {
		return $this->charging;
	}
	
	public function getOldZoneId() {
		return $this->oldzoneid;
	}
	
	public function getType() {
		return $this->type;
	}
	
	public function setEventType($value) {
		$this->eventtype = $value;
	}
	
	public function getEventType() {
		return $this->eventtype;
	}
}
?>