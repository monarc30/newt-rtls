<?php
require_once "lib/Tracker.class.php";

$tracker = new Tracker();
$tags = $tracker->listTags();
?>
<html>
<head>
<title>List of Tags</title>
</head>
<body>

<center>

<table>
	<tr>
		<td> </td>
		<td>TagId [MAC]</td>
	</tr>
	<?php foreach($tags as $item) { ?>
	<tr>
		<td><input type="radio"></td>
		<td><?php echo $item->getTagId() . " [ " . $item->getMAC() . " ]"; ?></td>
	</tr>
	<?php } ?>
</table>

</center>

</body>
</html>