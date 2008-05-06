<?php
require_once "lib/Registry.class.php";

try {
	$registry = new Registry("localhost", "rtls_user", "welcome", "rtls");
	
	$registry->assignTag($_POST["person_id"], $_POST["tag_id"], $_POST["mac"]);
} catch (CannotConnectException $e) {
	echo $e->getMessage();
} catch (BadDatabaseQueryException $e) {
	echo $e->getMessage();
} catch (Exception $e) {
	echo $e->getMessage();
}

header("location: /?person_id=".$_POST["person_id"]);
?>