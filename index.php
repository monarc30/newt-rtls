<?php
require_once "lib/Tracker.class.php";
require_once "lib/Registry.class.php";

$tracker = new Tracker("192.168.1.10", "8550", "rtls_user", "welcome");
$tags = $tracker->listTags();

try {
	$registry = new Registry("localhost", "rtls_user", "welcome", "rtls");
} catch (CannotConnectException $e) {
	echo $e->getMessage();
} catch (Exception $e) {
	echo $e->getMessage();
}
$people = $registry->listPeople();
?>
<html>
<head>
<title>List of Tags</title>
<style type="text/CSS">
.tbl_header {
background-color: #D0D0D0;
font-weight: bold;
font-size: 9pt;
font-family: "Verdana";
}

.tbl_footer {
background-color: #FFFFFF;
}

.tbl_cell {
background-color: #FFFFFF;
}
</style>
<script type="text/javascript">

function showAssignTagWindow() {
	frmAssignTag.person_id.value = frmPeople.people.value;
	wndAssignTag.style.left = (window.innerWidth-wndAssignTag.scrollWidth)/2
	wndAssignTag.style.top = (window.innerHeight-wndAssignTag.scrollHeight)/2
	wndAssignTag.style.visibility='visible';
}

function displayTagInfo(personId) {
	var myPanels = document.getElementsByName("tagInfoPanel");
	for(var i=0; i<myPanels.length; i++) {
		myPanels[i].style.visibility = 'collapse';
	}
	eval('tagInfoFor_'+personId+'.style.visibility=\'visible\';');
}

</script>
</head>
<body>

<!-- 
<table width="100%">
	<tr>
		<td>List of People</td>
		<td>List of Tags</td>
		<td>
	</tr>
</table>
-->
 
<center>

<form name="frmPeople" action="">
<table width="780" bgcolor="#C0C0C0" cellspacing="1" cellpadding="5">
	<tr>
		<td colspan="2" class="tbl_header">People</td>
	</tr>
	<tr>
		<td class="tbl_cell" colspan="2">
			<select name="people" size="1" onChange="displayTagInfo(this.value);">
				<?php foreach($people as $person) { ?>
				<option value="<?php echo $person->getId(); ?>"><?php echo $person->getFullName(); ?></option>
				<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2" class="tbl_header">Assigned Tags</td>
	</tr>
	<?php
	foreach($people as $person) {
	$assignedTags = $registry->listAssignedTags($person->getId()); 
	if($assignedTags) {
	foreach($assignedTags as $item) {
	?>
	<tr id="tagInfoFor_<?php echo $person->getId(); ?>" name="tagInfoPanel" style="visibility: collapse;">
		<td class="tbl_cell" width="10">
			<input type="radio" name="tag_id" value="<?php echo $item->getTagId(); ?>">
		</td>
		<td class="tbl_cell">
			<?php echo $item->getTagId() . " [ " . $item->getMAC() . " ]"; ?>
		</td>
	</tr>
	<?php }} else { ?>
	<tr id="tagInfoFor_<?php echo $person->getId(); ?>" name="tagInfoPanel" style="visibility: collapse;">
		<td class="tbl_cell" colspan="2">
			<i>No assigned tags...</i>
		</td>
	</tr>
	<?php }} ?>
	<tr>
		<td class="tbl_cell" colspan="2">
			<input type="button" value="Assign a Tag" onClick="showAssignTagWindow()">
		</td>
	</tr>
</table>
</form>

</center>

<form name="frmAssignTag" method="post" action="assign_tag.php">
<input type="hidden" name="person_id">
<table width="400" bgcolor="#C0C0C0" cellspacing="1" cellpadding="2" id="wndAssignTag" style="visibility: hidden; position: absolute;">
<tr><td colspan="2" bgcolor="#E0E0E0">
<table width="100%" bgcolor="#C0C0C0" cellspacing="1" cellpadding="5">
	<tr>
		<td colspan="2" class="tbl_header">Registered Tags</td>
	</tr>
	<?php foreach($tags as $item) { ?>
	<tr>
		<td class="tbl_cell">
			<input type="radio" name="tag_id" value="<?php echo $item->getTagId(); ?>">
			<input type="hidden" name="mac" value="<?php echo $item->getMAC(); ?>">
		</td>
		<td class="tbl_cell">
			<?php echo $item->getTagId() . " [ " . $item->getMAC() . " ]"; ?>
		</td>
	</tr>
	<?php } ?>
	<tr>
		<td colspan="2" class="tbl_footer" align="right">
			<input type="submit" value="Assign">
			<input type="button" value="Cancel" onClick="wndAssignTag.style.visibility='hidden';">
		</td>
	</tr>
</table>
</td></tr></table>
</form>

</body>
</html>