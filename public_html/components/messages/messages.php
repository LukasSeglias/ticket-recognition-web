<?php
namespace CTI;

require_once './components/component.php';

class MessagesComponent implements Component {
	
	private $context;
	
	function __construct($context) {
		$this->context = $context;
	}
	
	public function template() : string {
		return 'messages/messages.html';
	}
	
	public function context() : array {
		return [
			'state' => new MessagesComponentState($this->context->messageService()->messages())
		];
	}
}

class MessagesComponentState {
	
	public $messages;
	
	function __construct(array $messages) {
		$this->messages = $messages;
	}
	
	public function messages() : array {
		return $this->messages;
	}
}
?>