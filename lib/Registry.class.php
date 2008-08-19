<?php
/**
 * Part of NEWT-RTLS lib package contains Registry class.
 * @author Polad Mirzayev <polad.mirzayev@newt.trlabs.ca>
 * @version 1.0
 * @copyright (c) Copyright NEWT 2008
 * @package newt-rtls
 */

require_once "Person.class.php";
require_once "Tag.class.php";
require_once "CannotConnectException.class.php";
require_once "BadDatabaseQueryException.class.php";

/**
 * Registry class registers tags in the database and assigns
 * them to people. It also deregisters tags from the database.
 */
class Registry {
	private $dbh;
	
	/**
	 * Default constructor initiates connection to database.
	 * @param string $server
	 * @param string $username
	 * @param string $password
	 * @param string $database
	 * @return Registry
	 * @throws CannotConnectException
	 */
	public function Registry($server, $username, $password, $database) {
		if(!$this->dbh = new mysqli($server, $username, $password, $database)) {
			throw new CannonConnectException("Cannot connect to database!");
		} 
	}
	
	public function addPerson() {
		
	}
	
	/**
	 * Assigns a registered tag to a person.
	 * @param int $person
	 * @param string $tagid
	 * @param string $mac
	 * @return boolean
	 * @throws BadDatabaseQueryException
	 */
	public function assignTag($personId, $tagId, $mac) {
		$strSQL = "INSERT INTO tag (tagid, mac, person_id) VALUES ('$tagId', '$mac', $personId)";
		if(!$result = $this->dbh->query($strSQL)) {
			throw new BadDatabaseQueryException("Bad database query!");
		} else {
			return $result;	
		}
	}
	
	/**
	 * Method to unassign a tag assigned to a person.
	 * @param int $assignedId This is is stored in the database
	 * when tag is assigned to a person.
	 * @return boolean
	 * @throws BadDatabaseQueryException
	 */
	public function unassignTag($assignedId) {
		if(is_array($assignedId)) {
			$assignedId = implode(",", $assignedId);
		}
		$strSQL = "DELETE FROM tag WHERE tag.id IN (" . $assignedId . ")";
		
		if(!$result = $this->dbh->query($strSQL)) {
			throw new BadDatabaseQueryException("Bad database query!");
		} else {
			return $result;
		}
	}
	
	/**
	 * This method returns a list of people registered in the system.
	 * @param boolean $getTagInfo Set to True if you want to get info
	 * about assigned tags for each person. 
	 * @return Person[] Array of Person objects
	 * @throws BadDatabaseQuery
	 */
	public function listPeople($getTagInfo = false) {
		$listOfPeople;
		
		$strSQL = "SELECT * FROM person";
		if(!$result = $this->dbh->query($strSQL)) {
			throw new BadDatabaseQueryException("Bad database query!");
		}
		
		while($record = $result->fetch_array()) {
			$listOfPeople[] = new Person($record["person_id"], $record["first_name"], $record["last_name"]);
		}
		
		return $listOfPeople;
	}
	
	/**
	 * Method for returning list of assigned tags or assigned to the
	 * specific person by ID.
	 * @param int $personId
	 * @return Tag[] Array of Tag objects
	 * @throws BadDatabaseQueryException
	 */
	public function listAssignedTags($personId = NULL) {
		$listOfAssignedTags;
		
		if(!$personId) {
			$strSQL = "SELECT * FROM tag";
		} else {
			$strSQL = "SELECT * FROM tag WHERE person_id=" . $personId;
		}
		if(!$result = $this->dbh->query($strSQL)) {
			throw new BadDatabaseQueryException("Bad database query!");
		}
		
		while($record = $result->fetch_array()) {
			$newTag = new Tag();
			$newTag->setId($record["id"]);
			$newTag->setTagId($record["tagid"]);
			$newTag->setMAC($record["mac"]);
			
			$listOfAssignedTags[] = $newTag;
		}
		
		return $listOfAssignedTags;
	}
}


?>