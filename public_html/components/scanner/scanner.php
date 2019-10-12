<?php
namespace CTI;

require_once './components/page.php';

class ScannerPage implements Page {
	
	private $context;
	
	function __construct($context) {
		$this->context = $context;
	}

	public function update() {
		
	}
	
	public function template() : string {
		return 'scanner/scanner.html';
	}
	
	public function context() : array {
		return [
			
		];
	}
}
?>