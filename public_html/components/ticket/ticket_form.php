<?php
namespace CTI;

require_once './components/component.php';
require_once './components/crud_mode.php';
require_once './model/ticket.php';

class TicketFormComponent implements Component {
	
	private $state;
	
	function __construct(TicketFormComponentState $state) {
		$this->state = $state;
	}
	
	public function template() : string {
		return 'ticket/ticket_form.html';
	}
	
	public function context() : array {
		return [
			'ticket' => $this->state->ticket(),
			'mode' => $this->state->mode()
		];
	}
}

class TicketFormComponentState {
	
	private $ticket;
	private $mode;
	
	function __construct(Ticket $ticket, CrudMode $mode) {
		$this->ticket = $ticket;
		$this->mode = $mode;
	}
	
	public function ticket() : Ticket {
		return $this->ticket;
	}
	
	public function mode() : CrudMode {
		return $this->mode;
	}
	
}
?>