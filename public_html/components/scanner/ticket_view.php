<?php
namespace CTI;

require_once './components/component.php';

class TicketViewComponent implements Component {
	
	private $ticket;
	private $templates;
	private $tours;
	
	function __construct($ticket, $templates, $tours) {
		$this->ticket = $ticket;
		$this->templates = $templates;
		$this->tours = $tours;
	}
	
	public function template() : string {
		return 'scanner/ticket_view.html';
	}
	
	public function context() : array {
		return [
			'ticket' => $this->ticket,
			'templates' => $this->templates,
			'tours' => $this->tours
		];
	}
}
?>