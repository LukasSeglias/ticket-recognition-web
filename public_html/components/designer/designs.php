<?php
namespace CTI;

require_once './components/page.php';

class DesignSearchPage implements Page {
	
	private $context;
	private $state;
	
	function __construct($context) {
		$this->context = $context;
	}

	public function update() {
		
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$key = strip_tags($_POST['key']);
			$filter = new DesignSearchPageFilter($key);
			$results = $this->context->ticketTemplateService()->findBy($filter->key);
			$this->state = new DesignSearchPageState($results, $filter);
		} else {
			$templates = $this->context->ticketTemplateService()->findAll();
			$this->state = new DesignSearchPageState($templates, new DesignSearchPageFilter(NULL));
		}
	}
	
	public function template() : string {
		return 'designer/designs.html';
	}
	
	public function context() : array {
		return [
			'state' => $this->state
		];
	}
}

class DesignSearchPageState {

	public $items;
	public $filter;

	function __construct($items, $filter) {
		$this->items = $items;
		$this->filter = $filter;
	}
}

class DesignSearchPageFilter {
	public $key;

	function __construct($key) {
		$this->key = $key;
	}
}
?>