<?php

if (!isset($_POST["status"]) || ! isset($_POST["idTicket"]) ) {
	header("Location: ./");
	exit;
}

require_once "tickets.php";

$ticketing = new Ticketing();
$ticketing->changeTicketStatus($_POST["idTicket"], $_POST["status"]);
header("Location: ./ticket.php?idTicket=" . $_POST["idTicket"]);
