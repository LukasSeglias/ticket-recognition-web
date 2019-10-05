<?php
namespace CTI;

require_once './components/page.php';
require_once './components/crud_mode.php';
require_once './components/ticket/ticket_form.php';
require_once './components/ticket/ticketposition_list.php';
require_once './model/ticket.php';

class TicketDetailPage implements Page {
	
	private $context;
	private $state;
	
	function __construct($context) {
		$this->context = $context;
	}

	public function update() {
		$ticketNumber = $_GET['number'];
		if($ticketNumber !== NULL) {

			$ticket = $this->context->ticketService()->ticket($ticketNumber);
			if($ticket !== NULL) {

				$this->state = new TicketDetailComponentState($ticket, CrudMode::edit());

			} else {
				$this->context->router()->redirect('/tickets.php');
			}
		} else {
			$this->state = new TicketDetailComponentState($ticket, CrudMode::create());
		}
	}
	
	public function template() : string {
		return 'ticket/ticket_detail.html';
	}
	
	public function context() : array {
		return [
			'ticketForm' => new TicketFormComponent(new TicketFormComponentState(
				$this->state->ticket(), $this->state->mode()
			)),
			'ticketpositionList' => new TicketpositionListComponent(new TicketPositionListComponentState(
				$this->state->ticket(), $this->state->mode()
			))
		];
	}
}


class TicketDetailComponentState {
	
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