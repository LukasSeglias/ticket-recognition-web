<?php
namespace CTI;

class TextDefinition {
	
	private $id;
	private $key;
	private $ticketTemplateId;
	private $description;
	private $rectangle;
	
	function __construct($id, $key, $ticketTemplateId, $description, $rectangle) {
		$this->id = $id;
		$this->key = $key;
		$this->ticketTemplateId = $ticketTemplateId;
		$this->description = $description;
		$this->rectangle = $rectangle;
	}
	
	public function id() {
		return $this->id;
	}
	
	public function key() {
		return $this->key;
	}
	
	public function ticketTemplateId() {
		return $this->ticketTemplateId;
	}
	
	public function description() {
		return $this->description;
	}
	
	public function rectangle() : Rectangle {
		return $this->rectangle;
	}
}

class Rectangle {
	
	private $x;
	private $y;
	private $width;
	private $height;
	
	function __construct($x, $y, $width, $height) {
		$this->x = $x;
		$this->y = $y;
		$this->width = $width;
		$this->height = $height;
	}
	
	public function x() {
		return $this->x;
	}
	
	public function y() {
		return $this->y;
	}
	
	public function width() {
		return $this->width;
	}
	
	public function height() {
		return $this->height;
	}
}
?>