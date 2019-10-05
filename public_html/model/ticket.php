<?php
namespace CTI;

class Ticket {
	
	private $number;
	private $touroperator;
	private $tourcode;
	private $date;
	private $positions;
	
	function __construct($number, $touroperator, $tourcode, $date, $positions) {
		$this->number = $number;
		$this->touroperator = $touroperator;
		$this->tourcode = $tourcode;
		$this->date = $date;
		$this->positions = $positions;
	}
	
	public function number() {
		return $this->number;
	}
	
	public function touroperator() {
		return $this->touroperator;
	}
	
	public function tourcode() {
		return $this->tourcode;
	}
	
	public function date() {
		return $this->date;
	}
	
	public function positions() {
		return $this->positions;
	}
}

class TicketPosition {
	
	private $number;
	private $title;
	
	function __construct($number, $title) {
		$this->number = $number;
		$this->title = $title;
	}
	
	public function number() {
		return $this->number;
	}
	
	public function title() {
		return $this->title;
	}
}
?>