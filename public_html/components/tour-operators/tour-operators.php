<?php
namespace CTI;

require_once './components/page.php';
require_once './repository/tour-operator.php';

class TouroperatorSearchPage implements Page {
	
	private $context;
	private $state;
	
	function __construct($context) {
		$this->context = $context;
	}

	public function update() {
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$filter = new TouroperatorSearchPageFilter($_POST['name']);
			$results = $this->context->touroperatorRepository()->findBy($filter->name);
			$this->state = new TouroperatorSearchPageState($results, $filter);
		} else {
			$this->state = new TouroperatorSearchPageState([], new TouroperatorSearchPageFilter(NULL));
		}
	}
	
	public function template() : string {
		return 'tour-operators/tour-operators.html';
	}
	
	public function context() : array {
		return [
			'state' => $this->state
		];
	}
}

class TouroperatorSearchPageState {
	public $items;
	public $filter;

	function __construct(array $items, TouroperatorSearchPageFilter $filter) {
		$this->items = $items;
		$this->filter = $filter;
	}
}

class TouroperatorSearchPageFilter {
	public $name;

	function __construct($name) {
		$this->name = $name;
	}
}

?>