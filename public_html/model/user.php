<?php
namespace CTI;

class User {
	
	private $username;
	private $firstname;
	private $lastname;
	
	function __construct(string $username, string $firstname, string $lastname) {
		$this->username = $username;
		$this->firstname = $firstname;
		$this->lastname = $lastname;
	}
	
	public function username() : string {
		return $this->username;
	}
	
	public function firstname() : string {
		return $this->firstname;
	}
	
	public function lastname() : string {
		return $this->lastname;
	}
	
	public function displayName() : string {
		return $this->firstname() . ' ' . $this->lastname();
	}

}

?>