<html>

<head>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script src="js/jquery-3.5.1.min.js"></script>
	<script src="js/Filter.js"></script>	
	<link href="css/Filter.css" rel="stylesheet" id="bootstrap-css">	
</head>

<body>

<div class="container">
<div class="row">
	<div class="col-lg-12">
<div class="title">
	<h2>
	<?php 
		include_once "config.php";
		echo CConfig::$organization_name . " - " . CConfig::$helpdesk_unit;
	?>
	</h2>
</div>

</div>
</div>

<div class="row">
	<div class="col-lg-12"><a href="ticket_new.php">Neues Ticket anlegen</a></div>
</div>
<?php

	include_once 'tickets.php';
	$ticketing = new Ticketing();
	$tickets = $ticketing->getAllTickets();
	if (count($tickets) > 0 ) {
		echo "<div class=\"row filterable\"> \n";
		echo "<button class=\"btn btn-default btn-xs btn-filter\">\n";
		echo "<span class=\"glyphicon glyphicon-filter\"></span>Filtern</button> \n";
		echo "<table id=\"tickets\" class=\"table table-striped\">";
		
?>
<thead>
	<tr class="filters">
		<th><input type="text" class="form-control" placeholder="YYYY-MM-DD" disabled> </th>
		<th><input type="text" class="form-control" placeholder="Tool..." disabled> </th>
		<th><input type="text" class="form-control" placeholder="Titel..." disabled> </th>
		<th><input type="text" class="form-control" placeholder="Reporter..." disabled> </th>
		<th><input type="text" class="form-control" placeholder="Status..." disabled> </th>
	</tr>	
<tbody>
<?php
	}
	for ($i = 0; $i < count($tickets); $i++ ) {
		echo "<tr>";
		echo "<td>" . $tickets[$i]['reported_first'] . "</td>";
		echo "<td>" . $tickets[$i]['toolname'] . "</td>";
		echo "<td> <a href=\"ticket.php?idTicket=". $tickets[$i]['idTicket'] . "\">" . $tickets[$i]['title'] . "</a></td>";
		echo "<td>" . $tickets[$i]['reporter'] . "</td>";
		echo "<td class=\"cell_status\">" . $tickets[$i]['status'] . "</td>";
		echo "</tr>";
	}

	if (count($tickets) > 0 ) {
		echo "</tbody>";
		echo "</table>";
		echo "</div>";
	}
?>
</div>
</body>
