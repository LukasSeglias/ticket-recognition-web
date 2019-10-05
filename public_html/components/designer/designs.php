<?php
namespace CTI;

require_once './components/page.php';

class DesignSearchPage implements Page {
	
	private $context;
	
	function __construct($context) {
		$this->context = $context;
	}

	public function update() {
		
	}
	
	public function template() : string {
		return 'designer/designs.html';
	}
	
	public function context() : array {
		return [
			
		];
	}
}
?>