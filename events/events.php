<?php
require_once "../lib/Tracker.class.php";

$tracker = new Tracker("192.168.1.10", "8550", "rtls_user", "welcome");

if($events = $tracker->getEvents(null, $_GET["numlatest"])) {
	foreach($events as $event) {
?>
<tr>
	<td class="tbl_cell">
		<?=$event->getEventId(); ?>
	</td>
	<td class="tbl_cell">
		<?=$event->getEventType() . " (" . $event->getRuleId() . ")"; ?>
	</td>
	<td class="tbl_cell">
		<?=substr($event->getPosTimestamp(), 0, strlen($event->getPosTimestamp())-5); ?>
	</td>
	<td class="tbl_cell">
		<?php echo $event->getTagId() . "<br>[ " . $event->getMAC() . " ]"; ?>
	</td>
	<td class="tbl_cell">
		<?=$event->getName(); ?>
	</td>
	<td class="tbl_cell">
		<?=$event->getType(); ?>
	</td>
	<td class="tbl_cell">
		<?=$event->getPosMapName() . " (" . $event->getPosZoneId() . ")"; ?>
	</td>
</tr>
<?php
	}
}
?>