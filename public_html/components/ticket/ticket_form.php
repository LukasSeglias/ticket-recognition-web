<?php
namespace CTI;

class TicketFormComponent implements Component {
	
	private $state;
	
	function __construct($state) {
		$this->state = $state;
	}
	
	public function template() {
		return 'ticket/ticket_form.html';
	}
	
	public function context() {
		return [
			'ticket' => $this->state->ticket(),
			'mode' => $this->state->mode()
		];
	}
}

class TicketFormComponentState {
	
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