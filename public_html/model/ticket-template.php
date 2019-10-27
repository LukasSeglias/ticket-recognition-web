<?php
namespace CTI;

class TicketTemplate {
	
	private $id;
	private $key;
	private $touroperator;
	private $textDefinitions;
	private $imageFilename;
	
	function __construct($id, $key, $touroperator, $textDefinitions, $imageFilename) {
		$this->id = $id;
		$this->key = $key;
		$this->touroperator = $touroperator;
		$this->textDefinitions = $textDefinitions;
		$this->imageFilename = $imageFilename;
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

	public function imageFilename() {
		return $this->imageFilename;
	}
}
?>