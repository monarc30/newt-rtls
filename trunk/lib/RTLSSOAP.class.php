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
	
	/**
	 * This method returns a list of people registered in the system. 
	 * @return Person[] Array of Person objects
	 */
	public function getPeople() {
		if($registry = $this->getRegistry()) {
			return $registry->listPeople();
		}
	}
}

?>