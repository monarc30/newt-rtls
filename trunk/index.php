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
background-color: #4e99d6;
color: #FFFFFF;
font-weight: bold;
font-size: 10pt;
font-family: verdana, arial, sans-serif;
}

.tbl_footer {
background-color: #f4fcff;
}

.tbl_cell {
background-color: #f4fcff;
font-size: 10pt;
font-family: verdana, arial, sans-serif;
}
</style>
<script type="text/javascript">

function showAssignTagWindow() {
	frmAssignTag.person_id.value = frmPeople.people.value;
	for(var i=0; i<frmAssignTag.tag_id.length; i++) {
		frmAssignTag.tag_id[i].checked = false;
	}
	
	//var posLeft = (window.innerWidth-wndAssignTag.scrollWidth)/2;
	//var posTop = (window.innerHeight-wndAssignTag.scrollHeight)/2;
	var posLeft = 50;
	var posTop = 50;
	
	wndAssignTag.style.left = posLeft;
	wndAssignTag.style.top = posTop;
	wndAssignTag.style.zIndex = 100;
	wndAssignTag.style.visibility='visible';
	
	var shadowDepth = 5;
	wndAssignTag.shadow = new Array(shadowDepth);
	if(!wndAssignTag.shadow.isnull) {
		for(var j=0; j<shadowDepth; j++) {
			wndAssignTag.shadow[j] = document.createElement('div');
			document.body.appendChild(wndAssignTag.shadow[j]);
			wndAssignTag.shadow[j].style.filter = 'alpha(opacity=30)';
			//wndAssignTag.shadow[j].style.-moz-opacity = '0.5';
			//wndAssignTag.shadow[j].style.-khtml-opacity = '0.5';
			wndAssignTag.shadow[j].style.opacity = '0.3';
			wndAssignTag.shadow[j].style.position = 'absolute';
			wndAssignTag.shadow[j].style.zIndex = wndAssignTag.style.zIndex - (j+1);
			wndAssignTag.shadow[j].style.width = wndAssignTag.scrollWidth;
			wndAssignTag.shadow[j].style.height= wndAssignTag.scrollHeight;
			wndAssignTag.shadow[j].style.left = posLeft+(j+1);
			wndAssignTag.shadow[j].style.top = posTop+(j+1);
			wndAssignTag.shadow[j].style.backgroundColor = RGB(j*(256/shadowDepth),j*(256/shadowDepth),j*(256/shadowDepth));
		}
	}
	
	for(var j=0; j<shadowDepth; j++) {
		wndAssignTag.shadow[j].style.visibility='visible';
	}
}

function closeWindow(wnd) {
	for each (var layer in wnd.shadow) {
		layer.style.visibility = 'hidden';
	}
	wnd.style.visibility='hidden';
}

function RGB(r,g,b) {
	return '#' + byte2Hex(r) + byte2Hex(g) + byte2Hex(b);
}

function byte2Hex(n) {
	var nybHexString = "0123456789ABCDEF";
	return String(nybHexString.substr((n >> 4) & 0x0F,1)) + nybHexString.substr(n & 0x0F,1);
}

function displayAssignedTagsList(personId) {
	var myPanels = document.getElementsByName("assignedTagsList");
	for(var i=0; i<myPanels.length; i++) {
		myPanels[i].style.visibility = 'collapse';
	}
	document.ge
	eval('tagInfoFor_'+personId+'.style.visibility=\'visible\';');
}

</script>
</head>
<body onLoad="displayAssignedTagsList(frmPeople.people.value);">

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
<table width="780" bgcolor="#007ec7" cellspacing="1" cellpadding="5">
	<tr>
		<td class="tbl_header">People</td>
	</tr>
	<tr>
		<td class="tbl_cell">
			<select name="people" size="1" onChange="displayAssignedTagsList(this.value);">
				<?php foreach($people as $person) { ?>
				<option <?php if($person->getId() == $_GET["person_id"]){echo "selected=\"selected\"";} ?> value="<?php echo $person->getId(); ?>"><?php echo $person->getFullName(); ?></option>
				<?php } ?>
			</select>
		</td>
	</tr>
	<tr>
		<td class="tbl_header">Assigned Tags</td>
	</tr>
	<?php
	foreach($people as $person) {
	$assignedTags = $registry->listAssignedTags($person->getId());
	if($assignedTags) {
	?>
	<tr id="tagInfoFor_<?php echo $person->getId(); ?>" name="assignedTagsList" style="visibility: collapse;">
		<td class="tbl_cell">
			<table width="780" bgcolor="#007ec7" cellspacing="1" cellpadding="5">
				<?php foreach($assignedTags as $item) { ?>
				<tr>
					<td class="tbl_cell" width="10">
						<input type="checkbox" name="tag_id" value="<?php echo $item->getTagId(); ?>">
					</td>
					<td class="tbl_cell">
						<?php echo $item->getTagId() . " [ " . $item->getMAC() . " ] <a href=\"#\">details</a>"; ?>
					</td>
				</tr>
				<?php } ?>
			</table>
		</td>
	</tr>
	<?php } else { ?>
	<tr id="tagInfoFor_<?php echo $person->getId(); ?>" name="assignedTagsList" style="visibility: collapse;">
		<td class="tbl_cell">
			<i>No assigned tags...</i>
		</td>
	</tr>
	<?php }} ?>
	<tr>
		<td class="tbl_cell">
			<input type="button" value="Assign a Tag" onClick="showAssignTagWindow()">
		</td>
	</tr>
</table>
</form>

</center>

<form name="frmAssignTag" method="post" action="assign_tag.php">
<input type="hidden" name="person_id">
<input type="hidden" name="mac">
<table width="400" bgcolor="#007ec7" cellspacing="1" cellpadding="2" id="wndAssignTag" style="visibility: hidden; position: absolute; filter:alpha(opacity=75); -moz-opacity:0.75; -khtml-opacity: 0.75; opacity: 0.75;">
<tr><td bgcolor="#80bbe8">
<table width="100%" bgcolor="#007ec7" cellspacing="1" cellpadding="0">
	<tr>
		<td class="tbl_header">Registered Tags</td>
	</tr>
	<tr>
		<td>
			<div style="overflow: auto; width: 400px; height: 300px;">
				<table width="100%" bgcolor="#007ec7" cellspacing="1" cellpadding="5">
					<?php foreach($tags as $item) { ?>
					<tr>
						<td class="tbl_cell">
							<input type="radio" name="tag_id" value="<?php echo $item->getTagId(); ?>" onClick="frmAssignTag.mac.value = '<?php echo $item->getMAC(); ?>';">
						</td>
						<td class="tbl_cell">
							<?php echo $item->getTagId() . " [ " . $item->getMAC() . " ]"; ?>
						</td>
					</tr>
					<?php } ?>
				</table>
			</div>
		</td>
	</tr>
	<tr>
		<td class="tbl_footer" align="right">
			<input type="submit" value="Assign">
			<input type="button" value="Cancel" onClick="closeWindow(wndAssignTag)">
		</td>
	</tr>
</table>
</td></tr></table>
</form>

</body>
</html>