<?php
require_once "lib/Registry.class.php";

try {
	$registry = new Registry("localhost", "rtls_user", "welcome", "rtls");
	
	$registry->unassignTag($_POST["tag_id"]);
} catch (CannotConnectException $e) {
	echo $e->getMessage();
} catch (BadDatabaseQueryException $e) {
	echo $e->getMessage();
} catch (Exception $e) {
	echo $e->getMessage();
}

header("location: /?person_id=".$_POST["people"]);
?>