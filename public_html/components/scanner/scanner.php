<?php
namespace CTI;

require_once './components/page.php';

class ScannerPage implements Page {
	
	private $context;
	private $state;
	
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
		$this->state = new ScannerPageState($results);
    }

    private function processUpload() {
		$uploadedFile = $_FILES['image'];
		var_dump($uploadedFile);

		$results = $this->context->ticketRepository()->find(10);
		$this->state = new ScannerPageState($results);
    }
	
	public function template() : string {
		return 'scanner/scanner.html';
	}
	
	public function context() : array {
		return [
			'state' => $this->state
		];
	}
}

class ScannerPageState {
    public $items;

    function __construct(array $items) {
        $this->items = $items;
    }
}

?>