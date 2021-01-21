<?php

if (! isset($_POST["idTicket"] ) ) {
	header('Location: ./');
	exit;
}

$id = intval($_POST["idTicket"]);

if (! isset($_POST["reporter"]) || ! isset($_POST["comment"] ) ) {
	echo "<p>Bitte geben Sie Ihren Namen und einen Kommentar ein!</p>";
	header("Location: ./ticket.php?idTicket=$id");
	exit;
}

require_once 'tickets.php';
$ticketing = new Ticketing();

$ticketing->insertComment($id, $_POST["reporter"], $_POST["comment"]);
header("Location: ./ticket.php?idTicket=$id");
