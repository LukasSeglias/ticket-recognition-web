<?php
namespace CTI;

require_once './components/component.php';
require_once './components/state.php';

class LoginFormComponent implements Component {
	
	private $state;
	
	function __construct(LoginFormComponentState $state) {
		$this->state = $state;
	}
	
	public function template() : string {
		return 'login/login_form.html';
	}
	
	public function context() : array {
		return [
			'email' => $this->state->email(),
			'password' => $this->state->password()
		];
	}
}

class LoginFormComponentState {
	
	private $email;
	private $password;
	
	function __construct(InputComponentState $email, InputComponentState $password) {
		$this->email = $email;
		$this->password = $password;
	}
	
	public function email() : InputComponentState {
		return $this->email;
	}
	
	public function password() : InputComponentState {
		return $this->password;
	}
}
?>