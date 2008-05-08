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

.tbl_fieldname {
background-color: #aec7da;
color: #FFFFFF;
font-size: 8pt;
font-weight: bold;
font-family: verdana, arial, sans-serif;
text-align: right;
}

</style>
<script type="text/javascript">

function showAssignTagWindow() {
	frmAssignTag.person_id.value = frmPeople.people.value;
	if(frmAssignTag.tagid != undefined) {
		for(var i=0; i<frmAssignTag.tagid.length; i++) {
			frmAssignTag.tagid[i].checked = false;
		}
	}
	
	wnd = document.getElementById("wndAssignTag");
	wnd.style.display = '';
	wnd.style.zIndex = 100;
	wnd.style.left = (document.body.clientWidth-wnd.offsetWidth)/2;
	wnd.style.top = (document.body.clientHeight-wnd.offsetHeight)/2;
	
	dropShadows(wnd, 5);
}

function closeWindow(wnd) {
	hideShadows(wnd);
	wnd.style.display = 'none';
}

function expandTagDetails(panel, label) {
	if(panel.style.display == 'none') {
		label.innerHTML = "hide &#171;";
		panel.style.display = '';
	} else {
		panel.style.display = 'none';
		label.innerHTML = "details &#187;";
	}
}

function dropShadows(wnd, shadowDepth) {
	if(wnd.shadow == undefined) {
		wnd.shadow = new Array(shadowDepth);
		for(var j=0; j<shadowDepth; j++) {
			wnd.shadow[j] = document.createElement('div');
			document.body.appendChild(wnd.shadow[j]);
			wnd.shadow[j].style.filter = 'alpha(opacity=30)';
			//wnd.shadow[j].style.-moz-opacity = '0.5';
			//wnd.shadow[j].style.-khtml-opacity = '0.5';
			wnd.shadow[j].style.opacity = '0.3';
			wnd.shadow[j].style.position = 'absolute';
			wnd.shadow[j].style.zIndex = wnd.style.zIndex - (j+1);
			wnd.shadow[j].style.width = wnd.scrollWidth;
			wnd.shadow[j].style.height= wnd.scrollHeight;
			wnd.shadow[j].style.left = wnd.offsetLeft+(j+1);
			wnd.shadow[j].style.top = wnd.offsetTop+(j+1);
			wnd.shadow[j].style.backgroundColor = RGB(j*(256/shadowDepth),j*(256/shadowDepth),j*(256/shadowDepth));
		}
	}
	
	for(var j=0; j<shadowDepth; j++) {
		wnd.shadow[j].style.display = '';
	}
}

function hideShadows(wnd) {
	for(var i=0; i<wnd.shadow.length; i++) {
		wnd.shadow[i].style.display = 'none';
	}
}

function RGB(r,g,b) {
	return '#' + byte2Hex(r) + byte2Hex(g) + byte2Hex(b);
}

function byte2Hex(n) {
	var nybHexString = "0123456789ABCDEF";
	return String(nybHexString.substr((n >> 4) & 0x0F,1)) + nybHexString.substr(n & 0x0F,1);
}

function displayAssignedTagsList(personId) {
	var myPanels = document.getElementsByTagName("tr");
	
	for(i=0; i<myPanels.length; i++) {
		if(myPanels[i].getAttribute("name") == 'assignedTagsList') {
			myPanels[i].style.display = 'none';
		}
	}
	var tagInfoRow = document.getElementById("tagInfoFor_"+personId);
	tagInfoRow.style.display = '';
}

function unassignTag() {
	for(var i=0; i<document.frmPeople.elements.length; i++){
		if(document.frmPeople.elements[i].name == 'tag_id[]') {
			if(frmPeople.elements[i].checked) {
				frmPeople.submit();
			}
		}
	}
}

function mapTag(tagid, mac) {
	wndMapTagTitle.innerHTML = tagid + ' [' + mac + ' ]';
	mapImg.style.visibility = 'hidden';
	mapImg.src = 'map_tag.php?tagid='+tagid+'&width=400&height=250';
	wnd = document.getElementById("wndMapTag");
	wnd.style.display = '';
	wnd.style.zIndex = 100;
	wnd.style.left = (document.body.clientWidth-wnd.offsetWidth)/2;
	wnd.style.top = (document.body.clientHeight-wnd.offsetHeight)/2;
	
	dropShadows(wnd, 5);
	
	refreshMap(tagid);
}

function refreshMap(tagid) {
	mapImg.src = '';
	mapImg.src = 'map_tag.php?tagid='+tagid+'&width=400&height=250&'+Math.random();
	timerID = setTimeout('refreshMap('+tagid+')', 5000);
}

function stopRefreshMap() {
	if(timerID) {
		clearTimeout(timerID);
		timerID  = 0;
	}
}

</script>
</head>
<body onLoad="displayAssignedTagsList(document.frmPeople.people.value)">

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
<table width="790" bgcolor="#FFFFFF" cellspacing="0" cellpadding="5">
	<tr>
		<td>NEWT RTLS</td>
	</tr>
</table>
<form name="frmPeople" action="unassign_tag.php" method="post">
<table width="780" bgcolor="#007ec7" cellspacing="1" cellpadding="5">
	<tr>
		<td class="tbl_header">
			People
		</td>
	</tr>
	<tr>
		<td class="tbl_cell">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="tbl_cell">
						<select name="people" size="1" onChange="displayAssignedTagsList(this.value);">
							<?php foreach($people as $person) { ?>
							<option <?php if($person->getId() == $_GET["person_id"]){echo "selected=\"selected\"";} ?> value="<?php echo $person->getId(); ?>"><?php echo $person->getFullName(); ?></option>
							<?php } ?>
						</select>
					</td>
					<td class="tbl_cell" align="right">
						<input type="button" value="Assign a Tag" onClick="showAssignTagWindow()">
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="tbl_header">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="tbl_header">Assigned Tags</td>
					<td align="right" class="tbl_header" style="font-style: italic;">Tag ID [ MAC ]</td>
				</tr>
			</table>
		</td>
	</tr>
	<?php
	foreach($people as $person) {
	$assignedTags = $registry->listAssignedTags($person->getId());
	if($assignedTags) {
	?>
	<tr id="tagInfoFor_<?php echo $person->getId(); ?>" name="assignedTagsList" style="display: none;">
		<td class="tbl_cell">
			<table border="0" width="780" bgcolor="#80bbe8" cellspacing="1" cellpadding="5">
				<?php
				foreach($assignedTags as $item) {
					foreach($tags as $tag) {
						if($item->getTagId() == $tag->getTagId()) {
							$tag_id = $item->getId();
							$item = $tag;
							$item->setId($tag_id);
							reset($tags);
							break;
						}
					}
				?>
				<tr>
					<td class="tbl_cell" width="10" valign="top">
						<input type="checkbox" name="tag_id[]" value="<?php echo $item->getId(); ?>">
					</td>
					<td class="tbl_cell">
						<table width="100%" border="0">
							<tr ondblclick="expandTagDetails(tagDetails_<?php echo $person->getId(); ?>_<?php echo $item->getTagId(); ?>)">
								<td width="35%" class="tbl_cell"><?php echo $item->getTagId() . " [ " . $item->getMAC() . " ]"; ?></td>
								<td class="tbl_cell"><a href="#" onClick="mapTag('<?php echo $item->getTagId(); ?>', '<?php echo $item->getMAC(); ?>')">map it</a></td>
								<td class="tbl_cell" align="right"><a href="#" onclick="expandTagDetails(tagDetails_<?php echo $person->getId(); ?>_<?php echo $item->getTagId(); ?>, this)">details &#187;</a></td>
							</tr>
						</table>
						<div id="tagDetails_<?php echo $person->getId(); ?>_<?php echo $item->getTagId(); ?>" style="display: none;">
							<table border="0" width="100%" bgcolor="#80bbe8" cellspacing="0" cellpadding="0">
								<tr>
									<td class="tbl_cell" colspan="2" style="font-style: italic;">
										<hr>
									</td>
								</tr>
								<tr>
									<td class="tbl_cell" valign="top" width="50%">
										<table border="0" width="100%" cellspacing="2" cellpadding="3">
											<tr>
												<td class="tbl_fieldname">Type&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getType(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Name&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getName(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Battery&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getBattery(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Created on&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getCreatedOn(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Serial Number&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getSerialNumber(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Profile&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getProfile(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Pending&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getPending(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Sw Version&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getSwVersion(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Hw Version&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getHwVersion(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Wlan Firmware&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getWlanFirmware(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">IP&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getIP(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Apmac&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getApmac(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Cmd Result&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getCmdResult(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Hello Counter&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getHelloCounter(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Hello Timestamp&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getHelloTimestamp(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Confirm Counter&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getConfirmCounter(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Confirm Timestamp&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getConfirmTimestamp(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Config ID&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getConfigId(); ?></td>
											</tr>
										</table>
									</td>
									<td class="tbl_cell" valign="top" width="50%">
										<table border="0" width="100%" cellspacing="2" cellpadding="3">
											<tr>
												<td class="tbl_fieldname">Pos X&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getPosX(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Pos Y&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getPosY(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Pos Model ID&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getPosModelId(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Pos Map ID&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getPosMapId(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Pos Zone ID&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getPosY(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Pos Map Name&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getPosMapName(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Pos Quality&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getPosQuality(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Pos Reason&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getPosReason(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Pos Counter&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getPosCounter(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Pos Timestamp&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getPosTimestamp(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Button X&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getButtonX(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Button Y&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getButtonY(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Button Model ID&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getButtonModelId(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Button Map ID&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getButtonMapId(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Button Zone ID&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getButtonZoneId(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Button Map Name&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getButtonMapName(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Button Quality&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getButtonQuality(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Button Reason&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getButtonReason(); ?></td>
											</tr>
											<tr>
												<td class="tbl_fieldname">Button Timestamp&nbsp;</td>
												<td class="tbl_cell"><?php echo $item->getButtonTimestamp(); ?></td>
											</tr>
										</table>
									</td>
								</tr>
							</table>
						</div>
					</td>
				</tr>
				<?php } ?>
			</table>
		</td>
	</tr>
	<?php } else { ?>
	<tr id="tagInfoFor_<?php echo $person->getId(); ?>" name="assignedTagsList" style="display: none;">
		<td class="tbl_cell">
			<i>No assigned tags...</i>
		</td>
	</tr>
	<?php }} ?>
	<tr>
		<td class="tbl_cell">
			<input type="button" value="Unassign Selected" onClick="unassignTag()">
		</td>
	</tr>
</table>
</form>

</center>

<form name="frmAssignTag" method="post" action="assign_tag.php">
<input type="hidden" name="person_id">
<input type="hidden" name="mac">
<table bgcolor="#007ec7" cellspacing="1" cellpadding="2" id="wndAssignTag" style="display: none; position: absolute;">
<tr><td bgcolor="#80bbe8">
<table width="100%" bgcolor="#007ec7" cellspacing="1" cellpadding="5">
	<tr>
		<td class="tbl_header">Assign a Tag</td>
	</tr>
	<tr>
		<td class="tbl_cell">
			<div style="overflow: auto; width: 400px; height: 250px;">
				<table width="100%" bgcolor="#80bbe8" cellspacing="1" cellpadding="5">
					<?php
					$assignedTags = $registry->listAssignedTags();
					$assigned = false;
					$noTags = true;
					foreach($tags as $item) {
						if($assignedTags) {
							foreach($assignedTags as $assignedTag) {
								if($item->getTagId() == $assignedTag->getTagId()) {
									$assigned = true;
									break;
								}
							}
						}
						if($assigned) {
							$assigned = false;
							continue;
						}
						$noTags = false
					?>
					<tr>
						<td class="tbl_cell" width="10">
							<input type="radio" name="tagid" value="<?php echo $item->getTagId(); ?>" onClick="frmAssignTag.mac.value = '<?php echo $item->getMAC(); ?>';">
						</td>
						<td class="tbl_cell">
							<?php echo $item->getTagId() . " [ " . $item->getMAC() . " ]"; ?>
						</td>
					</tr>
					<?php
					}
					if($noTags) { 
					?>
					<tr>
						<td class="tbl_cell">
							<i>No unassigned tags...</i>
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


<table bgcolor="#007ec7" cellspacing="1" cellpadding="2" id="wndMapTag" style="display: none; position: absolute;">
<tr><td bgcolor="#80bbe8">
<table width="100%" bgcolor="#007ec7" cellspacing="1" cellpadding="5">
	<tr>
		<td class="tbl_header">Map Tag - <span id="wndMapTagTitle"></span></td>
	</tr>
	<tr>
		<td class="tbl_cell">
			<img id="mapImg" style="border: 1 solid #80bbe8; width: 400px; height: 250px;" onload="this.style.visibility='visible';">
		</td>
	</tr>
	<tr>
		<td class="tbl_footer" align="right">
			<input type="button" value="Cancel" onClick="closeWindow(wndMapTag);stopRefreshMap();">
		</td>
	</tr>
</table>
</td></tr></table>

</body>
</html>