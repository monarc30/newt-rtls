<?php
/**
 * Part of NEWT-RTLS lib package contains RTLSSOAP class.
 * @author Polad Mirzayev <polad.mirzayev@newt.trlabs.ca>
 * @version 1.0
 * @copyright (c) Copyright NEWT 2008
 * @package newt-rtls
 */

require_once "../lib/Tracker.class.php";
require_once "../lib/Registry.class.php";

class RTLSSOAP {
	private function getRegistry() {
		try {
			return new Registry("localhost", "rtls_user", "welcome", "rtls");
		} catch (CannotConnectException $e) {
			echo $e->getMessage();
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}
	
	private function getTracker() {
		return new Tracker("192.168.1.10", "8550", "rtls_user", "welcome");
	}
	
	/**
	 * This method returns a list of people registered in the system.
	 * @return Person[] Array of Person objects
	 */
	public function getPeople() {
		if($registry = $this->getRegistry()) {
			return $registry->listPeople();
		}
		
		return false;
	}
	
	/**
	 * This method returns a list of tags registered in the system. 
	 * @return Tag[] Array of Tag objects
	 */
	public function getTags() {
		if($tracker = $this->getTracker()) {
			return $tracker->listTags();
		}
	}
	
	/**
	 * This method returns the latest events registered in the system.
	 * @return Event[] Array of Event objects
	 */
	public function getEvents() {
		if($tracker = $this->getTracker()) {
			return $tracker->getEvents();
		}
	}
}

?>