<?php
namespace CTI;

class TicketPositionListComponent implements Component {
	
	private $state;
	
	function __construct($state) {
		$this->state = $state;
	}
	
	public function template() {
		return 'ticket/ticketposition_list.html';
	}
	
	public function context() {
		return [
			'ticket' => $this->state->ticket(),
			'mode' => $this->state->mode()
		];
	}
}

class TicketPositionListComponentState {
	
	private $ticket;
	private $mode;
	
	function __construct($ticket, $mode) {
		$this->ticket = $ticket;
		$this->mode = $mode;
	}
	
	public function ticket() {
		return $this->ticket;
	}
	
	public function mode() {
		return $this->mode;
	}
	
}
?>