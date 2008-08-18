<?php
/**
 * Part of NEWT-RTLS lib package contains Person class.
 * @author Polad Mirzayev <polad.mirzayev@newt.trlabs.ca>
 * @version 1.0
 * @copyright (c) Copyright NEWT 2008
 * @package newt-rtls
 */

/**
 * Class representing Person object
 */
class Person {
	private $id;
	private $firstName;
	private $lastName;
	private $assignedTags;
	
	public function Person($personId, $firstName, $lastName, $assignedTags = NULL) {
		$this->id = $personId;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
	}
	
	public function getFullName() {
		return $this->firstName . " " . $this->lastName;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getAssignedTags() {
		return $this->assignedTags;
	}
}

?>