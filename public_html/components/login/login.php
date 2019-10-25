<?php
namespace CTI;

require_once './components/page.php';
require_once './components/state.php';
require_once './validation/validation-result.php';
require_once './components/login/login_form.php';

class LoginPage implements Page {
	
	private $context;
	private $state;
	
	function __construct($context) {
		$this->context = $context;
	}

	public function update() {
		if($_GET['TEST'] !== NULL) {
			$this->context->router()->redirect('/tickets.php');
		} else {
			$this->state = new LoginFormComponentState(
				new InputComponentState('', ValidationResult::none(), false),
				new InputComponentState('', ValidationResult::none(), false)
			);
		}
		// TODO: update internal state in response to request before rendering
	}
	
	public function template() : string {
		return 'login/login.html';
	}
	
	public function context() : array {
		return [
			'form' => new LoginFormComponent($this->state)
		];
	}
}
?>