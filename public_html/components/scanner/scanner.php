<?php
namespace CTI;

require_once './components/page.php';
require_once './components/scanner/ticket_view.php';

class ScannerPage implements Page {
	
	private $context;
	private $state;
	private $form;
	
	function __construct($context) {
		$this->context = $context;
	}

	public function update() {
		
		if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            
            $this->processView();

		} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $this->processUpload();

		} else {

            $this->context->router()->notFound();
        }
	}

	private function processView() {
        $results = $this->context->ticketRepository()->find(10);
		$this->state = new ScannerPageState($results, NULL, ScannerResult::VIEW);
    }

    private function processUpload() {
		$uploadedFile = $_FILES['image'];

		$ticket = $this->context->scannerService()->match($uploadedFile);
		$templates = $this->context->ticketTemplateRepository()->findAll();
	    $tours = $this->context->tourRepository()->findAll();

		$result = ScannerResult::FAILURE;
		if(!is_null($ticket)) {
			$result = ScannerResult::SUCCESS;
		}

		$results = $this->context->ticketRepository()->find(10);
		$this->state = new ScannerPageState($results, $ticket, $result);
		$this->form = new TicketViewComponent($ticket, $templates, $tours);
    }
	
	public function template() : string {
		return 'scanner/scanner.html';
	}
	
	public function context() : array {
		return [
			'state' => $this->state,
			'ticket_form' => $this->form
		];
	}
}

class ScannerResult {
	const VIEW = 'view';
	const SUCCESS = 'success';
	const FAILURE = 'failure';
}

class ScannerPageState {
	public $items;
	public $ticket;
	public $result;

    function __construct(array $items, $ticket, $result) {
		$this->items = $items;
		$this->ticket = $ticket;
		$this->result = $result;
	}
	
	function isView() {
		return strcmp($this->result, ScannerResult::VIEW) === 0;
	}

	function isSuccess() {
		return strcmp($this->result, ScannerResult::SUCCESS) === 0;
	}

	function isFailure() {
		return strcmp($this->result, ScannerResult::FAILURE) === 0;
	}
}

?>