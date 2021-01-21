INSERT INTO ticket_status (idStatus, label) VALUES (1, 'Offen'), (2, 'Erledigt'), (3, 'Kann nicht behoben werden');

INSERT INTO tickets (idTicket, toolname, title, reporter, reported_first, description, status) VALUES 
	(1, 'Tool Alpha', 'Test 1', 'A Tester', NOW(), 'Dies ist der erste Eintrag', 1),
	(2, 'Tool Beta', 'Test 2', 'B Tester', NOW(), 'Dies ist der zweite Test', 1);

INSERT INTO comments (idTicket, reporter, comment, comment_date) VALUES 
	(1, 'C Tester', 'Dies ist ein Kommentar von C', NOW() ),
	(1, 'D Tester', 'Dies ist ein Kommentar von D', NOW() ),
	(2, 'E Tester', 'Dies ist ein Kommentar von E', NOW() ),
	(2, 'F Tester', 'Dies ist ein Kommentar von F', NOW() );
