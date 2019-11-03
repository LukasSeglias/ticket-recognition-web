<?php
namespace CTI;

require_once './components/page.php';

class TourSearchPage implements Page {
	
	private $context;
	private $state;
	
	function __construct($context) {
		$this->context = $context;
	}

	public function update() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$filter = new TourSearchPageFilter($_POST['code'], $_POST['description']);
			$results = $this->context->tourRepository()->findBy($filter->code, $filter->description);
			$this->state = new TourSearchPageState($results, $filter);
		} else {
			$this->state = new TourSearchPageState([], new TourSearchPageFilter(NULL, NULL));
		}
	}
	
	public function template() : string {
		return 'tours/tours.html';
	}
	
	public function context() : array {
		return [
			'state' => $this->state
		];
	}
}

class TourSearchPageState {
	public $items;
	public $filter;

	function __construct(array $items, TourSearchPageFilter $filter) {
		$this->items = $items;
		$this->filter = $filter;
	}
}

class TourSearchPageFilter {
	public $code;
	public $description;

	function __construct($code, $description) {
		$this->code = $code;
		$this->description = $description;
	}
}

?>