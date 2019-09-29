<?php
namespace CTI;

class LoginFormComponent implements Component {
	
	private $state;
	
	function __construct($state) {
		$this->state = $state;
	}
	
	public function template() {
		return 'login/login_form.html';
	}
	
	public function context() {
		return [
			'email' => $this->state->email(),
			'password' => $this->state->password()
		];
	}
}

class LoginFormComponentState {
	
	private $email;
	private $password;
	
	function __construct($email, $password) {
		$this->email = $email;
		$this->password = $password;
	}
	
	public function email() {
		return $this->email;
	}
	
	public function password() {
		return $this->password;
	}
}
?>