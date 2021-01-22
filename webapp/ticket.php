<html>

<head>
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
 </head>

<body>
<div class="container">
<div class="row">
	<div class="col-lg-12">
		<a href="index.php">Zurück zur Liste</a>
	</div>
</div>
<?php
$id = -1;

if (isset($_GET["idTicket"]) ) {
	$id = $_GET["idTicket"];
}

require_once 'tickets.php';

$ticketing = new Ticketing();
$title = "";
$description = "";
$reported_first = "";
$reporter = "";
$status = "";
$tool = "";

$disabled = "";
if ( $id >= 0 ) {
	$ticket = $ticketing->getTicketById($id);
	if (intval($ticket["idTicket"]) > 0 ) {
		$title = $ticket["title"]; 
		$description = $ticket["description"];
		$reported_first = $ticket["reported_first"];
		$reporter = $ticket["reporter"];
		$status = $ticket["status"];
		$tool = $ticket["toolname"];
		$disabled = "disabled";
	}
}
echo "<div class=\"title\"><h2>Angaben zum Ticket</h2></div>";
echo "<div class=\"row\">";
echo "<div class=\"col-lg-2\">";
echo "<label for=\"title\">Titel</label>";
echo "</div>";
echo "<div class=\"col-lg-2\">";
echo "<input type=\"text\" id=\"title\" value=\"$title\" $disabled>";
echo "</div> </div>";

echo "<div class=\"row\">";
echo "<div class=\"col-lg-2\">";
echo "<label for=\"tool\">Tool</label>";
echo "</div>";
echo "<div class=\"col-lg-2\">";
echo "<input type=\"text\" id=\"tool\" value=\"$tool\" $disabled>";
echo "</div>";
echo "</div>";

echo "<div class=\"row\">";
echo "<div class=\"col-lg-2\">";
echo "<label for=\"reporter\">Berichterstatter</label>";
echo "</div>";
echo "<div class=\"col-lg-2\">";
echo "<input type=\"text\" id=\"reporter\" value=\"$reporter\" $disabled>";
echo "</div>";
echo "</div>";

echo "<div class=\"row\">";
echo "<div class=\"col-lg-2\">";
echo "<label for=\"reported_first\">Einreichdatum</label>";
echo "</div>";
echo "<div class=\"col-lg-2\">";
echo "<input type=\"text\" value=\"$reported_first\" id=\"reported_first\" $disabled>";
echo "</div>";
echo "</div>";

echo "<div class=\"row\">";
echo "<div class=\"col-lg-2\">";
echo "<label for=\"status\">Status</label>";
echo "</div>";
echo "<div class=\"col-lg-2\">";
echo "<input type=\"text\" value=\"$status\" id=\"status\" $disabled>";
echo "</div>";
echo "</div>";

echo "<div class=\"row\">";
echo "<div class=\"col-lg-2\">";
echo "<label for=\"description\">Problembeschreibung</label>";
echo "</div>";
echo "<div class=\"col-lg-8\">";
echo "$description";
echo "</div>";
echo "</div>";

?>
<div class="row">
	<div class="col-lg-4">
		<form action="ticket_switch_status.php" method="POST">
		<input type="hidden" name="status" value="1">
		<input type="hidden" name="idTicket" value="<?php echo $id; ?>">
		<input type="submit" value="Ticket öffnen">
		</form>
	</div>
	<div class="col-lg-4">
		<form action="ticket_switch_status.php" method="POST">
		<input type="hidden" name="status" value="2">
		<input type="hidden" name="idTicket" value="<?php echo $id; ?>">
		<input type="submit" value="Ticket schliessen">
		</form>
	</div>

	<div class="col-lg-4">
		<form action="ticket_switch_status.php" method="POST">
		<input type="hidden" name="status" value="3">
		<input type="hidden" name="idTicket" value="<?php echo $id; ?>">
		<input type="submit" value="Ticket kann nicht gelöst werden">
		</form>
	</div>
</div>

<?php
if ($id > 0 ) {
	echo "<div class=\"title\"><h2>Kommentare</h2></div>";
	$comments = $ticketing->getCommentsById($id);
	for ($i = 0; $i < count($comments); $i++ ) {

		echo "<div class=\"comment card mt-1 mb-1\"> <div class=\"card-body\"><p class=\"small\">" . 
			$comments[$i]["reporter"] . " schrieb am " . 
			$comments[$i]["comment_date"] . ":</p><p> " . 
			$comments[$i]["comment"];
		if ($comments[$i]["fileupload"] !== "" ) {
			echo "<br> <a href=\"" . $comments[$i]["fileupload"] . "\" >" . $comments[$i]["fileupload"] . "</a>";
		}
		echo "</p></div></div>\n";
	}
	
	if ($status != "Offen") {
		$disabled = "disabled";
	} else {
		$disabled = "";
	}
?>
<div class="title"><h2>Eigenen Kommentar verfassen</h2></div>
<form action="comment.php" method="POST" enctype="multipart/form-data" >
<div><input type="hidden" name="idTicket" value="<?php echo $id; ?>" <?php echo $disabled; ?>></div>
<div> <label for="reporter">Kommentator</label>
<input type="text" name="reporter" id="reporter" <?php echo $disabled; ?> ></div>
<div><textarea rows="10" cols="60" name="comment" <?php echo $disabled; ?> ></textarea></div>
<div>
<label for="attachment">Anhang</label>
<input type="file" name="attachment" id="attachment" <?php echo $disabled; ?> >
</div>
<div><input type="submit" value="Absenden" <?php echo $disabled; ?> ></div>
</form>

<?php
}

$generated = date("c");
echo "<div class=\"footer\">Seite erstellt am: $generated </div>";
?>
</div>
</body>
