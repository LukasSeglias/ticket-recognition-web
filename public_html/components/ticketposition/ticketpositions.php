<?php
namespace CTI;

require_once './components/page.php';

class TicketpositionSearchPage implements Page {
	
	private $context;
	private $state;
	
	function __construct($context) {
		$this->context = $context;
	}

	public function update() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$filter = new TicketpositionSearchPageFilter($_POST['code']);
			$this->state = new TicketpositionSearchPageState(['value'], $filter);
		} else {
			$this->state = new TicketpositionSearchPageState(['test'], new TicketpositionSearchPageFilter(NULL));
		}
	}
	
	public function template() : string {
		return 'ticketposition/ticketpositions.html';
	}
	
	public function context() : array {
		return [
			'items' => $this->state->items()
		];
	}
}

class TicketpositionSearchPageState {
	private $items;
	private $filter;

	function __construct(array $items, $filter) {
		$this->items = $items;
		$this->filter = $filter;
	}

	public function items() : array {
		return $this->items;
	}

	public function filter() : TicketpositionSearchPageFilter {
		return $this->filter;
	}
}

class TicketpositionSearchPageFilter {
	private $code;

	function __construct($code) {
		$this->code = $code;
	}

	public function code() : string {
		return $this->code;
	}
}

?>