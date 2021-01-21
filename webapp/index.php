<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>

<body>

<div class="container">
<div class="title">
	<h2>
	<?php 
		include_once "config.php";
		echo CConfig::$organization_name . " - " . CConfig::$helpdesk_unit;
	?>
	</h2>
</div>
<div><a href="ticket_new.php">Neues Ticket anlegen</a></div>
<?php

	include_once 'tickets.php';
	$ticketing = new Ticketing();
	$tickets = $ticketing->getAllTickets();
	if (count($tickets) > 0 ) {
		echo "<table class=\"table table-striped\"><tr><td>Datum</td><td>Tool</td><td>Titel</td><td>Reporter</td><td>Status</td></tr>";
	}
	for ($i = 0; $i < count($tickets); $i++ ) {
		echo "<tr>";
		echo "<td>" . $tickets[$i]['reported_first'] . "</td>";
		echo "<td>" . $tickets[$i]['toolname'] . "</td>";
		echo "<td> <a href=\"ticket.php?idTicket=". $tickets[$i]['idTicket'] . "\">" . $tickets[$i]['title'] . "</a></td>";
		echo "<td>" . $tickets[$i]['reporter'] . "</td>";
		echo "<td>" . $tickets[$i]['status'] . "</td>";
		echo "</tr>";
	}

	if (count($tickets) > 0 ) {
		echo "</table>";
	}
?>
</div>
</body>

