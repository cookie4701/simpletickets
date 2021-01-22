<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

if (isset($_FILES["attachment"]) && $_FILES["attachment"]["name"] !== "" ) {
	$ticketing->insertCommentWithAttachment($id, $_POST["reporter"], $_POST["comment"], $_FILES["attachment"]);

} else { 
	$ticketing->insertComment($id, $_POST["reporter"], $_POST["comment"]);
}
header("Location: ./ticket.php?idTicket=$id");
