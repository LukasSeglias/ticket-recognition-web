<?php
namespace CTI;

class Touroperator {
	
	private $id;
	private $name;
	
	function __construct($id, $name) {
		$this->id = $id;
		$this->name = $name;
	}
	
	public function id() {
		return $this->id;
	}

	public function name() {
		return $this->name;
	}
	
}
?>