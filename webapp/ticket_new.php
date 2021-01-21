<?php
$title = "";
$description = "";
$reporter = "";
$tool = "";
$msg = "";
if (isset($_POST["title"]) ) {
	$title = $_POST["title"];
} else {
	$msg .= "<p>Bitte geben Sie einen Titel an!</p>";
}

if (isset($_POST["description"]) ) {
	$description = $_POST["description"];
} else {
	$msg .= "<p>Bitte geben Sie eine Beschreibung an!</p>";
}

if (isset($_POST["tool"]) ) {
	$tool = $_POST["tool"];
} else {
	$msg .= "<p>Bitte geben Sie ein Tool an!</p>";
}

if (isset($_POST["reporter"]) ) {
	$reporter = $_POST["reporter"];
} else {
	$msg .= "<p>Bitte geben Sie einen Bericherstatter an!</p>";
}

require_once 'tickets.php';

$ticketing = new Ticketing();

if ($msg == "") {
	$ticketing->createTicket($title, $description, $tool, $reporter);
	header("Location: ./");
	exit;
} else {
	if (isset($_POST["formsubmission"]) )
		echo "<p>Bitte füllen Sie alle Felder aus!</p>$msg";
}

?>
<head>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>

<div class="container">
<div class="row">
	<div class="col-lg-4">
		<h2>Neues Ticket anlegen
	</div>
</div>

<form method="POST">
<div class="row">
	<div class="col-lg-2">
		<label for="tool">Tool</label>
	</div>
	<div class="col-lg-2">
		<input id="tool" name="tool" type="text" value="<?php echo $tool; ?>" >
	</div>
</div>
<div class="row">
	<div class="col-lg-2">
		<label for="title">Titel</label>
	</div>
	<div class="col-lg-2">
		<input id="title" name="title" type="text" value="<?php echo $title; ?>" >
	</div>
</div>
<div class="row">
	<div class="col-lg-2">
		<label for="description">Beschreibung</label>
	</div>
	<div class="col-lg-2">
		<textarea rows="10" cols="50" id="description" name="description"><?php echo $description; ?></textarea> 
	</div>
</div>
<div class="row">
	<div class="col-lg-2">
		<label for="reporter">Berichterstatter</label>
	</div>
	<div class="col-lg-2">
		<input id="reporter" name="reporter" type="text" value="<?php echo $reporter; ?>" >
	</div>
</div>
<div class="row">
	<div class="col-lg-4">
		<input type="hidden" name="formsubmission" value="1">
		<input type="submit" value="Absenden">
	</div>
</div>
</form>
