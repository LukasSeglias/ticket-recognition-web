<?php
namespace CTI;

class Tour {
	
	private $id;
	private $description;
	private $code;
	
	function __construct($id, $description, $code) {
		$this->id = $id;
		$this->description = $description;
		$this->code = $code;
	}
	
	public function id() {
		return $this->id;
	}

	public function description() {
		return $this->description;
	}

	public function code() {
		return $this->code;
	}
	
}
?>