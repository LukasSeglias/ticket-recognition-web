<?php
namespace CTI;

require_once './components/page.php';

class TicketSearchPage implements Page {
	
	private $context;
    private $state;
	
	function __construct($context) {
		$this->context = $context;
	}

	public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tourcode = strip_tags($_POST['tourcode']);
            $filter = new TicketSearchPageFilter($tourcode);
            $results = $this->context->ticketRepository()->findBy($filter->code);
            $this->state = new TicketSearchPageState($results, $filter);
        } else {
            $this->state = new TicketSearchPageState([], new TicketSearchPageFilter(NULL));
        }
	}
	
	public function template() : string {
		return 'ticket/tickets.html';
	}
	
	public function context() : array {
		return [
            'state' => $this->state
		];
	}
}

class TicketSearchPageState {
    public $items;
    public $filter;

    function __construct(array $items, TicketSearchPageFilter $filter) {
        $this->items = $items;
        $this->filter = $filter;
    }
}

class TicketSearchPageFilter {
    public $code;

    function __construct($code) {
        $this->code = $code;
    }
}

?>