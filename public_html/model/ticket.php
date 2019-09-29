<?php
namespace CTI;

class Ticket {
	
	private $nr;
	private $touroperator;
	private $tourcode;
	private $date;
	private $positions;
	
	function __construct($nr, $touroperator, $tourcode, $date, $positions) {
		$this->nr = $nr;
		$this->touroperator = $touroperator;
		$this->tourcode = $tourcode;
		$this->date = $date;
		$this->positions = $positions;
	}
	
	public function nr() {
		return $this->nr;
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
	
	private $nr;
	private $title;
	
	function __construct($nr, $title) {
		$this->nr = $nr;
		$this->title = $title;
	}
	
	public function nr() {
		return $this->nr;
	}
	
	public function title() {
		return $this->title;
	}
}
?>