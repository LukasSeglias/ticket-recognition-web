<?php
namespace CTI;

require_once './model/message.php';

class MessageService {
	
	private $messages; 

	function __construct() {
		$this->messages = [];
	}

	public function add(Message $message) {
		$this->messages[] = $message;
	}
	
	public function addAll(array $messages) {
		foreach ($messages as &$message) {
			$this->add($message);
		}
	}

	public function messages() : array {
		return $this->messages;
	}

}

?>