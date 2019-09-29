<?php
namespace CTI;

class User {
	
	private $username;
	private $firstname;
	private $lastname;
	
	function __construct($username, $firstname, $lastname) {
		$this->username = $username;
		$this->firstname = $firstname;
		$this->lastname = $lastname;
	}
	
	public function username() {
		return $this->username;
	}
	
	public function firstname() {
		return $this->firstname;
	}
	
	public function lastname() {
		return $this->lastname;
	}
	
	public function displayName() {
		return $this->firstname() . ' ' . $this->lastname();
	}

}

?>