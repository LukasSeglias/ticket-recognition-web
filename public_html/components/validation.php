<?php
namespace CTI;

class ValidationResult {
	
	private $validated;
	private $valid;
	private $message;
	
	public static function valid() {
		return new ValidationResult(true, true, null);
	}
	
	public static function invalid(string $message) {
		return new ValidationResult(true, false, $message);
	}
	
	public static function none() {
		return new ValidationResult(false, false, null);
	}
	
	private function __construct($validated, $valid, $message) {
		$this->validated = $validated;
		$this->valid = $valid;
		$this->message = $message;
	}
	
	public function isValid() {
		return $this->validated && $this->valid;
	}
	
	public function isInvalid() {
		return $this->validated && !$this->valid;
	}
	
	public function message() : string {
		return $this->message;
	}
}
?>