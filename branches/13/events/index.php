<html>
<head>
<title>Events Log</title>
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

.tbl_cell_white {
background-color: #ffffff;
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
<script type="text/javascript" src="/lib/prototype.js"></script>
<script type="text/javascript">

function expandTagDetails(panel, label) {
	if(panel.style.display == 'none') {
		label.innerHTML = "hide &#171;";
		panel.style.display = '';
	} else {
		panel.style.display = 'none';
		label.innerHTML = "details &#187;";
	}
}

function getEvents() {
	/*
	new Ajax.Request('http://localhost:10000/', {
		method:'get',
		requestHeaders: {Accept: 'application/json'},
		onInteractive: function(transport){
			//var json = transport.responseText.evalJSON(true);
			alert("it works");
		}
	});
	*/
	var prevResponse = "";
	var test = new Ajax.PeriodicalUpdater('logger', '/events/events.php?numlatest=1', {
		method: 'get',
		requestHeaders: {Accept: 'text/xml'},
		insertion: Insertion.After,
		frequency: 1,
		decay: 2,
		onInteractive: function(transport){
			if(prevResponse == transport.responseText) {
				test.stop();
				test.start();
			}
		},
		onSuccess: function(transport){
			prevResponse = transport.responseText;
		}
	});
}

</script>
</head>
<body onLoad="getEvents()">

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
			<a href="/people">People</a>
			Events
		</td>
	</tr>
	<tr>
		<td class="tbl_cell">
			<table width="100%" cellpadding="0" cellspacing="0">
				<tr>
					<td class="tbl_cell">
						<table width="100%" bgcolor="#007ec7" cellspacing="1" cellpadding="5">
							<tr>
								<td class="tbl_cell_white">
									<table border="0" width="780" bgcolor="#80bbe8" cellspacing="1" cellpadding="5">
										<tr id="logger">
											<td class="tbl_header" width="5%">ID</td>
											<td class="tbl_header" width="20%">Type (Rule)</td>
											<td class="tbl_header" width="20%">Timestamp</td>
											<td class="tbl_header" width="20%">Tag [ MAC ]</td>
											<td class="tbl_header" width="10%">Person</td>
											<td class="tbl_header" width="5%">Device</td>
											<td class="tbl_header" width="20%">Map (Zone)</td>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td class="tbl_cell">
			<input type="button" value="Refresh" onClick="">
		</td>
	</tr>
</table>
</form>

</center>

</body>
</html>