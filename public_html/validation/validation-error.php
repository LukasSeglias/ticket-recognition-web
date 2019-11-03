<?php
namespace CTI;

class ValidationError {
	
	private $message;
	
	public function __construct($message) {
		$this->message = $message;
	}

	public function message() : string {
		return $this->message;
	}
}
?>