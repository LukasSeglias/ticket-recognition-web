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
		$templates = $this->context->ticketTemplateService()->findAll();
		$this->state = new DesignSearchPageState($templates);
	}
	
	public function template() : string {
		return 'designer/designs.html';
	}
	
	public function context() : array {
		return [
			'templates' => $this->state->templates()
		];
	}
}

class DesignSearchPageState {

	private $templates;

	function __construct($templates) {
		$this->templates = $templates;
	}

	public function templates() : Array {
		return $this->templates;
	}
}
?>