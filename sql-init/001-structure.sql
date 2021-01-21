create table tickets (
	idTicket INT NOT NULL AUTO_INCREMENT,
	toolname VARCHAR(100) NOT NULL,
	title VARCHAR(100) NOT NULL,
	reporter VARCHAR(40),
	reported_first DATETIME,
	description TEXT,
	status INT,
	PRIMARY KEY(idTicket)
);

create table comments (
	idComment INT NOT NULL AUTO_INCREMENT,
	idTicket INT NOT NULL,
	reporter VARCHAR(40),
	comment TEXT,
	comment_date DATETIME,
	PRIMARY KEY(idComment)
);

create table ticket_status (
	idStatus INT NOT NULL AUTO_INCREMENT,
	label VARCHAR(100),
	PRIMARY KEY(idStatus)
);

