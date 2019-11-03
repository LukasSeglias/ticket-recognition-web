<?php
namespace CTI;

require_once './components/page.php';
require_once './repository/tour-position.php';

class TourpositionSearchPage implements Page {
	
	private $context;
	private $state;
	
	function __construct($context) {
		$this->context = $context;
	}

	public function update() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$filter = new TourpositionSearchPageFilter($_POST['description'], $_POST['code']);
			$results = $this->context->tourPositionRepository()->findBy($filter->description, $filter->code);
			$this->state = new TourpositionSearchPageState($results, $filter);
		} else {
			$this->state = new TourpositionSearchPageState([], new TourpositionSearchPageFilter(NULL, NULL));
		}
	}
	
	public function template() : string {
		return 'tour-positions/tour-positions.html';
	}
	
	public function context() : array {
		return [
			'state' => $this->state
		];
	}
}

class TourpositionSearchPageState {
	public $items;
	public $filter;

	function __construct(array $items, TourpositionSearchPageFilter $filter) {
		$this->items = $items;
		$this->filter = $filter;
	}
}

class TourpositionSearchPageFilter {
	public $code;
	public $description;

	function __construct($description, $code) {
		$this->description = $description;
		$this->code = $code;
	}
}

?>