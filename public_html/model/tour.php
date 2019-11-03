<?php
namespace CTI;

class Tour {
	
	private $id;
	private $description;
	private $code;
	private $tourpositions;
	
	function __construct($id, $description, $code, $tourpositions) {
		$this->id = $id;
		$this->description = $description;
		$this->code = $code;
		$this->tourpositions = $tourpositions;
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
	
	public function tourpositions() {
		return $this->tourpositions;
	}
}
?>