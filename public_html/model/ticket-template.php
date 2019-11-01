<?php
namespace CTI;

class TicketTemplate {
	
	private $id;
	private $key;
	private $touroperator;
	private $textDefinitions;
	private $imageFileExtension;
	
	function __construct($id, $key, $touroperator, $textDefinitions, $imageFileExtension) {
		$this->id = $id;
		$this->key = $key;
		$this->touroperator = $touroperator;
		$this->textDefinitions = $textDefinitions;
		$this->imageFileExtension = $imageFileExtension;
	}
	
	public function id() {
		return $this->id;
	}
	
	public function key() {
		return $this->key;
	}
	
	public function touroperator() {
		return $this->touroperator;
	}
	
	public function textDefinitions() {
		return $this->textDefinitions;
	}

	public function imageFileExtension() {
		return $this->imageFileExtension;
	}

	public function imageFilename() {
		return $this->id . "." . $this->imageFileExtension;
	}
}
?>