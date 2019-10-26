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
			$results = $this->context->tourPositionRepository()->findBy($filter->description(), $filter->code());
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
			'items' => $this->state->items(),
			'filter' => $this->state->filter()
		];
	}
}

class TourpositionSearchPageState {
	private $items;
	private $filter;

	function __construct(array $items, $filter) {
		$this->items = $items;
		$this->filter = $filter;
	}

	public function items() : array {
		return $this->items;
	}

	public function filter() : TourpositionSearchPageFilter {
		return $this->filter;
	}
}

class TourpositionSearchPageFilter {
	private $code;
	private $description;

	function __construct($description, $code) {
		$this->description = $description;
		$this->code = $code;
	}

	public function code() {
		return $this->code;
	}

	public function description() {
		return $this->description;
	}
}

?>