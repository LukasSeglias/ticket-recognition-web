<?php
namespace CTI;

require_once './model/ticket.php';

class TicketService {
	
	private $databaseService; 

	function __construct($databaseService) {
		$this->databaseService = $databaseService;
	}
	
	public function ticket($ticketNumber) : Ticket {
		// TODO: insert real implementation
		if($ticketNumber === "1203") {
			return new Ticket(1203, 'TO 3B', 'TC765', '2019-09-27', [
				new TicketPosition("B6123", "Bootsfahrt auf dem Bodensee"),
				new TicketPosition("C2443", "Romantisches Abendessen"),
				new TicketPosition("A1236", "Tageskarte Seilbahn")
			]);
		} else {
			$statement = $context->pdo()->prepare("SELECT * FROM TOUR_OPERATOR");
			$statement->execute(array());
			echo "ROWCOUNT: ". $statement->rowCount();
			while($row = $statement->fetch()) {
				echo "ROW: "." ".$row['ID'];
			}
			return NULL;
		}
	}

}

?>