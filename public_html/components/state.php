<?php
namespace CTI;

require_once './components/validation.php';

class InputComponentState {
	
	private $value;
	private $validationResult;
	private $disabled;
	
	function __construct($value, ValidationResult $validationResult, $disabled) {
		$this->value = $value;
		$this->validationResult = $validationResult;
		$this->disabled = $disabled;
	}

	public function value() {
		return $this->value;
	}
	
	public function validationResult() : ValidationResult {
		return $this->validationResult;
	}
	
	public function disabled() {
		return $this->disabled;
	}
}
?>