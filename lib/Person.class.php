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
	/**
	 * @var int
	 */
	private $id;
	/**
	 * @var string
	 */
	private $firstName;
	/**
	 * @var string
	 */
	private $lastName;
	
	/**
	 * @param int $personId
	 * @param string $firstName
	 * @param string $lastName
	 */
	public function Person($personId, $firstName, $lastName) {
		$this->id = $personId;
		$this->firstName = $firstName;
		$this->lastName = $lastName;
	}
	
	/**
	 * @return string
	 */
	public function getFullName() {
		return $this->firstName . " " . $this->lastName;
	}
	
	/**
	 * @return int
	 */
	public function getId() {
		return $this->id;
	}
}

?>