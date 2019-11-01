<?php
namespace CTI;

class ValidationError {
	
	private $message;
	
	private function __construct($message) {
		$this->message = $message;
	}

	public function message() : string {
		return $this->message;
	}
}
?>