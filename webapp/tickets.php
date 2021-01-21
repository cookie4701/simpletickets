<?php

require_once 'db.php';

class Ticketing {
	private $dbconn;

	public function __construct() {
		$this->dbconn = db_connect();
	}

	public function changeTicketStatus($ticket, $status) {
		$sql = "UPDATE tickets SET status=? WHERE idTicket=?";
		$stmt = $this->dbconn->stmt_init();
		if ($stmt->prepare($sql) && 
			$stmt->bind_param("ii", $status, $ticket) &&
			$stmt->execute() )
		{
			$stmt->close();
			if ($status == 1) $this->insertComment($ticket, "System", "Der neue Status lautet jetzt 'Offen'");
			if ($status == 2) $this->insertComment($ticket, "System", "Das Ticket wurde geschlossen.");
			if ($status == 3) $this->insertComment($ticket, "System", "Der neue Status lautet jetzt 'Kann nicht behoben werden'");

		}
	}

	public function insertComment($id, $reporter, $comment) {
		$sql = "INSERT INTO comments 
			(idTicket, reporter, comment, comment_date) VALUES
			(?, ?, ?, NOW())";
		$stmt = $this->dbconn->stmt_init();
		if ( $stmt->prepare($sql) && 
			$stmt->bind_param("iss", $id, $reporter, $comment) && 
			$stmt->execute() 
		) {
			$stmt->close();
		}
	}

	private function makeCommentArray($reporter, $comment, $comment_date) {
		$arr = array();
		$arr["reporter"] = $reporter;
		$arr["comment"] = $comment;
		$arr["comment_date"] = $comment_date;
		return $arr;
	}

	public function getCommentsById($id) {
		$stmt = $this->dbconn->stmt_init();
		$comments = array();
		$sql = "SELECT reporter, comment, comment_date FROM comments WHERE idTicket=? ORDER BY comment_date ASC";
		if ( $stmt->prepare($sql) && 
			$stmt->bind_param("i", $id) && 
			$stmt->execute() &&
			$stmt->bind_result($reporter, $comment, $comment_date)
		) {
			while ($stmt->fetch() ) {
				$comments[] = $this->makeCommentArray($reporter, $comment, $comment_date);
			}

			$stmt->close();
		} else {
			echo $stmt->error;
		}


		return $comments;
		
	
	}

	public function createTicket($title, $description, $tool, $reporter) {
		$stmt = $this->dbconn->stmt_init();
		$sql = "INSERT INTO tickets (toolname, title, reporter, reported_first, description, status) 
			VALUES (?, ?, ?, NOW(), ?, 1)";
		if ( $stmt->prepare($sql) &&
			$stmt->bind_param("ssss", $tool, $title, $reporter, $description) &&
			$stmt->execute() )
		{
			$stmt->close();
		}
	}

	public function getTicketById($id) {
		$stmt = $this->dbconn->stmt_init();
		$arr = $this->makeDatasetTicketDetail(); 

		$sql = "SELECT idTicket, toolname, title, reporter, reported_first, B.label AS status, description 
			FROM tickets AS A
			LEFT JOIN ticket_status AS B 
			ON A.status = B.idStatus  
			WHERE idTicket=?";
		if ( $stmt->prepare($sql) && 
			$stmt->bind_param("i", $id) &&
			$stmt->execute() && 
			$stmt->bind_result($idTicket, $toolname, $title, $reporter, $reported_first, $status, $description)
		) {
			if ($stmt->fetch() ) {
				$arr['idTicket'] = $idTicket;
				$arr['toolname'] = $toolname;
				$arr['title'] = $title;
				$arr['reporter'] = $reporter;
				$arr['reported_first'] = $reported_first;
				$arr['status'] = $status;
				$arr['description'] = $description;
			} else {
				$arr['title'] = 'oh no';
			}

			$stmt->close();
			return $arr;
		} else {
			echo "<p>" . $stmt->error . "</p>";
		}

		return $arr;
	}

	private function makeDatasetTicketDetail() {
	
		$arr = array();
		$arr['idTicket'] = -1;
		$arr['toolname'] = "";
		$arr['title'] = "";
		$arr['reporter'] = "";
		$arr['reported_first'] = "";
		$arr['status'] = "";
		$arr['description'] = "";
		return $arr;
	}

	public function getAllTickets() {
		$stmt = $this->dbconn->stmt_init();

		$sql = "SELECT idTicket, toolname, title, reporter, reported_first, B.label AS status 
			FROM tickets AS A
			LEFT JOIN ticket_status AS B 
			ON A.status = B.idStatus
			ORDER BY reported_first DESC ";
		if ( $stmt->prepare($sql) && 
			$stmt->execute() && 
			$stmt->bind_result($idTicket, $toolname, $title, $reporter, $reported_first, $status)
		) {
			$arr = array();
			$index = 0;
			while ($stmt->fetch() ) {

				$arr[] = array();
				$arr[$index]['idTicket'] = $idTicket;
				$arr[$index]['toolname'] = $toolname;
				$arr[$index]['title'] = $title;
				$arr[$index]['reporter'] = $reporter;
				$arr[$index]['reported_first'] = $reported_first;
				$arr[$index]['status'] = $status;
				$index++;
			}
		} else {
			return array();
		}

		$stmt->close();
		return $arr;
	}
}
