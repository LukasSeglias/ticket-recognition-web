<?php
namespace CTI;

class Ticket {
	
	private $id;
	private $template;
	private $tour;
	private $scanDate;
	private $positions;
	
	function __construct($id, $template, $tour, $scanDate, $positions) {
		$this->id = $id;
		$this->template = $template;
		$this->tour = $tour;
		$this->scanDate = $scanDate;
		$this->positions = $positions;
	}
	
	public function id() {
		return $this->id;
	}
	
	public function template() {
		return $this->template;
	}
	
	public function tour() {
		return $this->tour;
	}
	
	public function scanDate() {
		return $this->scanDate;
	}
	
	public function positions() {
		return $this->positions;
	}
}
?>